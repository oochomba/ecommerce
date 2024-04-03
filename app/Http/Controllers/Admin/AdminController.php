<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
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
  /**
   * list all system admins
   */
  public function index()
  {
    if (is_null($this->user) || !$this->user->can('admin.view')) {
      abort(403, 'Sorry !! Access denied !!');
    }

    $this->data['admins']     = User::where(['is_admin' => 1, 'is_delete' => 0])->orderBy("id", "desc")->get();
    $this->data['page_title'] = 'System Admins';
    return view('admin.admin.list', $this->data);
  }
  /**
   * add system admin
   */
  public function add()
  {
    if (is_null($this->user) || !$this->user->can('admin.create')) {
      abort(403, 'Sorry !! Access denied !!');
    }
    $this->data['roles']  = Role::all();
    $this->data['page_title'] = 'Add System Admin';
    return view('admin.admin.add', $this->data);
  }

  /**
   * store new admin info
   */
  public function store(Request $request)
  {
    if (is_null($this->user) || !$this->user->can('admin.create')) {
      abort(403, 'Sorry !! Access denied !!');
    }
    $rules = [
      'name'     => 'required',
      'email'    => 'required|email|unique:users',
      'password' => 'required|min:6',
      'roles' => 'required',
      'status'   => 'required',
    ];

    $request->validate($rules, [
      'name.required'   => 'Please enter admin name',
      'email.required'  => 'Please enter admin email',
      'roles.required' => 'Please select role',
      'status.required' => 'Please select admin status',
    ]);

    $admin = new User();
    $admin->name = $request->name;
    $admin->email = $request->email;
    $admin->password = Hash::make($request->password);
    $admin->status = $request->status;
    $admin->is_admin = 1;
    $admin->save();

    if ($request->roles) {
      $admin->assignRole($request->roles);
    }
    return redirect('admin/admin/list')->with('success', 'Admin successively created !!');
  }

  /**
   * edit admin details
   */
  public function edit($id)
  {
    if (is_null($this->user) || !$this->user->can('admin.edit')) {
      abort(403, 'Sorry !! Access denied !!');
    }
    if (!is_numeric($id)) {
      return redirect('admin/admin/list')->with('error', 'Some technical error occurred. Please try again later');
    }
    $this->data['admin'] = User::where(['id' => $id])->get()->first();
    if (empty($this->data['admin'])) {
      return redirect('admin/admin/list')->with('error', 'Some technical error occurred. Please try again later');
    }
    $this->data['roles']  = Role::all();
    $this->data['page_title'] = ucfirst($this->data['admin']->name);
    return view('admin.admin.edit', $this->data);
  }

  public function update($id, Request $request)
  {
    if (is_null($this->user) || !$this->user->can('admin.edit')) {
      abort(403, 'Sorry !! Access denied !!');
    }
    $rules = [
      'name'   => 'required',
      'email'  => 'required|email|unique:users,email,' . $id,
      'roles' => 'required',
      'status' => 'required',
    ];

    if ($request->password) {
      $rules = [
        'password' => 'required|min:6',
      ];
    }
    $request->validate($rules, [
      'name.required'   => 'Please enter admin name',
      'email.required'  => 'Please enter admin email',
      'status.required' => 'Please select admin status',
      'roles.required' => 'Please select role',
    ]);

    $admin = User::find($id);

    $admin->name = $request->name;
    $admin->email = $request->email;
    $admin->status = $request->status;
    $admin->is_admin = 1;

    if ($request->password) {
      $admin->password = Hash::make($request->password);
    }
    $admin->save();
    $admin->roles()->detach();
    if ($request->roles) {
      $admin->assignRole($request->roles);
    }
    return redirect('admin/admin/list')->with('success', 'Admin successively updated !!');
  }

  public function delete(int $id, Request $request)
  {
    if (is_null($this->user) || !$this->user->can('admin.delete')) {
      abort(403, 'Sorry !! Access denied !!');
    }
    if ($id == 1) {
      $json['status'] = false;
      $json['message'] = 'Super administrator can not be deleted';
    } else {
      $row = User::where(['id' => $id])->get()->first();
      if (!is_null($row)) {
        $deleteData = [
          'is_delete' => 1,
          'deleted_by' => Auth::user()->id,
          'deleted_on' => Carbon::now(),
        ];
        User::where('id', $id)->update($deleteData);
        $json['status'] = true;
        $json['message'] = 'Admin Deleted successfully';
        $json['redirect'] = url('admin/admin/list');
      } else {
        $json['status'] = false;
        $json['message'] = 'Some technical error occurred. Please try again later';
      }
    }
    echo json_encode($json);
  }
}
