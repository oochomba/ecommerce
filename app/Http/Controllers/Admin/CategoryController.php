<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\User;
use Auth;
use Carbon\Carbon;

class CategoryController extends Controller
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
        if (is_null(Auth::user()) || !Auth::user()->can('category.view')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $this->data['categories'] = CategoryModel::select('category.*', 'users.name as created_by_name')
            ->join('users', 'users.id', '=', 'category.created_by')
            ->where(['category.is_delete' => 0])
            ->orderBy("category.id", "desc")->get();
        // var_dump($this->data['categories']);
        // die;
        $this->data['page_title'] = 'Product Categories';
        return view('admin.category.list', $this->data);
    }
    /**
     * add product category
     */
    public function add()
    {
        if (is_null(Auth::user()) || !Auth::user()->can('category.create')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $this->data['page_title'] = 'Add Category';
        return view('admin.category.add', $this->data);
    }

    /**
     * save resource info
     */
    public function store(Request $request)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('category.create')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $rules = [
            'name'     => 'required',
            'slug'    => 'required|unique:category',
            'meta_title'    => 'required',
            'status'   => 'required',
        ];

        $request->validate($rules, [
            'name.required'   => 'Please enter product name',
            'slug'  => 'Please enter product slug',
            'status.required' => 'Please select product status',
        ]);
        $newSlug = str_replace(' ', '-', trim($request->slug));


        $saveData = [
            'name'     => trim($request->name),
            'slug'    =>  $newSlug,
            'status'   => trim($request->status),
            'meta_title'   => trim($request->meta_title),
            'meta_description'   => trim($request->meta_description),
            'meta_keywords'   => trim($request->meta_keywords),
            'created_by'   => Auth::user()->id,
        ];

        CategoryModel::create($saveData);
        return redirect('admin/category/list')->with('success', 'Product category created !!');
    }

    /**
     * edit  details
     */
    public function edit($id)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('category.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        if (!is_numeric($id)) {
            return redirect('admin/category/list')->with('error', 'Some technical error occurred. Please try again later');
        }
        $this->data['category'] = CategoryModel::where(['id' => $id])->get()->first();
        if (empty($this->data['category'])) {
            return redirect('admin/category/list')->with('error', 'Some technical error occurred. Please try again later');
        }
        $this->data['page_title'] = ucfirst($this->data['category']->name);
        return view('admin.category.edit', $this->data);
    }

    /**
     * update category
     */
    public function update($id, Request $request)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('category.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $rules = [
            'name'     => 'required',
            'slug'    => 'required|unique:category,slug,' . $id,
            'meta_title'    => 'required',
            'status'   => 'required',
        ];

        $request->validate($rules, [
            'name.required'   => 'Please enter product name',
            'slug'  => 'Please enter product slug',
            'status.required' => 'Please select product status',
            'meta_title.required' => 'Please enter meta title',
        ]);

        $newSlug = str_replace(' ', '-', trim($request->slug));

        $updateData = [
            'name'     => trim($request->name),
            'slug'    => $newSlug,
            'status'   => trim($request->status),
            'meta_title'   => trim($request->meta_title),
            'meta_description'   => trim($request->meta_description),
            'meta_keywords'   => trim($request->meta_keywords),
            'created_by'   => Auth::user()->id,
        ];


        CategoryModel::where('id', $id)->update($updateData);
        return redirect('admin/category/list')->with('success', 'Category successively updated !!');
    }
    /**
     * delete category
     */
    public function delete(int $id, Request $request)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('category.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }

        $row = CategoryModel::where(['id' => $id])->get()->first();
        if (!is_null($row)) {
            $deleteData = [
                'is_delete' => 1,
                'deleted_by' => Auth::user()->id,
                'deleted_on' => Carbon::now(),
            ];
            // CategoryModel::where('id', $id)->update($deleteData);
            $row->delete();
        }
        return redirect('admin/category/list')->with('success', 'Some technical error occurred. Please try again later !!');
    }
}
