<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\SubCategoryModel;
use Auth;
use Carbon\Carbon;

class SubCategoryController extends Controller
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
        if (is_null(Auth::user()) || !Auth::user()->can('subCategory.view')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $this->data['sub_categories'] = SubCategoryModel::select('sub_category.*', 'users.name as created_by_name', 'category.name as category_name')
            ->join('category', 'category.id', '=', 'sub_category.category_id')
            ->join('users', 'users.id', '=', 'sub_category.created_by')
            ->where(['sub_category.is_delete' => 0])
            ->orderBy("sub_category.id", "asc")
            ->get();

        $this->data['page_title'] = 'Sub Categories';
        return view('admin.sub_category.list', $this->data);
    }

    /**
     * add product sub category
     */
    public function add()
    {
        if (is_null(Auth::user()) || !Auth::user()->can('subCategory.create')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        //get parent categories
        $this->data['categories'] = CategoryModel::where(['is_delete' => 0])->get()->toArray();
        if ($this->data['categories'] == null) {
            return redirect('admin/category/add')->with('error', 'Please set the Category first before adding sub categories');
        }
        $this->data['page_title'] = 'Add Sub Category';
        // var_dump($this->data['categories']);die;
        return view('admin.sub_category.add', $this->data);
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
            'name'     => 'required',
            'slug'    => 'required|unique:sub_category',
            'meta_title'    => 'required',
            'status'   => 'required',
        ];

        $request->validate($rules, [
            'category_id.required'   => 'Please select product category',
            'name.required'   => 'Please enter product name',
            'slug.required'  => 'Please enter product slug',
            'status.required' => 'Please select product status',
        ]);
        $newSlug = str_replace(' ', '-', trim($request->slug));

        $saveData = [
            'category_id'     => trim($request->category_id),
            'name'     => trim($request->name),
            'slug'    => $newSlug,
            'status'   => trim($request->status),
            'meta_title'   => trim($request->meta_title),
            'meta_description'   => trim($request->meta_description),
            'meta_keywords'   => trim($request->meta_keywords),
            'created_by'   => Auth::user()->id,
        ];

        // var_dump($saveData);die;

        SubCategoryModel::create($saveData);
        return redirect('admin/sub_category/list')->with('success', 'Product sub category created !!');
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
            return redirect('admin/sub_category/list')->with('error', 'Some technical error occurred. Please try again later');
        }
        $this->data['sub_category'] = SubCategoryModel::where(['id' => $id])->get()->first();
        if (empty($this->data['sub_category'])) {
            return redirect('admin/sub_category/list')->with('error', 'Some technical error occurred. Please try again later');
        }
        //get parent categories
        $this->data['categories'] = CategoryModel::where(['is_delete' => 0])->get()->toArray();
        if ($this->data['categories'] == null) {
            return redirect('admin/category/add')->with('error', 'Please set the Category first before adding sub categories');
        }

        $this->data['page_title'] = ucfirst($this->data['sub_category']->name);
        return view('admin.sub_category.edit', $this->data);
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
            'name'     => 'required',
            'slug'    => 'required|unique:category,slug,' . $id,
            'meta_title'    => 'required',
            'status'   => 'required',
        ];

        $request->validate(
            $rules,
            [
                'category_id.required'   => 'Please select product category',
                'name.required'   => 'Please enter product name',
                'slug.required'  => 'Please enter product slug',
                'status.required' => 'Please select product status',
            ]
        );
        $newSlug = str_replace(' ', '-', trim($request->slug));


        $updateDate = [
            'category_id'     => trim($request->category_id),
            'name'     => trim($request->name),
            'slug'    => $newSlug,
            'status'   => trim($request->status),
            'meta_title'   => trim($request->meta_title),
            'meta_description'   => trim($request->meta_description),
            'meta_keywords'   => trim($request->meta_keywords),
            'created_by'   => Auth::user()->id,
        ];


        SubCategoryModel::where('id', $id)->update($updateDate);
        return redirect('admin/sub_category/list')->with('success', 'Sub Category successively updated !!');
    }

    /**
     * delete entry
     */
    public function delete(int $id, Request $request)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('subCategory.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }

        $row = SubCategoryModel::where(['id' => $id])->get()->first();
        if (!is_null($row)) {
            $deleteData = [
                'is_delete' => 1,
                'deleted_by' => Auth::user()->id,
                'deleted_on' => Carbon::now(),
            ];
            SubCategoryModel::where('id', $id)->update($deleteData);
            // $row->delete();
        }
        return redirect('admin/sub_category/list')->with('success', 'Some technical error occurred. Please try again later !!');
    }

    public function get_sub_category(Request $request)
    {
        $sub_categories = SubCategoryModel::select('sub_category.*')
            ->join('users', 'users.id', '=', 'sub_category.created_by')
            ->where(['sub_category.status' => 0])
            ->where(['sub_category.is_delete' => 0])
            ->where(['sub_category.category_id' => $request->id])
            ->orderBy("sub_category.name", "asc")
            ->get();
        $html = '';
        $html .= '<option value="">Select Sub Category</option>';
        foreach ($sub_categories as $sub_category) {
            $html .= '<option value="' . $sub_category->id . '">' . $sub_category->name . '</option>';
        }
        $json['html'] = $html;
        echo json_encode($json);
    }
}
