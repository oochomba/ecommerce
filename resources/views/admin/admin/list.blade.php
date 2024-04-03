@extends('admin.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
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
                        <li class="breadcrumb-item active">System Admins</li>
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
                            @if (Auth::guard('admin')->user()->can('admin.create'))
                                <div class="col-4">
                                    <a href="{{ url('admin/admin/add') }}"
                                        class="btn btn-sm btn-primary text-white pull-right"><i class="fa fa-plus"></i> Add
                                        new
                                        admin</a>
                                    <div class="clearfix"></div>
                                </div>
                            @endif
                        </div>
                    </div>





                    @if (!empty($admins))
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Admin List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Roles</th>
                                            <th>status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($admins as $admin)
                                            <tr>
                                                <td>{{ $loop->iteration }}.</td>
                                                <td>{{ $admin->name }}</td>
                                                <td>{{ $admin->email }}</td>
                                                <td>
                                                    @foreach ($admin->roles as $role)
                                                        <span class="badge badge-info mr-1">
                                                            {{ $role->name }}
                                                        </span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @if ($admin->status == 0)
                                                        <span class="badge bg-info">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (Auth::guard('admin')->user()->can('admin.edit'))
                                                        <a href="{{ url('admin/admin/edit/' . $admin->id) }}"
                                                            class="btn btn-sm btn-primary text-white"
                                                            title="Edit admin">Edit</a>
                                                    @endif
                                                    @if (Auth::guard('admin')->user()->can('admin.delete') && $admin->id != 1)
                                                        <a class="btn btn-sm btn-danger text-white" id=""
                                                            data-id="{{ $admin->id }}" data-token={{ csrf_token() }}
                                                            data-href="{{ url('admin/admin/delete/' . $admin->id) }}"
                                                            data-formId="delete-form-{{ $admin->id }}"
                                                            onclick="confirmDelete(this)" title="Delete admin">
                                                            Delete
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                </div>
                @endif


            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ url('assets/backend/js/custom.js') }}"></script>
    <script>
        $(.table).DataTable({});
    </script>
@endsection
