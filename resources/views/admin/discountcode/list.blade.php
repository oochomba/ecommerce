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
                        <li class="breadcrumb-item active">Discount Codes</li>
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
                    @if (Auth::guard()->user()->can('discountCode.create'))
                        <div class="mt-2 mb-4">
                            <a href="{{ url('admin/discountcode/add') }}"
                                class="btn btn-sm btn-primary text-white pull-right"><i class="fa fa-plus"></i> Add discount
                                code
                            </a>
                            <div class="clearfix"></div>
                        </div>
                    @endif



                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Discount Code List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Percent Amount</th>
                                        <th>Expire Date</th>
                                        <th>Created By</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($discountcodes as $discountcode)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $discountcode->name }}</td>
                                            <td> {{ $discountcode->type }} </td>

                                            <td>
                                                @if ($discountcode->type == 'Amount')
                                                    {{ number_format($discountcode->percent_amount, 2) }}
                                                @elseif($discountcode->type == 'Percent')
                                                    {{ $discountcode->percent_amount . ' %' }}
                                                @else
                                                @endif
                                            </td>

                                            <td>{{ date('d M Y', strtotime($discountcode->expire_date)) }}</td>
                                            <td>{{ ucwords($discountcode->created_by_name) }}</td>
                                            <td>
                                                @if ($discountcode->status == 0)
                                                    <span class="badge bg-info">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (Auth::guard()->user()->can('discountCode.edit'))
                                                <a href="{{ url('admin/discountcode/edit/' . $discountcode->id) }}"
                                                    class="btn btn-sm btn-primary text-white"
                                                    title="Edit discountcode">Edit</a>
                                             @endif
                                             @if (Auth::guard()->user()->can('discountCode.delete'))
                                                    <a class="btn btn-sm btn-danger text-white" id=""
                                                    data-id="{{ $discountcode->id }}" data-token={{ csrf_token() }}
                                                    data-href="{{ url('admin/discountcode/delete/' . $discountcode->id) }}"
                                                    data-formId="delete-form-{{ $discountcode->id }}"
                                                    onclick="confirmDelete(this)" title="Delete discountcode">
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
