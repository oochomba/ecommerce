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
                        <li class="breadcrumb-item active">Product list</li>
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
                    @if (Auth::guard('admin')->user()->can('product.create'))
                        <div class="mt-2 mb-4">
                            <a href="{{ url('admin/product/add') }}" class="btn btn-sm btn-primary text-white pull-right"><i
                                    class="fa fa-plus"></i> Add product
                            </a>
                            <div class="clearfix"></div>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Products List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Title</th>
                                        <th>Sub Category</th>
                                        <th>Category</th>
                                        <th>Brand</th>
                                        <th>Price (KES)</th>
                                        <th>Created By</th>
                                        <th>status</th>
                                        <th style="width: 120px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ ucwords($product->title) }}</td>
                                            <td>{{ ucwords($product->sub_category_name) }}</td>
                                            <td>{{ ucwords($product->category_name) }}</td>
                                            <td>{{ ucwords($product->brand) }}</td>
                                            <td>{{ number_format($product->price, 2) }}</td>
                                            <td>{{ ucwords($product->created_by_name) }}</td>
                                            <td>
                                                @if ($product->status == 0)
                                                    <span class="badge bg-info">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (Auth::guard('admin')->user()->can('product.edit'))
                                                    <a href="{{ url('admin/product/edit/' . $product->id) }}"
                                                        class="btn btn-xs btn-primary text-white"
                                                        title="Edit product">Edit</a>
                                                @endif

                                                @if (Auth::guard('admin')->user()->can('product.delete'))
                                                    <a class="btn btn-xs btn-danger text-white" id=""
                                                        data-id="{{ $product->id }}" data-token={{ csrf_token() }}
                                                        data-href="{{ url('admin/product/delete/' . $product->id) }}"
                                                        data-formId="delete-form-{{ $product->id }}"
                                                        onclick="confirmDelete(this)" title="Delete product">
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
                    {{ $products->links() }}


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
