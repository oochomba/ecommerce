@foreach ($products as $product)
    @php
        $productImage = $product->getImageSingle($product->id);
    @endphp
    <div class="col-12 col-md-4 col-lg-4 {{Request::segment(1)=='shop'?'col-xl-3':'col-xl-4'}}">
        <div class="product product-7 text-center">
            <figure class="product-media">
                @if (!empty($product->tag))
                    <span
                        class="product-label label-{{ $product->tag }}">{{ $product->tag == 'out' ? ucfirst($product->tag) . ' of Stock' : ucfirst($product->tag) }}</span>
                @endif
                @if (!empty($productImage))
                    <a href="{{ url($product->slug) }}">
                        <img style="height: 203px;  width: 100%; object-fit: cover;"
                            src="{{ $productImage->getImageInfo() }}" alt="{{ $product->title }}" class="product-image">
                    </a>
                @endif


                <div class="product-action-vertical">
                    <a href="#" class="btn-product-icon btn-wishlist btn-expandable">
                        <span>add to wishlist</span>
                    </a>
                </div>

            </figure>

            <div class="product-body">
                <div class="product-cat">
                    @if (!empty($sub_category))
                    @else
                        <a
                            href="{{ url($product->category_slug . '/' . $product->sub_category_slug) }}">{{ ucwords($product->sub_category_name) }}</a>
                    @endif

                </div>
                <h3 class="product-title"><a href="{{ url($product->slug) }}">{{ ucfirst($product->title) }}</a>
                </h3>
                <div class="intro-price">
                    @if (!empty($product->old_price))
                        <sup class="intro-old-price">KES {{ number_format($product->old_price, 2) }}</sup>
                    @endif
                    <span class="text-third product-price price-x">
                        KES {{ number_format($product->price, 2) }}
                        {{-- <sup>.99</sup> --}}
                    </span>
                </div>
                {{-- <div class="product-price">
                    KES {{ number_format($product->price, 2) }}
                </div> --}}
                <div class="ratings-container">
                    <div class="ratings">
                        <div class="ratings-val" style="width: 20%;"></div>
                    </div>
                    <span class="ratings-text">( 2 Reviews )</span>
                </div>

            </div>
        </div>
    </div>
@endforeach
