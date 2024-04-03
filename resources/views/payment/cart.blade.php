@extends('layouts.app')
@section('style')
    <style type="text/css">
        .cursor-pointer {
            cursor: pointer !important;
        }
    </style>
@endsection

@section('content')
    <main class="main">
        {{-- <div class="page-header text-center" style="background-image: url('assets/front/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Shopping Cart</h1>
            </div>
        </div> --}}
        <nav aria-label="breadcrumb" class="breadcrumb-nav border-bottom-none mb-0">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                </ol>
            </div>
        </nav>

        <div class="page-content">
            <div class="cart">
                <div class="container bg-white p-3 pt-lg-2">
                    @include('layouts._message')
                    <div class="row">

                        @if (!Cart::isEmpty())
                            <div class="col-lg-9">
                                <form action="{{ url('update-cart') }}" method="POST">
                                    {{ @csrf_field() }}
                                    <table class="table table-cart table-mobile">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach (Cart::getContent() as $key => $cart)
                                                @if (!empty($cart))
                                                    @php
                                                        $getCartProduct = App\Models\ProductModel::getSingle($cart->id);
                                                        $productImageCart = $getCartProduct->getImageSingle($cart->id);
                                                    @endphp
                                                    <tr>
                                                        <td class="product-col">
                                                            <div class="product">
                                                                <figure class="product-media">
                                                                    <a href="{{ $getCartProduct->slug }}">
                                                                        <img src="{{ $productImageCart->getImageInfo() }}"
                                                                            alt="Product image">
                                                                    </a>
                                                                </figure>

                                                                <h3 class="product-title">
                                                                    <a
                                                                        href="{{ $getCartProduct->slug }}">{{ $getCartProduct->title }}</a>
                                                                </h3>
                                                            </div>
                                                        </td>
                                                        <td class="price-col">KES {{ number_format($cart->price, 2) }}</td>
                                                        <td class="quantity-col">
                                                            <div class="cart-product-quantity">
                                                                <input type="number" name="cart[{{ $key }}][qty]"
                                                                    class="form-control" value="{{ $cart->quantity }}"
                                                                    min="1" max="100" step="1"
                                                                    data-decimals="0" required>
                                                                <input type="hidden" name="cart[{{ $key }}][id]"
                                                                    value="{{ $cart->id }}">
                                                            </div>
                                                        </td>
                                                        <td class="total-col">
                                                            {{ number_format($cart->price * $cart->quantity, 2) }}</td>
                                                        <td class="remove-col"><a
                                                                href="{{ url('delete-cart-item/' . $cart->id) }}"
                                                                class="btn-remove cursor-pointer" title="Remove product"><i
                                                                    class="icon-close"></i></a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div class="cart-bottom">


                                        <button type="submit" class="btn btn-outline-dark-2">
                                            <span>UPDATE CART</span><i class="icon-refresh"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <aside class="col-lg-3">
                                <div class="summary summary-cart">
                                    <h3 class="summary-title">Cart Total</h3>

                                    <table class="table table-summary">
                                        <tbody>
                                            <tr class="summary-subtotal">
                                                <td>Subtotal:</td>
                                                <td style="min-width: 110px !important;">KES
                                                    {{ number_format(Cart::getSubTotal(), 2) }}</td>
                                            </tr>


                                            <tr class="summary-total">
                                                <td>Total:</td>
                                                <td>KES {{ number_format(Cart::getSubTotal(), 2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <a href="{{ url('checkout') }}" class="btn btn-outline-primary-2 btn-order btn-block">
                                        PROCEED TO CHECKOUT
                                    </a>
                                </div>

                                <a href="{{ url('shop') }}" class="btn btn-outline-dark-2 btn-block mb-3">
                                    <span>CONTINUE SHOPPING</span><i class="icon-refresh"></i>
                                </a>
                            </aside>
                        @else
                            <div class="col-lg-12">
                                <h4>Shopping cart is empty !!</h4>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
@endsection
