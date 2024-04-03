@if (Auth::guard('admin')->user()->can('admin.view'))
    <a href="{{ url('admin/admin/list') }}" class="btn btn-info btn-sm">Admins</a>
@endif
@if (Auth::guard('admin')->user()->can('role.view'))
    <a href="{{ url('admin/roles') }}" class="btn btn-success btn-sm">Roles</a>
@endif
@if (Auth::guard('admin')->user()->can('permission.view'))
    <a href="{{ url('admin/permission') }}" class="btn btn-danger btn-sm">Permissions</a>
@endif
