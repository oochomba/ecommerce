<?php

namespace App\Http\Controllers;

use App\Models\OrderItemModel;
use App\Models\OrderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\ProductModel;
use App\Models\ProductSizeModel;
use App\Models\DiscountCodeModel;
use App\Models\ShippingChargeModel;
use App\Models\ColorModel;
use App\Models\User;
use Cart;
use Hash;
use Illuminate\Support\Facades\Auth;
use AmrShawky\LaravelCurrency\Facade\Currency;



class PaymentController extends Controller
{
    var $data;
    var $allowShipping;
    var $discountAllowed;

    public function __construct()
    {
        $this->allowShipping = true;
        $this->discountAllowed = true;
    }
    public function cart(Request $request)
    {
        $this->data['meta_title'] = 'Shopping cart';
        return view("payment.cart", $this->data);
    }
    public function add_to_cart(Request $request)
    {
        $product = ProductModel::find($request->product_id);
        $total = !empty($product->price) ? $product->price : 0;
        if (!empty($request->size_id)) {
            $size_id = $request->size_id;
            $getSize = ProductSizeModel::find($size_id);
            $size_price = !empty($getSize->price) ? $getSize->price : 0;
            $total = $total + $size_price;
        } else {
            $size_id = 0;
        }
        $color_id = !empty($request->color_id) ? $request->color_id : "0";

        Cart::add([
            'id' => $product->id,
            'name' => $product->title,
            'price' => $total,
            'quantity' => $request->qty,
            'attributes' => [
                'size_id' => $size_id,
                'color_id' => $color_id
            ]

        ]);

        return redirect()->back()->with('success', 'Item Added');
    }

    public function delete_cart_item($id)
    {
        Cart::remove($id);
        return redirect()->back()->with('success', 'Item remove');
    }

