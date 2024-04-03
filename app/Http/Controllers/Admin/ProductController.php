<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\SubCategoryModel;
use App\Models\SubSubCategoryModel;
use App\Models\ProductColorModel;
use App\Models\ProductSizeModel;
use App\Models\ProductImageModel;
use App\Models\ColorModel;
use Auth;
use Str;


class ProductController extends Controller
{
    var $data;
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }
    //
    public function index()
    {
        if (is_null(Auth::user()) || !Auth::user()->can('product.view')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }

        $this->data['products'] = ProductModel::select('product.*', 'users.name as created_by_name', 'category.name as category_name', 'sub_category.name as sub_category_name', 'brand.name as brand')
            ->join('users', 'users.id', '=', 'product.created_by')
            ->join('category', 'category.id', '=', 'product.category_id')
            ->join('sub_category', 'sub_category.id', '=', 'product.sub_category_id')
            ->join('brand', 'brand.id', '=', 'product.brand_id')
            ->where(['product.is_delete' => 0])
            ->orderBy("product.id", "desc")->paginate(20);
        // var_dump($this->data['categories']);
        // die;
        $this->data['page_title'] = 'Product list';
        return view('admin.product.list', $this->data);
    }
    /**
     * add product
     */
    public function add()
    {
        if (is_null(Auth::user()) || !Auth::user()->can('product.create')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $this->data['page_title'] = 'Add product';
        return view('admin.product.add', $this->data);
    }

    /**
     * save resource info
     */
    public function store(Request $request)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('product.create')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $rules = [
            'title'     => 'required|unique:product',
        ];

        $request->validate($rules, [
            'title.required'   => 'Please enter product title',
        ]);

        $product = new ProductModel();
        $title = trim($request->title);
        $product->title = $title;
        $product->created_by = Auth::user()->id;
        $product->save();
        //generate slug
        $slug = Str::slug(str_replace(' ', '-', $title));

        $checkSlugExists = ProductModel::where('slug', $slug)->first();
        if ($checkSlugExists == null) {
            $product->slug = $slug;
            $product->save();
        } else {
            $product->slug = $slug . '-' . $product->id;
            $product->save();
        }
        return redirect('admin/product/edit/' . $product->id)->with('success', 'Product ' . $product->title . ' created !!');
    }

    /**
     * edit product details
     */
    public function edit($id)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('product.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        if (!is_numeric($id)) {
            return redirect('admin/product/list')->with('error', 'Some technical error occurred. Please try again later');
        }
        $this->data['product'] = ProductModel::where(['id' => $id])->get()->first();
        if (empty($this->data['product'])) {
            return redirect('admin/product/list')->with('error', 'Some technical error occurred. Please try again later');
        }
        //check categories set if not redirect with error
        $this->data['categories'] = CategoryModel::where(['is_delete' => 0])->orderBy('name', 'asc')->get()->toArray();
        if ($this->data['categories'] == null) {
            return redirect('admin/category/add')->with('error', 'Please set the Category first before adding sub categories');
        }

        //get sub categories
        $this->data['sub_categories'] = SubCategoryModel::where(['status' => 0, 'is_delete' => 0, 'category_id' => $this->data['product']->category_id])
            ->orderBy('name', 'asc')
            ->get();


        //get sub categories
        $this->data['sub_subcategories'] = SubSubCategoryModel::where(['status' => 0, 'is_delete' => 0, 'category_id' => $this->data['product']->category_id, 'sub_category_id' => $this->data['product']->sub_category_id])
            ->orderBy('name', 'asc')
            ->get();

        //get brands
        $this->data['brands'] = BrandModel::where(['is_delete' => 0, 'status' => 0])->orderBy('name', 'asc')->get()->toArray();

        //get colors
        $this->data['colors'] = ColorModel::where(['is_delete' => 0, 'status' => 0])->orderBy('name', 'asc')->get()->toArray();

        $this->data['page_title'] = ucfirst($this->data['product']->title);
        return view('admin.product.edit', $this->data);
    }


    /**
     * update entry
     */
    public function update($id, Request $request)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('product.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $product = ProductModel::where(['id' => $id])->get()->first();
        if (empty($product)) {
            return redirect('admin/product/list')->with('error', 'Some technical error occurred. Please try again later');
        }

        // $rules = [
        //     'name'     => 'required',
        //     'slug'    => 'required|unique:brand,slug,' . $id,
        //     'meta_title'    => 'required',
        //     'status'   => 'required',
        // ];

        // $request->validate(
        //     $rules,
        //     [
        //         'name.required'   => 'Please enter brand name',
        //         'slug.required'  => 'Please enter brand slug',
        //         'status.required' => 'Please select brand status',
        //     ]
        // );

        $updateData = [
            'title'     => trim($request->title),
            'slug'    => Str::slug(trim($request->title)),
            'sku'   => trim($request->sku),
            'category_id'   => trim($request->category_id),
            'sub_category_id'   => trim($request->sub_category_id),
            'sub_subcategory_id'   => trim($request->sub_subcategory_id),
            'brand_id'   => trim($request->brand_id),
            'price'   => !empty($request->price) ? trim($request->price) : 0,
            'old_price'   => !empty($request->old_price) ? trim($request->old_price) : 0,
            'short_description'   => trim($request->short_description),
            'description'   => trim($request->description),
            'additional_description'   => trim($request->additional_description),
            'tag' => trim($request->tag),
            'status'   => trim($request->status),
            'created_by'   => Auth::user()->id,
        ];

        ProductModel::where('id', $id)->update($updateData);

        //delete existing colors
        ProductColorModel::where(['product_id' => $id])->delete();

        if (!empty($request->color_id)) {
            foreach ($request->color_id as $color_id) {
                $color = new ProductColorModel();
                $color->color_id = $color_id;
                $color->product_id = $id;
                $color->save();
            }
        }

        //delete existing sizes
        ProductSizeModel::where(['product_id' => $id])->delete();
        if (!empty($request->size)) {
            foreach ($request->size as $size) {
                $size = (object)$size;
                if (!empty($size->name)) {
                    $saveSize = new ProductSizeModel();
                    $saveSize->name = $size->name;
                    $saveSize->price = !empty($size->price) ? $size->price : 0;
                    $saveSize->product_id = $id;
                    $saveSize->save();
                }
            }
        }
        //product images upload
        if (!empty($request->file('image'))) {
            foreach ($request->file('image') as $file) {
                if ($file->isValid()) {
                    $ext = $file->getClientOriginalExtension();
                    $randomStr = $product->id . Str::random(10);
                    $filename = $randomStr . '.' . $ext;


                    //save images data only if image files have successively uploaded
                    if (!$file->move('uploads/products', $filename)) {
                        return redirect()->back()->with('error', 'error occurred while uploading your product image!!');
                    }

                    $imageUpload = new ProductImageModel();
                    $imageUpload->product_id = $product->id;
                    $imageUpload->image_name = $filename;
                    $imageUpload->image_extension = $ext;
                    $imageUpload->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Product successively updated !!');
    }

    /**
     * delete product image
     */
    public function deleteProductImage($id)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('product.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $image = ProductImageModel::where(['id' => $id])->get()->first();
        if (!empty($image->getImageInfo())) {
            unlink('uploads/products/' . $image->image_name);
        }
        $image->delete();
    }

    /**
     * sort product images
     */
    public function productImageSortable(Request $request)
    {
        if (!empty($request->photo_id)) {
            $i = 1;
            foreach ($request->photo_id as $photo_id) {
                $image = ProductImageModel::where(['id' => $photo_id])->get()->first();
                $image->order_by = $i;
                $image->save();
                $i++;
            }
        }
        $json['success'] = true;
        echo json_encode($json);
    }
}
