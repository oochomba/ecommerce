@extends('admin.layouts.app')
@section('styles')
    <style>
        .form-check-label {
            text-transform: capitalize;
        }

        .perm-listing ul {
            display: block
        }

        .perm-listing ul li {
            /* display: inline-block !important; */
            vertical-align: top;
            list-style: none;
        }
    </style>
@endsection


@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ !empty($page_title) ? $page_title : 'Ecommerce' }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ url('admin/roles') }}">Roles</a></li>
                        <li class="breadcrumb-item active">Edit role - $role->name</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->







    <!-- page title area end -->
    <div class="content">
        <div class="container-fluid">

            <!-- data table start -->
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Edit Role</h4>
                        @include('admin.layouts.partials._message')

                        <form action="{{ url('admin/roles/edit', $role->id) }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name">Role Name</label>
                                <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    id="name" value="{{ $role->name }}" name="name"
                                    placeholder="Enter a Role Name">
                                @if ($errors->has('name'))
                                    <span class="invalid feedback text text-danger" role="alert">
                                        {{ $errors->first('name') }}.
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="name">Permissions</label>

                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1"
                                        {{ App\User::roleHasPermissions($role, $all_permissions) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="checkPermissionAll">All</label>
                                </div>
                                <hr>


                                <div class="row">
                                    @php $i = 1; @endphp
                                    @foreach ($permission_groups as $group)
                                        <div class="col-3 perm-listing">
                                            <ul class="row">
                                                @php
                                                    $permissions = App\User::getpermissionsByGroupName($group->name);
                                                    $j = 1;
                                                @endphp

                                                <li style="font-weight:600;">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="{{ $i }}Management" value="{{ $group->name }}"
                                                            onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)"
                                                            {{ App\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="checkPermission">{{ $group->name }}</label>
                                                    </div>
                                                </li>

                                                <li class="" style="margin-left: 15%">
                                                    <div class="role-{{ $i }}-management-checkbox">

                                                        @foreach ($permissions as $permission)
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
                                                                    onclick="checkSinglePermission('role-{{ $i }}-management-checkbox', '{{ $i }}Management', {{ count($permissions) }})"
                                                                    name="permissions[]"
                                                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                                                    id="checkPermission{{ $permission->id }}"
                                                                    value="{{ $permission->name }}">
                                                                <label class="form-check-label"
                                                                    for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                                            </div>
                                                            @php  $j++; @endphp
                                                        @endforeach
                                                        <br>
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>
                                        @php  $i++; @endphp
                                    @endforeach
                                </div>


                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Update Role</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- data table end -->

        </div>
    </div>
@endsection


@section('scripts')
    @include('admin.roles.partials.scripts')
@endsection
