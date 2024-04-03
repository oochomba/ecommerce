<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    var $data;
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('customer')->user();
            return $next($request);
        });
    }
    public function index()
    {
        $this->data['orders'] = OrderModel::where('user_id', $this->user->id)->orderBy('created_at', 'desc')->paginate(10);
        $this->data['meta_title'] = 'Dashboard';
        return view("customer.dashboard", $this->data);
    }
}
