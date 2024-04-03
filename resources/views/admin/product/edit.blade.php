@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 pl-3">
                    @if (Auth::guard('admin')->user()->can('category.create'))
                        <a href="{{ url('admin/category/list') }}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i>
                            Category</a>
                    @endif
                    @if (Auth::guard('admin')->user()->can('subCategory.create'))
                        <a href="{{ url('admin/sub_category/add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>
                            Sub
                            Category</a>
                    @endif
                    @if (Auth::guard('admin')->user()->can('subCategory.create'))
                        <a href="{{ url('admin/sub_SubCategory/add') }}" class="btn btn-danger btn-sm"><i
                                class="fa fa-plus"></i> Sub
                            Sub-Category</a>
                    @endif
                    @if (Auth::guard('admin')->user()->can('brand.create'))
                        <a href="{{ url('admin/brand/add') }}" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus"></i> Brand</a>
                    @endif
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('admin/product/list') }}">Products</a></li>
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

                @include('admin.layouts.partials._message')
                <!-- general form elements -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Edit product - {{ ucfirst($page_title) }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="" method="post" enctype="multipart/form-data">
                        <div class="card-body">

                            <div class="row mb-4">

                                <div class="col-4">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="name">Title <span class="text text-danger">*</span></label>
                                        <input type="text" name="title"
                                            class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}"
                                            value="{{ old('name', $product->title) }}" id=""
                                            placeholder="Enter product title">
                                        @if ($errors->has('title'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('title') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="name">SKU <span class="text text-danger">*</span></label>
                                        <input type="text" name="sku"
                                            class="form-control {{ $errors->has('sku') ? ' is-invalid' : '' }}"
                                            value="{{ old('name', $product->sku) }}" id=""
                                            placeholder="Enter product SKU">
                                        @if ($errors->has('sku'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('sku') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="category">Category <span class="text text-danger">*</span></label>
                                        <select
                                            class="form-control select2 {{ $errors->has('category_id') ? ' is-invalid' : '' }}"
                                            name="category_id" id="ChangeCategory" required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                @php
                                                    $category = (object) $category;
                                                @endphp
                                                <option
                                                    {{ old('category_id') == $category->id || $category->id == $product->category_id ? 'selected' : '' }}
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

                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="sub_category">Sub Category <span
                                                class="text text-danger">*</span></label>
                                        <select
                                            class="form-control select2 {{ $errors->has('sub_category_id') ? ' is-invalid' : '' }}"
                                            name="sub_category_id" id="getSubCategory" required>

                                            @foreach ($sub_categories as $sub_category)
                                                <option
                                                    {{ old('sub_category_id', $sub_category->id) == $product->sub_category_id ? 'selected' : '' }}
                                                    value="{{ old('sub_category_id', $sub_category->id) }}">
                                                    {{ $sub_category->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('sub_category_id'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('sub_category_id') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>




                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="sub_subcategory">Sub Sub-Category <span
                                                class="text text-danger">*</span></label>
                                        <select
                                            class="form-control select2 {{ $errors->has('sub_subcategory_id') ? ' is-invalid' : '' }}"
                                            name="sub_subcategory_id" id="getSubSubCategory" required>

                                            @foreach ($sub_subcategories as $sub_subcategory)
                                                <option
                                                    {{ old('sub_subcategory_id', $sub_subcategory->id) == $product->sub_subcategory_id ? 'selected' : '' }}
                                                    value="{{ old('sub_subcategory_id', $sub_category->id) }}">
                                                    {{ $sub_subcategory->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('sub_subcategory_id'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('sub_subcategory_id') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>




                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="brand">Brand <span class="text text-danger">*</span></label>
                                        <select
                                            class="form-control select2 {{ $errors->has('brand_id') ? ' is-invalid' : '' }}"
                                            name="brand_id">
                                            <option value="">Select Brand</option>
                                            @foreach ($brands as $brand)
                                                @php
                                                    $brand = (object) $brand;
                                                @endphp

                                                <option
                                                    {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}
                                                    value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('brand_id'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('brand_id') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr />
                                </div>


                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="color">Color <span class="text text-danger">*</span></label>

                                        @foreach ($colors as $color)
                                            @php
                                                $color = (object) $color;
                                            @endphp

                                            @php
                                                $checked = '';
                                            @endphp
                                            @foreach ($product->getColor as $pcolor)
                                                @if ($pcolor->color_id == $color->id)
                                                    @php
                                                        $checked = 'checked';
                                                    @endphp
                                                @endif
                                            @endforeach

                                            <div class="form-check">
                                                <input {{ $checked }} type="checkbox" name="color_id[]"
                                                    value="{{ $color->id }}" class="form-check-input"
                                                    id="exampleCheck1">
                                                <label class="form-check-label"
                                                    for="exampleCheck1">{{ ucfirst($color->name) }}</label>
                                            </div>
                                        @endforeach

                                        @if ($errors->has('color_id'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('color_id') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <label class="" for="color">Size <span
                                                class="text text-danger">*</span></label>
                                    </div>
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Price (KES)</th>
                                                <th style="width: 100px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="AppendSize">
                                            @php
                                                $i_s = 1;
                                            @endphp
                                            @foreach ($product->getSize as $size)
                                                <tr id="DeleteSize{{ $i_s }}">
                                                    <td>
                                                        <input type="text" value="{{ $size->name }}"
                                                            name="size[{{ $i_s }}][name]" placeholder="Name"
                                                            class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="text" value="{{ $size->price }}"
                                                            name="size[{{ $i_s }}][price]" placeholder="Price"
                                                            class="form-control">
                                                    </td>

                                                    <td>
                                                        <button type="button" id="{{ $i_s }}"
                                                            class="btn btn-danger btn-sm DeleteSize">Delete</button>
                                                    </td>
                                                </tr>
                                                @php
                                                    $i_s++;
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <td>
                                                    <input type="text" name="size[100][name]" placeholder="Name"
                                                        class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" name="size[100][price]" placeholder="Price"
                                                        class="form-control">
                                                </td>

                                                <td>
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm AddSize">Add</button>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    @if ($errors->has('size'))
                                        <span class="invalid feedback text text-danger" role="alert">
                                            {{ $errors->first('size') }}.
                                        </span>
                                    @endif
                                </div>

                            </div>
                            <hr>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <h4 class="text text-info">Price Details</h4>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="price">Price <span class="text text-danger">*</span>(KES)</label>
                                        <input type="number" required name="price"
                                            class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}"
                                            value="{{ old('price', !empty($product->price) ? $product->price : '') }}"
                                            id="" placeholder="Enter product price">
                                        @if ($errors->has('price'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('price') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="price">Old Price <span
                                                class="text text-danger">*</span>(KES)</label>
                                        <input type="number" name="old_price"
                                            class="form-control {{ $errors->has('old_price') ? ' is-invalid' : '' }}"
                                            value="{{ old('old_price', !empty($product->old_price) ? $product->old_price : '') }}"
                                            id="" placeholder="Enter product old price">
                                        @if ($errors->has('old_price'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('old_price') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <hr>

                            <div class="col-12 pb-3 pt-2">
                                <div class="form-group">
                                    <label for="exampleInputFile">Product Images <span
                                            class="text text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="image[]" multiple accept="image/*"
                                                class="custom-file-input" style="opacity: 100;padding:4px"
                                                id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            @if (!empty($product->getImage->count()))
                                <div class="row pt-2" id="sortable">
                                    @foreach ($product->getImage as $image)
                                        @if (!empty($image->getImageInfo()))
                                            <div class="col-md-1 sortable_image" id="{{ $image->id }}"
                                                style="text-align: center;">
                                                <img style="width: 100%;height:70px" src="{{ $image->getImageInfo() }}"
                                                    alt="" />
                                                <a class="btn btn-danger btn-xs text-white mt-1" id=""
                                                    data-id="{{ $image->id }}" data-token={{ csrf_token() }}
                                                    data-href="{{ url('admin/product/del_product_image/' . $image->id) }}"
                                                    data-formId="delete-form-{{ $image->id }}"
                                                    onclick="confirmDelete(this)" title="Delete Image">
                                                    Delete
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif


                            <hr>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <h4 class="text text-info">Price Description</h4>
                                </div>


                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="short_description">Short Description</label>
                                        <textarea name="short_description" id="" cols="20" rows="3"
                                            placeholder="Product short description"
                                            class="form-control {{ $errors->has('short_description') ? ' is-invalid' : '' }}">{{ old('short_description', $product->short_description) }}</textarea>
                                        @if ($errors->has('short_description'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('short_description') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="" cols="20" rows="3" placeholder="Product description"
                                            class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}">{{ old('short_description', $product->short_description) }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('description') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="additional_description">Additional Description</label>
                                        <textarea name="additional_description" id="" cols="20" rows="3"
                                            placeholder="Product additional description"
                                            class="form-control {{ $errors->has('additional_description') ? ' is-invalid' : '' }}">{{ old('short_description', $product->short_description) }}</textarea>
                                        @if ($errors->has('additional_description'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('additional_description') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="tag">Tag {{ $product->tag }}</label>
                                        <select
                                            class="form-control select2 {{ $errors->has('tag') ? ' is-invalid' : '' }}"
                                            name="tag">
                                            <option value="">Select Tag</option>
                                            <option {{ old('tag', $product->tag) == 'new' ? 'selected' : '' }}
                                                value="new">New
                                            </option>
                                            <option {{ old('tag', $product->tag) == 'top' ? 'selected' : '' }}
                                                value="top">Top
                                            </option>
                                            <option {{ old('tag', $product->tag) == 'out' ? 'selected' : '' }}
                                                value="out">Out of Stock
                                            </option>
                                            <option {{ old('tag', $product->tag) == 'sale' ? 'selected' : '' }}
                                                value="sale">Sale
                                            </option>
                                        </select>
                                        @if ($errors->has('status'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('status') }}.
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
                                            <option {{ old('status', $product->status) == 0 ? 'selected' : '' }}
                                                value="0">Active
                                            </option>
                                            <option {{ old('status', $product->status) == 1 ? 'selected' : '' }}
                                                value="1">Inative
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
    <script src="{{ url('assets/backend/js/custom.js') }}"></script>
    <script src="{{ url('assets/backend/js/jquery-ui.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#sortable").sortable({
                update: function(event, ui) {
                    var photo_id = new Array();
                    $('.sortable_image').each(function() {
                        var id = $(this).attr('id');
                        photo_id.push(id)
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ url('admin/product_image_sortable') }}",
                        data: {
                            "photo_id": photo_id,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {

                        },
                        error: function(data) {

                        }
                    });

                }
            });
        });




        var i = 101;
        $('body').delegate('.AddSize', 'click', function(e) {
            var html = '<tr id="DeleteSize' + i +
                '">\n\
                                                                                                                                                        <td>\n\
                                                                                                                                                        <input type="text" name="size[' +
                i +
                '][name]" placeholder="Name" value="" class="form-control">\n\
                                                                                                                                                        <td>\n\
                                                                                                                                                        <input type="text" name="size[' +
                i +
                '][price]" placeholder="price" class="form-control">\n\
                                                                                                                                                        </td>\n\
                                                                                                                                                        <td>\n\
                                                                                                                                                        <button type="button" id="' +
                i +
                '" class="btn btn-danger btn-sm DeleteSize">Delete</button>\n\
                                                                                                                                                        </td style="width:100px">\n\
                                                                                                                                                        </tr>';
            i++;
            $('#AppendSize').append(html);
        });

        $('body').delegate('.DeleteSize', 'click', function(e) {
            var id = $(this).attr('id');
            $('#DeleteSize' + id).remove();
        });


        $('body').delegate('#ChangeCategory', 'change', function(e) {
            $('#getSubSubCategory').html('');
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

        $('body').delegate('#getSubCategory', 'change', function(e) {
            var id = $(this).val();
            $.ajax({
                type: "POST",
                url: "{{ url('admin/get_sub_subcategory') }}",
                data: {
                    "id": id,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(data) {
                    $('#getSubSubCategory').html(data.html);
                },
                error: function(data) {

                }
            });
        });
        //
    </script>
@endsection
