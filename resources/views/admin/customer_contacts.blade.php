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
                    <h1 class="m-0 text-dark">{{ !empty($page_title) ? $page_title : config('siteconfig.sitename') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Customer Contacts</li>
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

                    @if (!empty($contacts))
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Customer Contacts</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Sent On</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contacts as $customer)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ ucwords($customer->name) }}</td>
                                                <td>{{ $customer->email }}</td>
                                                <td> {{ $customer->phone }} </td>
                                                <td>{{ $customer->subject }}
                                                <td>{{ $customer->message }}</td>
                                                <td>
                                                    @php
                                                        $formattedDate = \Illuminate\Support\Carbon::parse(
                                                            $customer->created_by,
                                                        )->format('d F Y');
                                                    @endphp
                                                    {{ $formattedDate }}
                                                </td>
                                                <td><a class="btn btn-info btn-sm"
                                                        href="mailto:{{ $customer->email }}">Reply</a></td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
                @endif


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
