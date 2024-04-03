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
                        <li class="breadcrumb-item"><a href="{{ url('admin/product/list') }}">Product list</a></li>
                        <li class="breadcrumb-item active">Add product</li>
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
                        <h3 class="card-title">New Product</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{ url('admin/product/add') }}" method="post">
                        <div class="card-body">

                            <div class="row">

                                <div class="col-12">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="name">Title <span class="text text-danger">*</span></label>
                                        <input type="text" name="title"
                                            class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}"
                                            value="{{ old('title') }}" id=""
                                            placeholder="Enter product title">
                                        @if ($errors->has('title'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('title') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <!-- /.card-body -->

                            <div class="">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                    </form>
                </div>
                <!-- /.card -->



            </div>

        </div>

    </div>
  
@endsection
