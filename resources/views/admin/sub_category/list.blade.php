@extends('admin.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <style>
        .table tr td {
            vertical-align: middle;
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
                        <li class="breadcrumb-item active">Sub Categories</li>
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
                    @if (Auth::guard('admin')->user()->can('subCategory.create'))
                        <div class="mt-2 mb-4">
                            <a href="{{ url('admin/sub_category/add') }}"
                                class="btn btn-sm btn-primary text-white pull-right"><i class="fa fa-plus"></i> Add sub
                                category</a>
                            <div class="clearfix"></div>
                        </div>
                    @endif


                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sub Categories List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Sub Categoty </th>
                                        <th>Slug</th>
                                        <th>Category</th>
                                        <th>Meta Title</th>
                                        <th>Meta Description</th>
                                        <th>Meta Keywords</th>
                                        <th>Created By</th>
                                        <th>status</th>
                                        <th style="width: 120px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sub_categories as $sub_category)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $sub_category->name }}</td>
                                            <td>{{ $sub_category->slug }}</td>
                                            <td>{{ $sub_category->category_name }}</td>
                                            <td>{{ $sub_category->meta_title }}</td>
                                            <td>{{ $sub_category->meta_description }}</td>
                                            <td>{{ $sub_category->meta_keywords }}</td>
                                            <td>{{ ucwords($sub_category->created_by_name) }}</td>
                                            <td>
                                                @if ($sub_category->status == 0)
                                                    <span class="badge bg-info">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (Auth::guard('admin')->user()->can('subCategory.edit'))
                                                    <a href="{{ url('admin/sub_category/edit/' . $sub_category->id) }}"
                                                        class="btn btn-xs btn-primary text-white"
                                                        title="Edit sub category">Edit</a>
                                                @endif

                                                @if (Auth::guard('admin')->user()->can('subCategory.delete'))
                                                    <a class="btn btn-xs btn-danger text-white" id=""
                                                        data-id="{{ $sub_category->id }}" data-token={{ csrf_token() }}
                                                        data-href="{{ url('admin/sub_category/delete/' . $sub_category->id) }}"
                                                        data-formId="delete-form-{{ $sub_category->id }}"
                                                        onclick="confirmDelete(this)" title="Delete sub category">
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
    <script src="{{ url('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">
        $('.table').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    </script>
    <script src="{{ url('assets/backend/js/custom.js') }}"></script>
@endsection
