<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactModel;
use Auth;

class DashboardController extends Controller
{
    var $data;
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }
    /**
     * @Route("admin/dashboard")
     * load admin dashboard
     */
    public function index()
    {
        if (is_null(Auth::user()) || !Auth::user()->can('dashboard.view')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $this->data['page_title'] = 'Dashboard';
        return view('admin.dashboard', $this->data);
    }
    public function customer_contacts(){
        $this->data['page_title'] = 'Customer Contacts';
        $this->data['contacts'] = ContactModel::all();
        return view('admin.customer_contacts', $this->data);
    }
}
