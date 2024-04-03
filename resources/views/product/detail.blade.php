@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{url('assets/front/css/plugins/nouislider/nouislider.css')}}">
<style>
    .my-color:hover {
        box-shadow: none !important;
    }

    button.add-to-cart {
        background-color: transparent;
    }

    .border-bottom-none {
        border-bottom: none !important;
    }
</style>
@endsection

@section('content')
<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-bottom-none mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('shop')}}">Shop</a></li>
                <li class="breadcrumb-item"><a href="{{url($product->getCategory->slug)}}">{{$product->getCategory->name}}</a></li>
                <li class="breadcrumb-item"><a href="{{url($product->getCategory->slug.'/'.$product->getSubCategory->slug)}}">{{$product->getSubCategory->name}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$product->title}}</li>
            </ol>

        </div>
    </nav>

    <div class="page-content">
     
            <div class="container bg-white p-3">
                <div class="product-details-top mb-2 pt-1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="product-gallery">
                                @php
                                $productImage = $product->getImageSingle($product->id);
                                @endphp
                                <figure class="product-main-image">
                                    @if (!empty($productImage))
                                    <img id="product-zoom" src="{{ $productImage->getImageInfo() }}" data-zoom-image="{{ $productImage->getImageInfo() }}" alt="product image">

                                    <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                        <i class="icon-arrows"></i>
                                    </a>
                                    @endif
                                </figure>

                                <div id="product-zoom-gallery" class="product-image-gallery">
                                    @foreach($product->getImage as $image)
                                    @if(!empty($image->getImageInfo()))
                                    <a class="product-gallery-item" href="#" data-image="{{$image->getImageInfo()}}" data-zoom-image="{{$image->getImageInfo()}}">
                                        <img src="{{$image->getImageInfo()}}" style="height: 136px;  width:136px; object-fit: cover;" alt="product side">
                                    </a>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="product-details">
                                <h1 class="product-title">{{ucfirst($product->title)}}</h1>
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 80%;"></div>
                                    </div>
                                    <a class="ratings-text" href="#product-review-link" id="review-link">( 2 Reviews )</a>
                                </div>

                                <div class="product-price">
                                    KES<span class="ml-2 priceTag">{{number_format($product->price, 2)}}</span>
                                </div>

                                <div class="product-content">
                                    <p>
                                        {{$product->short_description}}
                                    </p>
                                </div>


                                <form action="{{url('product/add-to-cart')}}" method="post" class="add-to-cart-form">
                                    {{csrf_field()}}
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    @if (!empty($product->getColor->count()))
                                    <div class="details-filter-row details-row-size">
                                        <label>Color:</label>

                                        <div class="select-custom">
                                            <select name="color_id" id="color_id" class="form-control" required>
                                                <option value="">Select</option>
                                                @foreach ($product->getColor as $color)
                                                <option data-color-id="{{$color->getColor->id}}" value="{{$color->getColor->id}}">{{ucwords($color->getColor->name)}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="product-nav product-nav-dots">
                                            <strong>Color guide:</strong>
                                            @foreach ($product->getColor as $color)
                                            <span href="javascript:;" class="ml-3 my-color" style="background: {{$color->getColor->code}};"><span class="sr-only">Color name</span></span> &nbsp;{{ucwords($color->getColor->name)}}
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    @if (!empty($product->getSize->count()))
                                    <div class="details-filter-row details-row-size">
                                        <label for="size">Size:</label>
                                        <div class="select-custom">
                                            <select name="size_id" id="size_id" class="form-control productSizePrice" required>
                                                <option value="" data-price="0">Select</option>
                                                @foreach ($product->getSize as $size)
                                                <option data-size-id="{{$size->id}}" value="{{$size->id}}" data-price={{!empty($size->price)?$size->price:0}}>{{$size->name}} @if (!empty($size->price))(KES {{number_format($size->price,2)}})@endif</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="details-filter-row details-row-size">
                                        <label for="qty">Qty:</label>
                                        <div class="product-details-quantity input-qty">
                                            <input type="number" name="qty" id="qty" class="form-control" value="1" min="1" max="100" step="1" data-decimals="0" required>
                                        </div>
                                    </div>

                                    <div class="product-details-action">
                                        <button class="btn-product btn-cart add-to-cart">add to cart</button>

                                        <div class="details-action-wrapper">
                                            <a href="#" class="btn-product btn-wishlist" title="Wishlist"><span>Add to Wishlist</span></a>
                                            <a href="#" class="btn-product btn-compare" title="Compare"><span>Add to Compare</span></a>
                                        </div>
                                    </div>
                                </form>

                                <div class="product-details-footer">
                                    <div class="product-cat">
                                        <span>Category:</span>
                                        <a href="{{url($product->getCategory->slug)}}">{{$product->getCategory->name}}</a>,
                                        <a href="{{url($product->getCategory->slug.'/'.$product->getSubCategory->slug)}}">{{$product->getSubCategory->name}}</a>
                                    </div>

                                    <div class="social-icons social-icons-sm">
                                        <span class="social-label">Share:</span>
                                        <a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                        <a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                                        <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                                        <a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product-details-tab product-details-extended">
                <div class="container">
                    <ul class="nav nav-pills justify-content-center" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab" aria-controls="product-info-tab" aria-selected="false">Additional information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab" aria-selected="false">Shipping & Returns</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab" role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews (2)</a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                        <div class="product-desc-content">
                            <div class="container">
                                {!!$product->description!!}
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                        <div class="product-desc-content">
                            <div class="container">
                                {!!$product->additional_description!!}
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel" aria-labelledby="product-shipping-link">
                        <div class="product-desc-content">
                            <div class="container">
                                {!!$product->shipping_returns!!}
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="product-review-tab" role="tabpanel" aria-labelledby="product-review-link">
                        <div class="reviews">
                            <div class="container">
                                <h3>Reviews (2)</h3>
                                <div class="review">
                                    <div class="row no-gutters">
                                        <div class="col-auto">
                                            <h4><a href="#">Samanta J.</a></h4>
                                            <div class="ratings-container">
                                                <div class="ratings">
                                                    <div class="ratings-val" style="width: 80%;"></div>
                                                </div>
                                            </div>
                                            <span class="review-date">6 days ago</span>
                                        </div>
                                        <div class="col">
                                            <h4>Good, perfect size</h4>

                                            <div class="review-content">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus cum dolores assumenda asperiores facilis porro reprehenderit animi culpa atque blanditiis commodi perspiciatis doloremque, possimus, explicabo, autem fugit beatae quae voluptas!</p>
                                            </div>

                                            <div class="review-action">
                                                <a href="#"><i class="icon-thumbs-up"></i>Helpful (2)</a>
                                                <a href="#"><i class="icon-thumbs-down"></i>Unhelpful (0)</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="review">
                                    <div class="row no-gutters">
                                        <div class="col-auto">
                                            <h4><a href="#">John Doe</a></h4>
                                            <div class="ratings-container">
                                                <div class="ratings">
                                                    <div class="ratings-val" style="width: 100%;"></div>
                                                </div>
                                            </div>
                                            <span class="review-date">5 days ago</span>
                                        </div>
                                        <div class="col">
                                            <h4>Very good</h4>

                                            <div class="review-content">
                                                <p>Sed, molestias, tempore? Ex dolor esse iure hic veniam laborum blanditiis laudantium iste amet. Cum non voluptate eos enim, ab cumque nam, modi, quas iure illum repellendus, blanditiis perspiciatis beatae!</p>
                                            </div>

                                            <div class="review-action">
                                                <a href="#"><i class="icon-thumbs-up"></i>Helpful (0)</a>
                                                <a href="#"><i class="icon-thumbs-down"></i>Unhelpful (0)</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>

           
      


        @if(count($relatedProducts)>0)
        <div class="container bg-white mt-3 pt-3">
            <h2 class="title text-center mb-4">You May Also Like</h2>
            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" data-owl-options='{
                    "nav": false, 
                    "dots": true,
                    "margin": 20,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":1
                        },
                        "480": {
                            "items":2
                        },
                        "768": {
                            "items":3
                        },
                        "992": {
                            "items":4
                        },
                        "1200": {
                            "items":4,
                            "nav": true,
                            "dots": false
                        }
                    }
                }'>


                @foreach($relatedProducts as $relatedProduct)
                <div class="product product-7">
                    <figure class="product-media">
                        <span class="product-label label-new">New</span>
                        @php
                        $productImage = $product->getImageSingle($relatedProduct->id);
                        @endphp
                        <a href="{{$relatedProduct->slug}}">
                            <img src="{{$productImage->getImageInfo()}}" style="height: 276px;  width: 100%; object-fit: cover;" alt="{{$relatedProduct->title}}" class="product-image">
                        </a>

                        <div class="product-action-vertical">
                            <a href="javascript:;" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                        </div>
                    </figure>

                    <div class="product-body">
                        <div class="product-cat">
                            <a href="{{ url($relatedProduct->category_slug . '/' . $relatedProduct->sub_category_slug) }}">{{ $relatedProduct->sub_category_name }}</a>
                        </div>
                        <h3 class="product-title"><a href="{{$relatedProduct->slug}}">{{$relatedProduct->title}}</h3>
                        <div class="product-price">
                            KES {{ number_format($relatedProduct->price, 2) }}
                        </div>
                        <div class="ratings-container">
                            <div class="ratings">
                                <div class="ratings-val" style="width: 20%;"></div>
                            </div>
                            <span class="ratings-text">( 2 Reviews )</span>
                        </div>

                        <div class="product-nav product-nav-dots" style="display: none">
                            <a href="#" class="active" style="background: #cc9966;"><span class="sr-only">Color name</span></a>
                            <a href="#" style="background: #7fc5ed;"><span class="sr-only">Color name</span></a>
                            <a href="#" style="background: #e8c97a;"><span class="sr-only">Color name</span></a>

                        </div>

                    </div>
                </div>
                @endforeach



            </div>
        </div>

        @endif


    </div>
</main>

@endsection

@section('script')
<script src="{{url('assets/front/js/bootstrap-input-spinner.js')}}"></script>
<script src="{{url('assets/front/js/jquery.elevateZoom.min.js')}}"></script>
<script src="{{url('assets/front/js/bootstrap-input-spinner.js')}}"></script>
<script type="text/javascript">
    $('.productSizePrice').change(function() {
        var price = "{{$product->price}}"
        var size_price_selected = $('option:selected', this).attr('data-price');
        var total_price = parseFloat(price) + parseFloat(size_price_selected);
        var formated_price = total_price.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $('.priceTag').html(formated_price);
    });
</script>
@endsection