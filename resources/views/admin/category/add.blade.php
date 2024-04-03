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
                        <li class="breadcrumb-item"><a href="{{ url('admin/category/list') }}">Categories</a></li>
                        <li class="breadcrumb-item active">Add category</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="content">
        <div class="container-fluid">

            <div class="col-md-12">
                @include('admin.layouts.partials._message')
                <!-- general form elements -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">New Category</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{ url('admin/category/add') }}" method="post">
                        <div class="card-body">

                            <div class="row">

                                <div class="col-4">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="name">Name <span class="text text-danger">*</span></label>
                                        <input type="text" name="name"
                                            class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            value="{{ old('name') }}" id="" required
                                            placeholder="Enter category name">
                                        @if ($errors->has('name'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('name') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="slug">Slug <span class="text text-danger">*</span></label>
                                        <input type="text" name="slug"
                                            class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}"
                                            value="{{ old('slug') }}" id="" required
                                            placeholder="Enter slug Ex. URL">
                                        @if ($errors->has('slug'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('slug') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text text-danger">*</span></label>
                                        <select
                                            class="form-control select2 {{ $errors->has('status') ? ' is-invalid' : '' }}"
                                            name="status" required>
                                          
                                            <option {{ (old('status') == 0) ? 'selected' : '' }} value="0">Active
                                            </option>
                                            <option {{ (old('status') == 1) ? 'selected' : '' }} value="1">Inctive
                                            </option>
                                            
                                        </select>
                                        @if ($errors->has('status'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('status') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="meta_title">Meta Title <span class="text text-danger">*</span></label>
                                        <input type="text" name="meta_title"
                                            class="form-control {{ $errors->has('meta_title') ? ' is-invalid' : '' }}"
                                            value="{{ old('meta_title') }}" id="" placeholder="Enter Meta Title">
                                        @if ($errors->has('meta_title'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('meta_title ') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="meta_description">Meta Description</label>
                                        <textarea name="meta_description" id="" cols="20" rows="3" placeholder="Enter meta description"
                                            class="form-control {{ $errors->has('meta_description') ? ' is-invalid' : '' }}">{{ old('meta_description') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="meta_keywords">Meta Keywords</label>
                                        <input type="text" name="meta_keywords"
                                            class="form-control {{ $errors->has('meta_keywords') ? ' is-invalid' : '' }}"
                                            value="{{ old('meta_keywords') }}" id=""
                                            placeholder="Enter Meta Keywords">
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
