<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Auth;
use Carbon\Carbon;
use App\User;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
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

        if (is_null(Auth::user()) || !Auth::user()->can('role.view')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }

        $this->data['roles'] = Role::all();
        $this->data['page_title'] = 'Roles';
        return view('admin.roles.index', $this->data);
    }


    /**
     * load add resource view
     */
    public function add()
    {
        if (is_null($this->user) || !$this->user->can('role.create')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page !');
        }

        $this->data['all_permissions']  = Permission::all();

        $this->data['permission_groups'] = User::getpermissionGroups();

        $this->data['page_title'] = 'Add new role';
        return view('admin.roles.create', $this->data);
    }

    /**
     * save resource info
     */
    public function store(Request $request)
    {

        if (is_null($this->user) || !$this->user->can('role.create')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }

        $request->validate([
            'name' => 'required|max:100|unique:roles'
        ], [
            'name.required' => 'Please give a role name'
        ]);


        // Process Data
        $role = Role::create(['name' => $request->name, 'guard_name' => 'admin']);

        // $role = DB::table('roles')->where('name', $request->name)->first();
        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }
        return redirect('admin/roles')->with('success', 'Role created Successfully');
    }


    /**
     * edit resource details
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('role.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page !');
        }

        $this->data['role'] = Role::findById($id, 'admin');
        $this->data['all_permissions'] = Permission::all();
        $this->data['permission_groups'] = User::getpermissionGroups();

        $this->data['page_title'] = ucfirst($this->data['role']->name);
        return view('admin.roles.edit', $this->data);
    }

    /**
     * update entry
     */
    public function update($id, Request $request)
    {
        if (is_null($this->user) || !$this->user->can('role.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page !');
        }
        $request->validate([
            'name' => 'required|max:100|unique:roles,name,' . $id
        ], [
            'name.required' => 'Please give a role name'
        ]);

        $role = Role::findById($id, 'admin');
        if (empty($role)) {
            return redirect('admin/roles')->with('error', 'Some technical error occurred. Please try again later');
        }

        $role->name = $request->name;
        $role->save();
        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }
        return redirect('admin/roles')->with('success', 'Role successively updated !!');
    }

    /**
     * delete entry
     */
    public function delete(int $id, Request $request)
    {
        if (is_null($this->user) || !$this->user->can('role.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to perform this action !');
        }
        $row = Role::where(['id' => $id])->get()->first();
        if (!is_null($row)) {
            $row->delete();
        }
    }

    public function permission()
    {
        if (is_null($this->user) || !$this->user->can('permission.view')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page !');
        }
        $this->data['all_permissions'] = Permission::all();
        $this->data['permission_groups'] = User::getpermissionGroups();
        $this->data['page_title'] = 'Permissions';
        return view('admin.permissions.index', $this->data);
    }
    public function permission_add(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('permission.create')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page !');
        }
        $this->data['page_title'] = 'Add Permissions';
        return view('admin.permissions.create', $this->data);
    }

    public function permission_store(Request $request)
    {
        $request->validate([
            'guard_name' => 'required',
            'group_name' => 'required',
            'name' => 'required'
        ], [
            'name.required' => 'Please enter the permission name',
            'guard_name.required' => 'Please select the guard name',
            'group_name.required' => 'Please enter permission group name',
        ]);

        $permission = [
            'guard_name' => $request->guard_name,
            'group_name' => $request->group_name,
            'name' => $request->group_name . '.' . $request->name
        ];
        $permissionCheck = Permission::getPermission(['name' => $permission['name']]);
        if (!empty($permissionCheck)) {
            return redirect()->back()->with('error', 'Permission ' . $request->name . ' exists for guard ' . $permissionCheck->guard_name);
        }
        Permission::create($permission);
        return redirect('admin/permission')->with('success', 'Permission has been created');
    }
    public function permission_store_crud(Request $request)
    {
        $request->validate([
            'guard_name_crud' => 'required',
            'group_name_crud' => 'required',
            'name_crud' => 'required'
        ], [
            'name_crud.required' => 'Please select permission(s)',
            'guard_name_crud.required' => 'Please select the guard name',
            'group_name_crud.required' => 'Please enter permission group name',
        ]);


        if (!empty($request->name_crud)) {
            foreach ($request->name_crud as $p_name) {
                $permission = new Permission();
                $permission->guard_name = trim($request->guard_name_crud);
                $permission->group_name = trim($request->group_name_crud);
                $permission->name = trim($request->group_name_crud) . '.' . trim($p_name);
                $permission->save();
            }
        }
        return redirect('admin/permission')->with('success', 'Permission has been created');
    }


    public function permission_delete($id)
    {
        if (is_null($this->user) || !$this->user->can('permission.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to perform this action !');
        }
        $row = Permission::getPermission(['id' => $id]);
        if (!is_null($row)) {
            $row->delete();
        }
    }
}
