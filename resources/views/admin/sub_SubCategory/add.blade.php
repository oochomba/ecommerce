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
                        <li class="breadcrumb-item"><a href="{{ url('admin/sub_SubCategory/list') }}">Sub Sub-Categories</a>
                        </li>
                        <li class="breadcrumb-item active">Add sub sub-category</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="content">
        <div class="container-fluid">

            <div class="col-md-12">
                <div class="pb-3">
                    @include('admin.layouts.partials._category_actions')
                </div>

                <!-- general form elements -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">New Sub Sub-Category</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="" method="post">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="category">Select Category <span
                                                class="text text-danger">*</span></label>
                                        <select
                                            class="form-control select2 {{ $errors->has('category_id') ? ' is-invalid' : '' }}"
                                            name="category_id" id="ChangeCategory" required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                @php
                                                    $category = (object) $category;
                                                @endphp
                                                <option {{ old('category_id') == $category->id ? 'selected' : '' }}
                                                    value="{{ old('category_id', $category->id) }}">
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category_id'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('category_id') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="sub_category">Sub Category <span
                                                class="text text-danger">*</span></label>
                                        <select
                                            class="form-control select2 sub-cat {{ $errors->has('sub_category_id') ? ' is-invalid' : '' }}"
                                            name="sub_category_id" id="getSubCategory" required>
                                        </select>

                                        @if ($errors->has('sub_category_id'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('sub_category_id') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6">
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

                                <div class="col-6">
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

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text text-danger">*</span></label>
                                        <select
                                            class="form-control select2 {{ $errors->has('status') ? ' is-invalid' : '' }}"
                                            name="status" required>
                                            <option {{ old('status') == 0 ? 'selected' : '' }} value="0">Active
                                            </option>
                                            <option {{ old('status') == 1 ? 'selected' : '' }} value="1">Inactive
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

@section('scripts')
    <script type="text/javascript">
        $('body').delegate('#ChangeCategory', 'change', function(e) {
            var id = $(this).val();
            $.ajax({
                type: "POST",
                url: "{{ url('admin/get_sub_category') }}",
                data: {
                    "id": id,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(data) {
                    $('#getSubCategory').html(data.html);
                },
                error: function(data) {

                }
            });
        });
    </script>
@endsection
