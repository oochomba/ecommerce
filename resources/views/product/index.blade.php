@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ url('assets/front/css/plugins/owl-carousel/owl.carousel.css') }}">
<link rel="stylesheet" href="{{ url('assets/front/css/plugins/magnific-popup/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ url('assets/front/css/plugins/nouislider/nouislider.css') }}">
<style type="text/css">
    .color-active {
        box-shadow: 0 0 0 0.1rem #cccccc;
    }

    .intro-price {
        font-size: 1.8rem;
        margin-bottom: 1.7rem;
    }

    .intro-price sup {
        top: -0.7rem;
        font-size: 1.2rem;
    }

    .price-x {
        display: unset !important;
        color: #ef837b;
    }
    .border-bottom-none{
        border-bottom: none !important;
    }
</style>
@endsection

@section('content')
<main class="main">
    <!-- <div class="page-header text-center"
            style="background-image: url('{{ url('assets/front/images/page-header-bg.jpg') }}')">
            <div class="container">
                <h1 class="page-title">
                    @if (!empty($sub_category))
                        {{ ucwords($sub_category->name) }}
                    @elseif (!empty($category))
                        {{ ucwords($category->name) }}
                    @else
                        Search for {{ Request::get('q') }}
                    @endif

                </h1>
            </div>
        </div> -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-0 border-bottom-none">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('shop') }}">Shop</a></li>
                @if (!empty($sub_category))
                <li class="breadcrumb-item"><a href="{{ url($category->slug) }}">{{ ucwords($category->name) }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ ucwords($sub_category->name) }}
                </li>
                @elseif(!empty($category))
                <li class="breadcrumb-item active" aria-current="page">
                    {{ ucwords($category->name) }}
                </li>
                @else
                <li class="breadcrumb-item active" aria-current="page">
                    {{ Request::get('q') }}
                </li>
                @endif
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="bg-white p-3">
                        <div class="toolbox">
                            <div class="toolbox-left">
                                @if ($products->total() >= $products->perPage())
                                <div class="toolbox-info">
                                    Showing <span>{{ $products->perPage() }} of {{ $products->total() }}</span>
                                    Products
                                </div>
                                @else
                                <div class="toolbox-info">
                                    Showing <span>{{ $products->total() }}</span> Products
                                </div>
                                @endif
                            </div>

                            <div class="toolbox-right">
                                <div class="toolbox-sort">
                                    <label for="sortby">Sort by:</label>
                                    <div class="select-custom">
                                        <select name="sortby" id="sortby" class="form-control changeSortBy">
                                            <option value="">Select</option>
                                            <option value="popularity">Most Popular</option>
                                            <option value="rating">Most Rated</option>
                                            <option value="date">Date</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="products mb-3">
                            <div class="row justify-content-left" id="getProductAjax">

                                @include('product._list_ajax')

                            </div>
                        </div>



                        <div class="justify-center" style="text-align: center">
                            <a href="javascript:;" data-page={{ $page }} @if (empty($page)) style="display: none" @endif class="btn btn-primary text-uppercase loadMore">Load More</a>
                        </div>
                    </div>
                </div>

                <aside class="col-lg-3 order-lg-first">
                <div class="bg-white p-3">
                <form id="FilterForm" method="POST" action="">
                        {{ csrf_field() }}
                        <input type="hidden" name="q" value="{{ !empty(Request::get('q')) ? Request::get('q') : '' }}">
                        <input type="hidden" name="old_category_id" value="{{ !empty($category) ? $category->id : '' }}">
                        <input type="hidden" name="old_sub_category_id" value="{{ !empty($sub_category) ? $sub_category->id : '' }}">

                        <input type="hidden" id="get_sub_category_id" name="sub_category_id">
                        <input type="hidden" id="get_brand_id" name="brand_id">
                        <input type="hidden" id="get_color_id" name="color_id">
                        <input type="hidden" id="get_sort_by_id" name="sort_by_id">

                        <input type="hidden" id="get_start_price" name="start_price">
                        <input type="hidden" id="get_end_price" name="end_price">
                    </form>
                    <div class="sidebar sidebar-shop">
                        <div class="widget widget-clean">
                            <label>Filters:</label>
                            <a href="#" class="sidebar-filter-clear">Clean All</a>
                        </div>
                        @if (!empty($getSubCategoryFilter))
                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                                    Category
                                </a>
                            </h3>


                            <div class="collapse show" id="widget-1">
                                <div class="widget-body">
                                    <div class="filter-items filter-items-count">

                                        @foreach ($getSubCategoryFilter as $s_c_filter)
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" value="{{ $s_c_filter->id }}" class="custom-control-input changeCategory" id="cat-{{ $s_c_filter->id }}">
                                                <label class="custom-control-label" for="cat-{{ $s_c_filter->id }}">{{ ucwords($s_c_filter->name) }}</label>
                                            </div>
                                            <span class="item-count">{{ $s_c_filter->getProductCount() }}</span>
                                        </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-2" role="button" aria-expanded="true"
                                        aria-controls="widget-2">
                                        Size
                                    </a>
                                </h3>

                                <div class="collapse show" id="widget-2">
                                    <div class="widget-body">
                                        <div class="filter-items">
                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="size-1">
                                                    <label class="custom-control-label" for="size-1">XS</label>
                                                </div>
                                            </div>

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="size-2">
                                                    <label class="custom-control-label" for="size-2">S</label>
                                                </div>
                                            </div>

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" checked
                                                        id="size-3">
                                                    <label class="custom-control-label" for="size-3">M</label>
                                                </div>
                                            </div>

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" checked
                                                        id="size-4">
                                                    <label class="custom-control-label" for="size-4">L</label>
                                                </div>
                                            </div>

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="size-5">
                                                    <label class="custom-control-label" for="size-5">XL</label>
                                                </div>
                                            </div>

                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="size-6">
                                                    <label class="custom-control-label" for="size-6">XXL</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}


                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-3" role="button" aria-expanded="true" aria-controls="widget-3">
                                    Colour
                                </a>
                            </h3>

                            <div class="collapse show" id="widget-3">
                                <div class="widget-body">
                                    <div class="filter-colors">
                                        @foreach ($getColor as $f_color)
                                        <a href="javascript:;" id="{{ $f_color->id }}" class="changeColor" data-val="0" style="background: {{ $f_color->code }};" title="{{ ucwords($f_color->name) }}">
                                            <span class="sr-only">{{ ucwords($f_color->name) }}</span></a>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true" aria-controls="widget-4">
                                    Brand
                                </a>
                            </h3>

                            <div class="collapse show" id="widget-4">
                                <div class="widget-body">
                                    <div class="filter-items">
                                        @foreach ($brands as $f_brand)
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" value="{{ $f_brand->id }}" class="custom-control-input changeBrand" id="brand-{{ $f_brand->id }}">
                                                <label class="custom-control-label" for="brand-{{ $f_brand->id }}">{{ ucwords($f_brand->name) }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true" aria-controls="widget-5">
                                    Price
                                </a>
                            </h3>

                            <div class="collapse show" id="widget-5">
                                <div class="widget-body">
                                    <div class="filter-price">
                                        <div class="filter-price-text">
                                            Price Range <strong>(KES)</strong>:
                                            <span id="filter-price-range"></span>
                                        </div>

                                        <div id="price-slider"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </aside>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script src="{{ url('assets/front/js/nouislider.min.js') }}"></script>
<script src="{{ url('assets/front/js/wNumb.js') }}"></script>
<script type="text/javascript">
    $('.sidebar-filter-clear').on('click', function(e) {
        $('.sidebar-shop').find('input').prop('checked', false);
        e.preventDefault();
        $('#get_sort_by_id').val('');
        $('#get_sub_category_id').val('');
        $('#get_brand_id').val('');
        $('#get_color_id').val('');
        $('#get_start_price').val('');
        $('#get_end_price').val('');
        FilterForm();
    });

    $('.changeSortBy').change(function() {
        var id = $(this).val();
        $('#get_sort_by_id').val(id);
        FilterForm();
    });


    $('.changeCategory').change(function() {
        var ids = '';
        $('.changeCategory').each(function() {
            if (this.checked) {
                var id = $(this).val();
                ids += id + ',';
            }
        });
        $('#get_sub_category_id').val(ids);
        FilterForm();
    });
    $('.changeBrand').change(function() {
        var ids = '';
        $('.changeBrand').each(function() {
            if (this.checked) {
                var id = $(this).val();
                ids += id + ',';
            }
        });
        $('#get_brand_id').val(ids);
        FilterForm();
    });

    $('.changeColor').click(function() {
        var id = $(this).attr('id');
        var status = $(this).attr('data-val');
        if (status == 0) {
            $(this).attr('data-val', 1);
            $(this).addClass('color-active');
        } else {
            $(this).attr('data-val', 0);
            $(this).removeClass('color-active');
        }

        var ids = '';
        $('.changeColor').each(function() {
            var status = $(this).attr('data-val');
            if (status == 1) {
                var id = $(this).attr('id');
                ids += id + ',';
            }
        });
        $('#get_color_id').val(ids);
        FilterForm();
    });


    var xhr;

    function FilterForm() {
        if (xhr && xhr.readyState != 4) {
            xhr.abort();
        }
        xhr = $.ajax({
            type: "POST",
            url: "{{ url('product_filter_ajax') }}",
            data: $('#FilterForm').serialize(),
            dataType: "json",
            success: function(data) {
                $('#getProductAjax').html(data.success);
                $('.loadMore').attr('data-page', data.page);
                if (data.page == 0) {
                    $('.loadMore').hide();
                } else {
                    $('.loadMore').show();
                }
            },
            error: function(data) {

            }
        });
    }


    $('body').delegate('.loadMore', 'click', function() {
        var page = $(this).attr('data-page');
        $('.loadMore').html('Loading...');
        if (xhr && xhr.readyState != 4) {
            xhr.abort();
        }
        xhr = $.ajax({
            type: "POST",
            url: "{{ url('product_filter_ajax') }}?page=" + page,
            data: $('#FilterForm').serialize(),
            dataType: "json",
            success: function(data) {
                $('#getProductAjax').append(data.success);
                $('.loadMore').attr('data-page', data.page);
                $('.loadMore').html('Load More');
                if (data.page == 0) {
                    $('.loadMore').hide();
                } else {
                    $('.loadMore').show();
                }
            },
            error: function(data) {

            }
        });
    });


    var i = 0;
    if (typeof noUiSlider === 'object') {
        var priceSlider = document.getElementById('price-slider');

        noUiSlider.create(priceSlider, {
            start: [0, 150000],
            connect: true,
            step: 100,
            margin: 400,
            range: {
                'min': 0,
                'max': 150000
            },
            tooltips: true,
            format: wNumb({
                decimals: 0,
                // prefix: 'KES '
            })
        });

        priceSlider.noUiSlider.on('update', function(values, handle) {
            $('#filter-price-range').text(values.join(' - '));
            var get_start_price = values[0];
            var get_end_price = values[1];
            $('#get_start_price').val(get_start_price);
            $('#get_end_price').val(get_end_price);
            if (i == 0 || i == 1) {
                i++;
            } else {
                FilterForm();
            }
        });
    }
</script>
@endsection