<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ColorModel;
use Auth;
use Carbon\Carbon;

class ColorController extends Controller
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
        if (is_null(Auth::user()) || !Auth::user()->can('color.view')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }

        $this->data['colors'] = ColorModel::select('color.*', 'users.name as created_by_name')
            ->join('users', 'users.id', '=', 'color.created_by')
            ->where(['color.is_delete' => 0])
            ->orderBy("color.id", "desc")
            ->paginate(100);

        $this->data['page_title'] = 'Product Colors';
        return view('admin.color.list', $this->data);
    }


    /**
     * load add resource view
     */
    public function add()
    {
        if (is_null(Auth::user()) || !Auth::user()->can('color.create')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $this->data['page_title'] = 'Add color';
        return view('admin.color.add', $this->data);
    }

    /**
     * save resource info
     */
    public function store(Request $request)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('color.create')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $rules = [
            'name'     => 'required',
            'code'    => 'required|unique:color',
            'status'   => 'required',
        ];

        $request->validate($rules, [
            'name.required'   => 'Please enter color name',
            'code.required'  => 'Please enter color code',
            'status.required' => 'Please select color status',
        ]);

        $saveData = [
            'name'     => trim($request->name),
            'code'    => trim($request->code),
            'status'   => trim($request->status),
            'created_by'   => Auth::user()->id,
        ];

        ColorModel::create($saveData);
        return redirect('admin/color/list')->with('success', 'Color ' . $request->name . ' created !!');
    }


    /**
     * edit resource details
     */
    public function edit($id)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('color.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        if (!is_numeric($id)) {
            return redirect('admin/color/list')->with('error', 'Some technical error occurred. Please try again later');
        }
        $this->data['color'] = ColorModel::where(['id' => $id])->get()->first();
        if (empty($this->data['color'])) {
            return redirect('admin/color/list')->with('error', 'Some technical error occurred. Please try again later');
        }

        $this->data['page_title'] = ucfirst($this->data['color']->name);
        return view('admin.color.edit', $this->data);
    }

    /**
     * update entry
     */
    public function update($id, Request $request)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('color.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $rules = [
            'name'     => 'required',
            'code'    => 'required|unique:color,code,' . $id,
            'status'   => 'required',
        ];

        $request->validate(
            $rules,
            [
                'name.required'   => 'Please enter color name',
                'code.required'  => 'Please enter color code',
                'status.required' => 'Please select color status',
            ]
        );


        $updateDate = [
            'name'     => trim($request->name),
            'code'    => trim($request->code),
            'status'   => trim($request->status),
            'created_by'   => Auth::user()->id,
        ];


        ColorModel::where('id', $id)->update($updateDate);
        return redirect('admin/color/list')->with('success', 'Color successively updated !!');
    }

    /**
     * delete entry
     */
    public function delete(int $id, Request $request)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('color.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $row = ColorModel::where(['id' => $id])->get()->first();
        if (!is_null($row)) {
            $deleteData = [
                'is_delete' => 1,
                'deleted_by' => Auth::user()->id,
                'deleted_on' => Carbon::now(),
            ];
            ColorModel::where('id', $id)->update($deleteData);
            // $row->delete();
        }
        return redirect('admin/color/list')->with('success', 'Some technical error occurred. Please try again later !!');
    }
}
