<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BrandModel;
use Auth;
use Carbon\Carbon;


class BrandController extends Controller
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

        if (is_null(Auth::user()) || !Auth::user()->can('brand.view')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }

        $this->data['brands'] = BrandModel::select('brand.*', 'users.name as created_by_name')
            ->join('users', 'users.id', '=', 'brand.created_by')
            ->where(['brand.is_delete' => 0])
            ->orderBy("brand.id", "desc")
            ->paginate(100);

        $this->data['page_title'] = 'Brand';
        return view('admin.brand.list', $this->data);
    }


    /**
     * load add resource view
     */
    public function add()
    {
        if (is_null(Auth::user()) || !Auth::user()->can('brand.create')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }

        $this->data['page_title'] = 'Add brand';
        return view('admin.brand.add', $this->data);
    }

    /**
     * save resource info
     */
    public function store(Request $request)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('brand.create')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }

        $rules = [
            'name'     => 'required',
            'slug'    => 'required|unique:sub_category',
            'meta_title'    => 'required',
            'status'   => 'required',
        ];

        $request->validate($rules, [
            'name.required'   => 'Please enter brand name',
            'slug.required'  => 'Please enter brand slug',
            'status.required' => 'Please select brand status',
        ]);

        $saveData = [
            'name'     => trim($request->name),
            'slug'    => trim($request->slug),
            'status'   => trim($request->status),
            'meta_title'   => trim($request->meta_title),
            'meta_description'   => trim($request->meta_description),
            'meta_keywords'   => trim($request->meta_keywords),
            'created_by'   => Auth::user()->id,
        ];


        BrandModel::create($saveData);
        return redirect('admin/brand/list')->with('success', 'Brand ' . $request->name . ' created !!');
    }

    
    /**
     * edit resource details
     */
    public function edit($id)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('brand.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }

        if (!is_numeric($id)) {
            return redirect('admin/brand/list')->with('error', 'Some technical error occurred. Please try again later');
        }
        $this->data['brand'] = BrandModel::where(['id' => $id])->get()->first();
        if (empty($this->data['brand'])) {
            return redirect('admin/brand/list')->with('error', 'Some technical error occurred. Please try again later');
        }

        $this->data['page_title'] = ucfirst($this->data['brand']->name);
        return view('admin.brand.edit', $this->data);
    }

      /**
     * update entry
     */
    public function update($id, Request $request)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('brand.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }

        $rules = [
            'name'     => 'required',
            'slug'    => 'required|unique:brand,slug,' . $id,
            'meta_title'    => 'required',
            'status'   => 'required',
        ];

        $request->validate(
            $rules,
            [
                'name.required'   => 'Please enter brand name',
                'slug.required'  => 'Please enter brand slug',
                'status.required' => 'Please select brand status',
            ]
        );


        $updateDate = [
            'name'     => trim($request->name),
            'slug'    => trim($request->slug),
            'status'   => trim($request->status),
            'meta_title'   => trim($request->meta_title),
            'meta_description'   => trim($request->meta_description),
            'meta_keywords'   => trim($request->meta_keywords),
            'created_by'   => Auth::user()->id,
        ];


        BrandModel::where('id', $id)->update($updateDate);
        return redirect('admin/brand/list')->with('success', 'Brand successively updated !!');
    }

    /**
     * delete entry
     */
    public function delete(int $id, Request $request)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('brand.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }

        $row = BrandModel::where(['id' => $id])->get()->first();
        if (!is_null($row)) {
            $deleteData = [
                'is_delete' => 1,
                'deleted_by' => Auth::user()->id,
                'deleted_on' => Carbon::now(),
            ];
            BrandModel::where('id', $id)->update($deleteData);
            // $row->delete();
        }
    }
}
