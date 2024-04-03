@extends('admin.layouts.app')
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .form-check-label {
            text-transform: capitalize;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: #000000;
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
                        <li class="breadcrumb-item"><a href="{{ url('admin/admin/list') }}">System admins</a></li>
                        <li class="breadcrumb-item active">{{ ucfirst($page_title) }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="content">
        <div class="container-fluid">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Edit admin - {{ ucfirst($page_title) }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="" method="post">
                        <div class="card-body">

                            <div class="row">

                                <div class="col-6">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name"
                                            class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            value="{{ old('name', $admin->name) }}" id="" placeholder="Enter name">
                                        @if ($errors->has('name'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('name') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" name="email"
                                            class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            value="{{ old('email', $admin->email) }}" id=""
                                            placeholder="Enter email">
                                        @if ($errors->has('email'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('email') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password"
                                            class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                            id="" placeholder="Enter password">
                                        @if ($errors->has('password'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('password') }}.
                                            </span>
                                        @endif
                                        <p class="">Please add password to change else leave blank to keep previous
                                        </p>
                                    </div>
                                </div>


                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="password">Assign Roles</label>
                                    <select name="roles[]" id="roles" class="form-control select2" multiple required>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}"
                                                {{ $admin->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('roles'))
                                        <span class="invalid feedback text text-danger" role="alert">
                                            {{ $errors->first('roles') }}.
                                        </span>
                                    @endif
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control {{ $errors->has('status') ? ' is-invalid' : '' }}"
                                            name="status">
                                            <option {{ $admin->status == 0 ? 'selected' : '' }} value="0">Active
                                            </option>
                                            <option {{ $admin->status == 1 ? 'selected' : '' }} value="1">Inactive
                                            </option>
                                        </select>
                                        @if ($errors->has('status'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('status') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>



                            <!-- /.card-body -->

                            <div class="">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                    </form>
                </div>
                <!-- /.card -->



            </div>

        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        })
    </script>
@endsection
