@extends('admin.layouts.app')
@section('styles')
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
                        <li class="breadcrumb-item active">Roles</li>
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
                                @if (Auth::guard('admin')->user()->can('role.add'))
                                    <a href="{{ url('admin/roles/add') }}"
                                        class="btn btn-sm btn-primary text-white pull-right"><i class="fa fa-plus"></i> Add
                                        role
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div class="data-tables">
                        <table id="dataTable" class="table table-stripped table-condensed text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Permissions</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @foreach ($role->permissions as $perm)
                                                <span class="badge badge-info mr-1">
                                                    {{ $perm->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if (Auth::guard('admin')->user()->can('role.edit'))
                                                <a class="btn btn-success btn-sm text-white"
                                                    href="{{ url('admin/roles/edit', $role->id) }}">Edit</a>
                                            @endif

                                            @if (Auth::guard('admin')->user()->can('role.delete'))
                                                <a class="btn btn-sm btn-danger text-white" id=""
                                                    data-id="{{ $role->id }}" data-token={{ csrf_token() }}
                                                    data-href="{{ url('admin/roles/delete/' . $role->id) }}"
                                                    data-formId="delete-form-{{ $role->id }}"
                                                    onclick="confirmDelete(this)" title="Delete role">
                                                    Delete
                                                </a>

                                                <form id="delete-form-{{ $role->id }}"
                                                    action="{{ url('admin/roles/destroy', $role->id) }}" method="POST"
                                                    style="display: none;">
                                                    @method('DELETE')
                                                    @csrf
                                                </form>
                                            @endif
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
