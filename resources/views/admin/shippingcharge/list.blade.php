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
                        <li class="breadcrumb-item active">Shipping Charge</li>
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
                    @if (Auth::guard()->user()->can('shippingCharge.create'))
                        <div class="mt-2 mb-4">
                            <a href="{{ url('admin/shippingcharge/add') }}"
                                class="btn btn-sm btn-primary text-white pull-right"><i class="fa fa-plus"></i> Add shipping
                                charge
                            </a>
                            <div class="clearfix"></div>
                        </div>
                    @endif


                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Shipping Charge List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Created By</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shippingcharges as $shippingcharge)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $shippingcharge->name }}</td>
                                            <td> {{ number_format($shippingcharge->price, 2) }} </td>
                                            <td>{{ ucwords($shippingcharge->created_by_name) }}</td>
                                            <td>
                                                @if ($shippingcharge->status == 0)
                                                    <span class="badge bg-info">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (Auth::guard()->user()->can('shippingCharge.edit'))
                                                    <a href="{{ url('admin/shippingcharge/edit/' . $shippingcharge->id) }}"
                                                        class="btn btn-sm btn-primary text-white"
                                                        title="Edit shippingcharge">Edit</a>
                                                @endif
                                                @if (Auth::guard()->user()->can('shippingCharge.delete'))
                                                <a class="btn btn-sm btn-danger text-white" id=""
                                                    data-id="{{ $shippingcharge->id }}" data-token={{ csrf_token() }}
                                                    data-href="{{ url('admin/shippingcharge/delete/' . $shippingcharge->id) }}"
                                                    data-formId="delete-form-{{ $shippingcharge->id }}"
                                                    onclick="confirmDelete(this)" title="Delete shipping charge">
                                                    Delete
                                                </a>
                                                @endif

                                                <form id="delete-form-{{ $shippingcharge->id }}"
                                                    action="{{ url('admin/shippingcharge/delete/' . $shippingcharge->id) }}"
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


            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ url('assets/backend/js/custom.js') }}"></script>
@endsection
