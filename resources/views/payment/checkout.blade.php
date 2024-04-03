@extends('layouts.app')
@section('style')
    <style type="text/css">
        .summary-shipping-row td {
            border-bottom: .1rem solid #ebebeb !important;
        }

        .label-pay {
            font-weight: 300 !important;
            font-family: 'Poppins';
            /* padding: .7rem 0 .7rem 3rem !important; */
            font-size: 1.4rem !important;
        }
    </style>
@endsection

@section('content')
    <main class="main">
        {{-- <div class="page-header text-center" style="background-image: url('assets/front/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Checkout</h1>
            </div>
        </div> --}}
        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-0 border-bottom-none">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </div>
        </nav>

        <div class="page-content">
            <div class="checkout">
                <div class="container bg-white p-3 pt-lg-2">
                    <form action="" id="submitForm" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-9">
                                <h2 class="checkout-title">Billing Details</h2>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>First Name <span class="text text-danger">*</span></label>
                                        <input type="text" name="first_name" class="form-control" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <label>Last Name <span class="text text-danger">*</span></label>
                                        <input type="text" name="last_name" class="form-control" required>
                                    </div>
                                </div>

                                <label>Company Name (Optional)</label>
                                <input type="text" name="company" class="form-control">

                                <label>Country <span class="text text-danger">*</span></label>
                                <select name="country_code" id="" class="form-control">
                                    <option value="">Select Country</option>
                                    <option value="KE">Kenya</option>
                                </select>

                                <label>Street address <span class="text text-danger">*</span></label>
                                <input type="text" name="street" class="form-control"
                                    placeholder="House number and Street name" required>
                                <input type="text" name="appartment" class="form-control"
                                    placeholder="Appartments, suite, unit etc ..." required>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Town / City <span class="text text-danger">*</span></label>
                                        <input type="text" name="city" class="form-control" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <label>State <span class="text text-danger">*</span></label>
                                        <input type="text" name="state" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Postcode / ZIP <span class="text text-danger">*</span></label>
                                        <input type="text" name="postal_code" class="form-control" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <label>Phone <span class="text text-danger">*</span></label>
                                        <input type="tel" name="phone" class="form-control" required>
                                    </div>
                                </div>

                                <label>Email address <span class="text text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required>

                                @if (empty(Auth::check()))
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="is_create" class="custom-control-input createAccount"
                                            id="checkout-create-acc">
                                        <label class="custom-control-label" for="checkout-create-acc">Create an
                                            account?</label>
                                    </div>

                                    <div id="showPassword" style="display: none">
                                        <label>Password <span class="text text-danger">*</span></label>
                                        <input type="text" name="password" class="form-control passAccount">
                                    </div>
                                @endif

                                <label>Order notes (optional)</label>
                                <textarea class="form-control" name="note" cols="30" rows="4"
                                    placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                            </div>
                            <aside class="col-lg-3">
                                <div class="summary">
                                    <h3 class="summary-title">Your Order</h3>
                                    <table class="table table-summary">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Total</th>
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
                                                        <td>
                                                            <a href="{{ url($getCartProduct->slug) }}">
                                                                {{ $getCartProduct->title }}
                                                            </a>
                                                        </td>
                                                        <td>KES {{ number_format($cart->price * $cart->quantity, 2) }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            <tr class="summary-subtotal">
                                                <td>Subtotal:</td>
                                                <td>KES {{ number_format(Cart::getSubTotal(), 2) }}</td>
                                            </tr>

                                            @if (!empty($discountAllowed) && $discountAllowed == true)
                                                <tr>
                                                    <td colspan="2">
                                                        <div class="cart-discount">
                                                            <div class="input-group">
                                                                <input type="text" name="discount_code"
                                                                    class="form-control" placeholder="Discount Code"
                                                                    id="discountCode">
                                                                <div class="input-group-append">
                                                                    <button style="height: 40px;" id="checkForDiscount"
                                                                        class="btn btn-outline-primary-2" type="button">
                                                                        <i class="icon-long-arrow-right"></i>
                                                                    </button>
                                                                </div>
                                                                <span
                                                                    class="col-12 invalid feedback text text-danger DisCodeError"
                                                                    style="text-align: left !important" role="alert">
                                                                </span>

                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Discount:</td>
                                                    <td>KES <span id="getDiscountAmount">0.00</span></td>
                                                </tr>
                                            @endif

                                            @if (!empty($getShipping))
                                                <tr class="summary-shipping">
                                                    <td>Shipping:</td>
                                                    <td>&nbsp;</td>
                                                </tr>

                                                @foreach ($getShipping as $shipping)
                                                    <tr class="summary-shipping-row">
                                                        <td>
                                                            <div class="custom-control custom-radio mb-0 mt-0">
                                                                <input type="radio" value="{{ $shipping->id }}"
                                                                    data-price="{{ !empty($shipping->price) ? $shipping->price : 0 }}"
                                                                    id="free-shipping-{{ $shipping->id }}" name="shipping"
                                                                    class="custom-control-input getShippingCharge"
                                                                    required>
                                                                <label class="custom-control-label mb-0 mt-0"
                                                                    for="free-shipping-{{ $shipping->id }}">{{ $shipping->name }}</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="mb-1 mt-1">
                                                                KES
                                                                {{ !empty($shipping->price) ? number_format($shipping->price, 2) : '0.00' }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif

                                            <tr class="summary-total">
                                                <td>Total:</td>
                                                <td>KES <span id="getPayableTotal">
                                                        {{ number_format(Cart::getSubTotal(), 2) }}</span></td>
                                            </tr>
                                        </tbody>
                                    </table>


                                    <input type="hidden" value="0" id="getShippingChargeTotal">
                                    <input type="hidden" value="{{ Cart::getSubTotal() }}" id="payableTotal">
                                    <div class="accordion-summary" id="accordion-payment">


                                        <div class="border-top">
                                            <p class="mt-2 mb-1"
                                                style="color: #333;
                                            font-weight: 400;
                                            font-size: 1.6rem;">
                                                Payment Method:</p>
                                            <div class="custom-control custom-radio mt-0 mb-0">
                                                <input type="radio" value="cash" id="cash"
                                                    name="payment_method" class="custom-control-input" required>
                                                <label class="custom-control-label mt-0 mb-0 label-pay"
                                                    for="cash">Cash on
                                                    delivery</label>
                                            </div>

                                            <div class="custom-control custom-radio mb-0 mt-0">
                                                <input type="radio" value="paypal" id="PayPal"
                                                    name="payment_method" class="custom-control-input" required>
                                                <label class="custom-control-label mt-0 mb-0 label-pay"
                                                    for="PayPal">PayPal
                                                </label>
                                            </div>

                                            <div class="custom-control custom-radio mb-0 mt-0">
                                                <input type="radio" value="stripe" id="Stripe"
                                                    name="payment_method" class="custom-control-input" required>
                                                <label class="custom-control-label mb-0 mt-0 label-pay"
                                                    for="Stripe">Credit Card
                                                    (Stripe)
                                                </label>
                                            </div>
                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
                                        <span class="btn-text">Place Order</span>
                                        <span class="btn-hover-text">Proceed to Checkout</span>
                                    </button>
                                    <div class="mt-3">
                                        <img src="{{ url('assets/front/images/payments-summary.png') }}"
                                            alt="payments cards">
                                    </div>
                                </div>
                            </aside>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script type="text/javascript">
        // $(document).ready(function() {
        //     if ($('.createAccount').checked = true) {
        //         $('#showPassword').show();
        //     } else {
        //         $('#showPassword').hide();
        //     }

        // });

        $('body').delegate('.getShippingCharge', 'change', function() {
            var price = $(this).attr('data-price');
            var total = $('#payableTotal').val();
            $('#getShippingChargeTotal').val(price);
            var final_plus_shipping = parseFloat(price) + parseFloat(total);
            $('#getPayableTotal').html(final_plus_shipping.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                ","));
        });


        $('body').delegate('.createAccount', 'change', function() {
            if (this.checked) {
                $('#showPassword').show();
                $('.passAccount').prop('required', true);
            } else {
                $('#showPassword').hide();
                $('.passAccount').prop('required', false);
            }
        });


        submitForm
        $('body').delegate('#submitForm', 'submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ url('place-order') }}",
                data: new FormData(this),
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(data) {
                    if (data.status == false) {
                        alert(data.message);
                    } else {
                        window.location.href = data.redirect;
                    }
                },
                error: function(data) {

                }
            });
        });


        $('body').delegate('#checkForDiscount', 'click', function() {
            $('.DisCodeError').html('');
            $('#discountCode').removeClass('is-invalid');
            var discountCode = $('#discountCode').val();
            if (discountCode.length !== 0) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('apply-discount') }}",
                    data: {
                        discount_code: discountCode,
                        "_token": "{{ csrf_token() }}",
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status == true) {
                            $('#getDiscountAmount').html(data.discount_amount);
                            var shipping = $('#getShippingChargeTotal').val();
                            if (data.allowShipping == true) {
                                var sum_total = parseFloat(shipping) + parseFloat(data.payable_total);
                                var final_total = sum_total.toFixed(2).toString().replace(
                                    /\B(?=(\d{3})+(?!\d))/g, ",");
                            } else {
                                var final_total = data.payable_total;
                            }
                            $('#getPayableTotal').html(final_total);

                            $('#payableTotal').val(data.payable_total);
                        } else {
                            $('#discountCode').addClass('is-invalid');
                            $('.DisCodeError').html(data.message);
                        }
                    },
                    error: function(data) {

                    }
                });

            } else {
                alert('Please enter a discount code');
            }


        });
    </script>
@endsection
