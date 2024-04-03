<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\SubCategoryModel;
use App\Models\SubSubCategoryModel;
use Auth;
use Carbon\Carbon;

class SubSubCategoryController extends Controller
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
    public function index()
    {
        if (is_null(Auth::user()) || !Auth::user()->can('subSubCategory.view')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $this->data['sub_categories'] = SubSubCategoryModel::select('sub_subCategory.*', 'users.name as created_by_name', 'category.name as category_name', 'sub_category.name as sub_category_name')
            ->join('sub_category', 'sub_category.id', '=', 'sub_subCategory.sub_category_id')
            ->join('category', 'category.id', '=', 'sub_category.category_id')
            ->join('users', 'users.id', '=', 'sub_subCategory.created_by')
            ->where(['sub_subCategory.is_delete' => 0])
            ->orderBy("sub_subCategory.id", "asc")
            ->get();

        $this->data['page_title'] = 'Sub Sub-Categories';
        return view('admin.sub_SubCategory.list', $this->data);
    }

    /**
     * add product sub category
     */
    public function add()
    {
        if (is_null(Auth::user()) || !Auth::user()->can('subSubCategory.create')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        //get parent categories
        $this->data['categories'] = CategoryModel::where(['is_delete' => 0, 'status' => 0])->get()->toArray();
        if ($this->data['categories'] == null) {
            return redirect('admin/category/add')->with('error', 'Please set the Category first before adding sub categories');
        }

        // $this->data['sub_categories'] = SubCategoryModel::where(['is_delete' => 0, 'status' => 0])->get()->toArray();
        // if ($this->data['sub_categories'] == null) {
        //     return redirect('admin/sub_category/add')->with('error', 'Please set the sub  category first before adding sub sub-categories');
        // }
        $this->data['page_title'] = 'Add Sub Sub-Category';
        // var_dump($this->data['categories']);die;
        return view('admin.sub_SubCategory.add', $this->data);
    }


    /**
     * save resource info
     */
    public function store(Request $request)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('subCategory.create')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $rules = [
            'category_id'     => 'required',
            'sub_category_id'     => 'required',
            'name'     => 'required|unique:sub_subCategory',
            'slug'    => 'required|unique:sub_subCategory',
            'meta_title'    => 'required',
            'status'   => 'required',
        ];

        $request->validate($rules, [
            'category_id.required'   => 'Please select category',
            'sub_category_id.required'   => 'Please select sub category',
            'name.required'   => 'Please enter sub sub-category name',
            'slug.required'  => 'Please enter sub sub-category slug',
            'status.required' => 'Please select product status',
        ]);
        $newSlug = str_replace(' ', '-', trim($request->slug));

        $saveData = [
            'category_id'     => trim($request->category_id),
            'sub_category_id'     => trim($request->sub_category_id),
            'name'     => trim($request->name),
            'slug'    => $newSlug,
            'status'   => trim($request->status),
            'meta_title'   => trim($request->meta_title),
            'meta_description'   => trim($request->meta_description),
            'meta_keywords'   => trim($request->meta_keywords),
            'created_by'   => Auth::user()->id,
        ];
        // dd($saveData);
        SubSubCategoryModel::create($saveData);
        return redirect('admin/sub_SubCategory/list')->with('success', 'Product sub sub-category created !!');
    }

    /**
     * edit resource details
     */
    public function edit($id)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('subCategory.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        if (!is_numeric($id)) {
            return redirect('admin/sub_SubCategory/list')->with('error', 'Some technical error occurred. Please try again later');
        }
        $this->data['sub_category'] = SubSubCategoryModel::where(['id' => $id, 'is_delete' => 0])->get()->first();
        if (empty($this->data['sub_category'])) {
            return redirect('admin/sub_SubCategory/list')->with('error', 'Some technical error occurred. Please try again later');
        }
        //get parent categories
        $this->data['categories'] = CategoryModel::getCategories();
        if ($this->data['categories'] == null) {
            return redirect('admin/category/add')->with('error', 'Please set the Category first before adding sub categories');
        }

        $this->data['sub_categories'] = SubCategoryModel::where(['status' => 0, 'is_delete' => 0, 'category_id' => $this->data['sub_category']->category_id])
            ->orderBy('name', 'asc')
            ->get();

        $this->data['page_title'] = ucfirst($this->data['sub_category']->name);
        return view('admin.sub_SubCategory.edit', $this->data);
    }
    /**
     * update entry
     */
    public function update($id, Request $request)
    {

        if (is_null(Auth::user()) || !Auth::user()->can('subCategory.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $rules = [
            'category_id'     => 'required',
            'sub_category_id'     => 'required',
            'name'     => 'required',
            'slug'    => 'required|unique:category,slug,' . $id,
            'meta_title'    => 'required',
            'status'   => 'required',
        ];

        $request->validate(
            $rules,
            [
                'sub_category_id.required'   => 'Please select sub category',
                'category_id.required'   => 'Please select category',
                'name.required'   => 'Please enter name',
                'slug.required'  => 'Please enter slug',
                'status.required' => 'Please select status',
            ]
        );
        $newSlug = str_replace(' ', '-', trim($request->slug));


        $updateData = [
            'category_id'     => trim($request->category_id),
            'sub_category_id'     => trim($request->sub_category_id),
            'name'     => trim($request->name),
            'slug'    => $newSlug,
            'status'   => trim($request->status),
            'meta_title'   => trim($request->meta_title),
            'meta_description'   => trim($request->meta_description),
            'meta_keywords'   => trim($request->meta_keywords),
            'created_by'   => Auth::user()->id,
        ];
        SubSubCategoryModel::where('id', $id)->update($updateData);
        return redirect('admin/sub_SubCategory/list')->with('success', 'Sub Sub-Category successively updated !!');
    }

    /**
     * delete entry
     */
    public function delete(int $id, Request $request)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('subCategory.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }

        $row = SubSubCategoryModel::where(['id' => $id])->get()->first();
        if (!is_null($row)) {
            $deleteData = [
                'is_delete' => 1,
                'deleted_by' => Auth::user()->id,
                'deleted_on' => Carbon::now(),
            ];
            SubSubCategoryModel::where('id', $id)->update($deleteData);
            // $row->delete();

        }
        $json['success'] = true;
        $json['redirect'] = url('admin/sub_SubCategory/list');
        echo json_encode($json);
    }

    public function get_sub_subcategory(Request $request)
    {
        $sub_categories = SubSubCategoryModel::select('sub_subCategory.*')
            ->join('users', 'users.id', '=', 'sub_subCategory.created_by')
            ->where(['sub_subCategory.status' => 0])
            ->where(['sub_subCategory.is_delete' => 0])
            ->where(['sub_subCategory.sub_category_id' => $request->id])
            ->orderBy("sub_subCategory.name", "asc")
            ->get();
            // dd($sub_categories);
        $html = '';
        $html .= '<option value="">Select Sub Sub-Category</option>';
        foreach ($sub_categories as $sub_category) {
            $html .= '<option value="' . $sub_category->id . '">' . $sub_category->name . '</option>';
        }
        $json['html'] = $html;
        echo json_encode($json);
    }
}
