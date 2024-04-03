@extends('admin.layouts.app')

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
                        <li class="breadcrumb-item active">Colors</li>
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
                    @if (Auth::guard('admin')->user()->can('color.add'))
                        <div class="mt-2 mb-4">
                            <a href="{{ url('admin/color/add') }}" class="btn btn-sm btn-primary text-white pull-right"><i
                                    class="fa fa-plus"></i> Add color
                            </a>
                            <div class="clearfix"></div>
                        </div>
                    @endif


                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Color List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Created By</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($colors as $color)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ ucwords($color->name) }}</td>
                                            <td>
                                                <p>
                                                    {{ ucwords($color->code) }}
                                                    <span
                                                        style="background-color:<?= $color->name ?>;width:50px;height:20px;display:inline-block">
                                                        &nbsp;
                                                    </span>
                                                </p>
                                            </td>
                                            <td>{{ ucwords($color->created_by_name) }}</td>
                                            <td>
                                                @if ($color->status == 0)
                                                    <span class="badge bg-info">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (Auth::guard('admin')->user()->can('color.edit'))
                                                    <a href="{{ url('admin/color/edit/' . $color->id) }}"
                                                        class="btn btn-sm btn-primary text-white"
                                                        title="Edit color">Edit</a>
                                                @endif
                                                @if (Auth::guard('admin')->user()->can('color.delete'))
                                                    <a class="btn btn-sm btn-danger text-white" id=""
                                                        data-id="{{ $color->id }}" data-token={{ csrf_token() }}
                                                        data-href="{{ url('admin/color/delete/' . $color->id) }}"
                                                        data-formId="delete-form-{{ $color->id }}"
                                                        onclick="confirmDelete(this)" title="Delete color">
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


            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ url('assets/backend/js/custom.js') }}"></script>
@endsection
