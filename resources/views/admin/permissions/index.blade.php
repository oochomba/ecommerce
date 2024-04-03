@extends('admin.layouts.app')
@section('styles')
    <style type="text/css">
        .perm-listing ul {
            display: block;
        }

        .perm-listing ul li {
            list-style: square;
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
                        <li class="breadcrumb-item active">Permissions</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="content">
        <div class="container-fluid">
            @include('admin.layouts.partials._message')
            <div class="alert alert-success jsMessShow" role="alert" style="display:none">

            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="mt-2 mb-4">
                        <div class="row">
                            <div class="col-8">
                                @include('admin.layouts.partials._nav_links')
                            </div>
                            <div class="col-4">
                                @if (Auth::guard('admin')->user()->can('permission.create'))
                                    <a href="{{ url('admin/permission/add') }}"
                                        class="btn btn-sm btn-primary text-white pull-right"><i class="fa fa-plus"></i> Add
                                        permission
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div class="data-tables">
                        <table id="dataTable" class="table table-stripped table-condensed">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>S/N</th>
                                    <th>Group Name</th>
                                    <th>Permissions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permission_groups as $group)
                                    @php
                                        $permissions = App\User::getpermissionsByGroupName($group->name);
                                    @endphp
                                    <tr>
                                        <td> {{ $loop->iteration }} </td>
                                        <td> {{ $group->name }} </td>
                                        <td class="perm-listing">
                                            <ul>
                                                @foreach ($permissions as $permission)
                                                    <li>
                                                        {{ $permission->name }}
                                                        {{-- @if (Auth::guard('admin')->user()->can('permission.edit'))
                                                            <span class="ml-2 mr-2">
                                                                <a href="{{ url('permission/edit/' . $permission->id) }}"
                                                                    title="Edit {{ $permission->name }}"><i
                                                                        class="fa fa-pencil"></i></a>
                                                            </span>
                                                        @endif --}}
                                                        @if (Auth::guard('admin')->user()->can('permission.delete'))
                                                            <span class="ml-2 mr-2">
                                                                <a class="text text-danger" style="cursor: pointer" id=""
                                                                    data-id="{{ $permission->id }}"
                                                                    data-token={{ csrf_token() }}
                                                                    data-href="{{ url('admin/permission/delete/' . $permission->id) }}"
                                                                    data-formId="delete-form-{{ $permission->id }}"
                                                                    onclick="confirmDelete(this)" title="Delete permission">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>

            </div>


        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ url('assets/backend/js/custom.js') }}"></script>
@endsection