    public function update_cart(Request $request)
    {
        foreach ($request->cart as $cart) {
            Cart::update($cart['id'], array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $cart['qty']
                ),
            ));
        }
        return redirect()->back()->with('success', 'Shopping Cart updated successfully');
    }

    public function checkout(Request $request)
    {
        if (Cart::isEmpty()) {
            return redirect()->back()->with('error', 'Please shop first before checkout');
        }
        if ($this->allowShipping == true) {
            $this->data['getShipping'] = ShippingChargeModel::checkShipping();
        }
        $this->data['discountAllowed'] = $this->discountAllowed;
        $this->data['meta_title'] = 'Checkout';
        return view("payment.checkout", $this->data);
    }

    public function apply_discount(Request $request)
    {

        $getDiscount = DiscountCodeModel::checkDiscount($request->discount_code);
        if (!empty($getDiscount)) {
            $total = Cart::getSubTotal();
            if ($getDiscount->type == "Amount") {
                $discount_amount = $getDiscount->percent_amount;
                $payable_total = $total - $discount_amount;
            } else {
                $discount_amount = ($total * $getDiscount->percent_amount) / 100;
                $payable_total = $total - $discount_amount;
            }
            $json['status'] = true;
            $json['message'] = 'Success';
            $json['discount_amount'] = number_format($discount_amount, 2);
            $json['allowShipping'] = $this->allowShipping;
            // $json['payable_total'] = $payable_total;
            if ($this->allowShipping == true) {
                $json['payable_total'] = $payable_total;
            } else {
                $json['payable_total'] = number_format($payable_total, 2);
            }
        } else {
            $json['status'] = false;
            $json['message'] = 'Discount Code not found !!';
            $json['discount_amount'] = '0.00';
            $json['allowShipping'] = $this->allowShipping;
            // $json['payable_total'] = Cart::getSubTotal();
            if ($this->allowShipping == true) {
                $json['payable_total'] = Cart::getSubTotal();
            } else {
                $json['payable_total'] = number_format(Cart::getSubTotal(), 2);
            }
        }
        echo json_encode($json);
    }

    public function place_order(Request $request)
    {
        $validate = 0;
        $message = '';
        if (!empty(Auth::check())) {
            $user_id = Auth::user()->id;
        } else {
            if (!empty($request->is_create)) {
                $checkEmailExists = User::checkEmailExists(trim($request->email));
                if (!empty($checkEmailExists)) {
                    $message = 'The email address already exists. Please use different email';
                    $validate = 1;
                } else {
                    $user = new User();
                    $user->name = trim($request->first_name) . ' ' . trim($request->last_name);
                    $user->email = trim($request->email);
                    $user->password = Hash::make(trim($request->password));
                    $user->save();
                    $user_id = $user->id;
                }
            } else {
                $user_id = '';
            }
        }



        if (empty($validate)) {
            $payable_total = Cart::getSubTotal();
            $discount_amount = 0;
            // $discount_code = '';

            if (!empty($request->discount_code)) {
                $getDiscount = DiscountCodeModel::checkDiscount($request->discount_code);
                if (!empty($getDiscount)) {
                    if ($getDiscount->type == "Amount") {
                        $discount_amount = $getDiscount->percent_amount;
                        $payable_total = $payable_total - $discount_amount;
                    } else {
                        $discount_amount = ($payable_total * $getDiscount->percent_amount) / 100;
                        $payable_total = $payable_total - $discount_amount;
                    }
                }
            }

            $getShipping = ShippingChargeModel::getSingle($request->shipping);
            $shipping_amount = !empty($getShipping->price) ? $getShipping->price : 0;

            $total_amount = $payable_total + $shipping_amount;

            $order = new OrderModel;
            if (!empty($user_id)) {
                $order->user_id = $user_id;
            }
            $order->first_name = trim($request->first_name);
            $order->last_name = trim($request->last_name);
            $order->company = trim($request->company);
            $order->country_code = trim($request->country_code);
            $order->street = trim($request->street);
            $order->appartment = trim($request->appartment);
            $order->city = trim($request->city);
            $order->state = trim($request->state);
            $order->postal_code = trim($request->postal_code);
            $order->phone = trim($request->phone);
            $order->email = trim($request->email);
            $order->note = trim($request->note);
            $order->discount_code = trim($request->discount_code);
            $order->discount_amount = $discount_amount;
            $order->shipping_id = trim($request->shipping);
            $order->payment_method = trim($request->payment_method);
            $order->total_amount = trim($total_amount);
            $order->save();

            foreach (Cart::getContent() as $key => $cart) {
                $order_item = new OrderItemModel;
                $order_item->order_id = $order->id;
                $order_item->product_id = $cart->id;
                $order_item->quantity = $cart->quantity;
                $order_item->price = $cart->price;

                $color_id = $cart->attributes->color_id;
                if (!empty($color_id)) {
                    $getColor = ColorModel::where(['id' => $color_id])->first();
                    $order_item->color_name = $getColor->name;
                }

                $size_id = $cart->attributes->size_id;
                if (!empty($size_id)) {
                    $getSize = ProductSizeModel::find($size_id);
                    $order_item->size_name = $getSize->name;
                    $order_item->size_amount = $getSize->price;
                }

                $order_item->total_price = $cart->price;
                $order_item->save();
                $json['status'] = true;
                $json['message'] = 'Success';
                $json['redirect'] = url('payment?user_id=' . trim($request->first_name) . '&order_id=' . base64_encode($order->id));
            }
        } else {
            $json['status'] = false;
            $json['message'] = $message;
        }
        echo json_encode($json);
    }

    public function payment(Request $request)
    {
        if (!empty(Cart::getSubTotal()) && !empty($request->user_id) && !empty($request->order_id)) {
            $oder_id = base64_decode($request->order_id);
            $first_name = $request->user_id;
            $getOrder = OrderModel::where(['id' => $oder_id, 'first_name' => $first_name])->first();
            if (!empty($getOrder)) {
                if ($getOrder->payment_method == 'cash') {
                    $getOrder->is_payment = 1;
                    $getOrder->save();
                    Cart::clear();
                    return redirect('cart')->with('success', 'Your order has been successfully placed');
                } elseif ($getOrder->payment_method == 'paypal') {

                  $q=  Currency::convert()
                  ->from('GBP')
                  ->to('NGN')
                  ->amount(150)
                  ->get();
                  dd($q);

                    $query = array();
                    $query['business'] = 'oochomba-facilitator@gmail.com';
                    $query['cmd'] = '_xclick';
                    $query['item_name'] = config('siteconfig.sitename');
                    $query['no_shipping'] = 1;
                    $query['item_number'] = $getOrder->id;
                    $query['amount'] = $getOrder->total_amount;
                    $query['currency_code'] = 'USD';
                    $query['cancel_return'] = url('checkout');
                    $query['return'] = url('paypal/success-payment');
                    $query_string = http_build_query($query);
                    // dd($query_string);
                    // http://127.0.0.1:8000/payment?user_id=obadiah&order_id=MjU=
                    header('Location: https://www.sandbox.paypal.com/cgi-bin/webscr?' . $query_string);
                    //  header('Location: https://www.paypal.com/cgi-bin/webscr?'.$query_string);
                    exit();
                } elseif ($getOrder->payment_method == 'stripe') {
                    echo 'Stripe';
                }
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function paypal_success_payment(Request $request)
    {
        dd($request->all());
    }
}
