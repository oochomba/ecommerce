@extends('admin.layouts.app')
@section('styles')
    <style type="text/css">
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
                        <li class="breadcrumb-item active">Add new role</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">
        <div class="container-fluid">

            <!-- data table start -->
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Create New Role</h4>

                        <form action="{{ url('admin/roles/add') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name">Role Name</label>
                                <input type="text" value="{{ old('name') }}"
                                    class="form-control  {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name"
                                    name="name" placeholder="Enter a Role Name">
                                @if ($errors->has('name'))
                                    <span class="invalid feedback text text-danger" role="alert">
                                        {{ $errors->first('name') }}.
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="name">Permissions</label>

                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1">
                                    <label class="form-check-label" for="checkPermissionAll">All</label>
                                </div>
                                <hr>
                                <div class="row">
                                    @php $i = 1; @endphp
                                    @foreach ($permission_groups as $group)
                                        <div class="col-3 perm-listing">
                                            <ul class="row">
                                                <li style="font-weight:600;">
                                                    <span class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="{{ $i }}Management" value="{{ $group->name }}"
                                                            onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)">
                                                        <label class="form-check-label"
                                                            for="checkPermission">{{ $group->name }}</label>
                                                    </span>

                                                </li>
                                                <li class="" style="margin-left: 15%">
                                                    <div class="role-{{ $i }}-management-checkbox">
                                                        @php
                                                            $permissions = App\User::getpermissionsByGroupName(
                                                                $group->name,
                                                            );
                                                            $j = 1;
                                                        @endphp
                                                        @foreach ($permissions as $permission)
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="permissions[]"
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


                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Create and assign</button>
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
