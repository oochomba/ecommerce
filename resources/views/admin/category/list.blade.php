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
                        <li class="breadcrumb-item active">Product Categories</li>
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
                    @if (Auth::guard('admin')->user()->can('category.create'))
                        <div class="mt-2 mb-4">
                            <a href="{{ url('admin/category/add') }}"
                                class="btn btn-sm btn-primary text-white pull-right"><i class="fa fa-plus"></i> Add new
                                category</a>
                            <div class="clearfix"></div>
                        </div>
                    @endif


                    @if (!empty($categories))
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Categories List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Meta Title</th>
                                            <th>Meta Description</th>
                                            <th>Meta Keywords</th>
                                            <th>Created By</th>
                                            <th>status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ ucwords($category->name) }}</td>
                                                <td>{{ ucwords($category->slug) }}</td>
                                                <td>{{ ucwords($category->meta_title) }}</td>
                                                <td>{{ ucwords($category->meta_description) }}</td>
                                                <td>{{ ucwords($category->meta_keywords) }}</td>
                                                <td>{{ ucwords($category->created_by_name) }}</td>
                                                <td>
                                                    @if ($category->status == 0)
                                                        <span class="badge bg-info">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (Auth::guard('admin')->user()->can('category.edit'))
                                                        <a href="{{ url('admin/category/edit/' . $category->id) }}"
                                                            class="btn btn-sm btn-primary text-white"
                                                            title="Edit category">Edit</a>
                                                    @endif

                                                    @if (Auth::guard('admin')->user()->can('category.delete'))
                                                    <a class="btn btn-sm btn-danger text-white" id=""
                                                        data-id="{{ $category->id }}" data-token={{ csrf_token() }}
                                                        data-href="{{ url('admin/category/delete/' . $category->id) }}"
                                                        data-formId="delete-form-{{ $category->id }}"
                                                        onclick="confirmDelete(this)" title="Delete category">
                                                        Delete
                                                    </a>
                                                    @endif

                                                    <form id="delete-form-{{ $category->id }}"
                                                        action="{{ url('admin/category/delete/' . $category->id) }}"
                                                        method="POST" style="display: none;">
                                                        <!-- @method('DELETE') -->
                                                        @csrf
                                                    </form>
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
    <script src="{{ url('assets/backend/js/custom.js') }}"></script>
@endsection
