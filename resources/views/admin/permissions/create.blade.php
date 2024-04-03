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
                        <li class="breadcrumb-item active"><a href="{{ url('admin/permission') }}">Permissions</a></li>
                        <li class="breadcrumb-item active">Add new permission</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">
        <div class="container-fluid">
            @include('admin.layouts.partials._message')
            <!-- data table start -->
            <div class="col-12 mt-5">

                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">New Permission (CRUD)</h4>

                                <form action="{{ url('admin/permission/add-crud') }}" method="POST">
                                    {{ csrf_field() }}

                                    <div class="row">

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="guard_name_crud">Select Guard <span
                                                        class="text text-danger">*</span></label>
                                                <select
                                                    class="form-control select2 {{ $errors->has('guard_name_crud') ? ' is-invalid' : '' }}"
                                                    name="guard_name_crud" required>
                                                    <option value="">Select Guard</option>
                                                    <option {{ old('guard_name_crud') == 'admin' ? 'selected' : '' }}
                                                        value="admin">
                                                        Admin
                                                    </option>
                                                </select>
                                                @if ($errors->has('guard_name_crud'))
                                                    <span class="invalid feedback text text-danger" role="alert">
                                                        {{ $errors->first('guard_name_crud') }}.
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="group_name_crud">Permission Group <span
                                                        class="text text-danger">*</span></label>
                                                <input type="text" name="group_name_crud"
                                                    class="form-control {{ $errors->has('group_name_crud') ? ' is-invalid' : '' }}"
                                                    value="{{ old('group_name_crud') }}" id="" required
                                                    placeholder="Group name">
                                                @if ($errors->has('group_name_crud'))
                                                    <span class="invalid feedback text text-danger" role="alert">
                                                        {{ $errors->first('group_name_crud') }}.
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name_crud">Permission <span
                                                        class="text text-danger">*</span></label>
                                                <div class="form-check">
                                                    <input type="checkbox" name="name_crud[]" value="view"
                                                        class="form-check-input" id="view">
                                                    <label class="form-check-label" for="view">View Permission</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" name="name_crud[]" value="create"
                                                        class="form-check-input" id="create">
                                                    <label class="form-check-label" for="create">Create Permission</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" name="name_crud[]" value="edit"
                                                        class="form-check-input" id="edit">
                                                    <label class="form-check-label" for="edit">Edit Permission</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" name="name_crud[]" value="delete"
                                                        class="form-check-input" id="delete">
                                                    <label class="form-check-label" for="delete">Delete Permission</label>
                                                </div>


                                                @if ($errors->has('name_crud'))
                                                    <span class="invalid feedback text text-danger" role="alert">
                                                        {{ $errors->first('name_crud') }}.
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Add Permissions</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">New Permission (SINGLE)</h4>

                                <form action="{{ url('admin/permission/add') }}" method="POST">
                                    {{ csrf_field() }}

                                    <div class="row">

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="guard_name">Select Guard <span
                                                        class="text text-danger">*</span></label>
                                                <select
                                                    class="form-control select2 {{ $errors->has('guard_name') ? ' is-invalid' : '' }}"
                                                    name="guard_name" required>
                                                    <option value="">Select Guard</option>
                                                    <option {{ old('guard_name') == 'admin' ? 'selected' : '' }}
                                                        value="admin">
                                                        Admin
                                                    </option>
                                                </select>
                                                @if ($errors->has('guard_name'))
                                                    <span class="invalid feedback text text-danger" role="alert">
                                                        {{ $errors->first('guard_name') }}.
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="group_name">Permission Group <span
                                                        class="text text-danger">*</span></label>
                                                <input type="text" name="group_name"
                                                    class="form-control {{ $errors->has('group_name') ? ' is-invalid' : '' }}"
                                                    value="{{ old('group_name') }}" id="" required
                                                    placeholder="Group name">
                                                @if ($errors->has('group_name'))
                                                    <span class="invalid feedback text text-danger" role="alert">
                                                        {{ $errors->first('group_name') }}.
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="name">Permission <span
                                                        class="text text-danger">*</span></label>
                                                <input type="text" name="name"
                                                    class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                    value="{{ old('name') }}" id="" required
                                                    placeholder="Permission">
                                                @if ($errors->has('name'))
                                                    <span class="invalid feedback text text-danger" role="alert">
                                                        {{ $errors->first('name') }}.
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Add Permission</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <!-- data table end -->
        </div>
    </div>
@endsection

@section('scripts')
@endsection
