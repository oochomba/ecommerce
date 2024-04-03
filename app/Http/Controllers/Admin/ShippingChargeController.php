<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingChargeModel;
use Auth;
use Carbon\Carbon;

class ShippingChargeController extends Controller
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
    //
    public function index()
    {
        if (is_null(Auth::user()) || !Auth::user()->can('shippingCharge.view')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $this->data['shippingcharges'] = ShippingChargeModel::select('shipping_charge.*', 'users.name as created_by_name')
            ->join('users', 'users.id', '=', 'shipping_charge.created_by')
            ->where(['shipping_charge.is_delete' => 0])
            ->orderBy("shipping_charge.id", "desc")
            ->paginate(100);

        $this->data['page_title'] = 'Shipping Charges';
        return view('admin.shippingcharge.list', $this->data);
    }


    /**
     * load add resource view
     */
    public function add()
    {
        if (is_null(Auth::user()) || !Auth::user()->can('shippingCharge.create')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $this->data['page_title'] = 'Add Shipping Charge';
        return view('admin.shippingcharge.add', $this->data);
    }

    /**
     * save resource info
     */
    public function store(Request $request)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('shippingCharge.create')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $rules = [
            'name'     => 'required|unique:shipping_charge',
            'price' => 'required',
            'status'   => 'required',
        ];

        $request->validate($rules, [
            'name.required'   => 'Please enter shipping charge name',
            'price.required'  => 'Please enter amount',
            'status.required' => 'Please select shipping charge status',
        ]);

        $saveData = [
            'name'     => trim($request->name),
            'price'    => trim($request->price),
            'status'   => trim($request->status),
            'created_by'   => Auth::user()->id,
        ];
        ShippingChargeModel::create($saveData);
        return redirect('admin/shippingcharge/list')->with('success', 'Shipping charge ' . $request->name . ' created !!');
    }


    /**
     * edit resource details
     */
    public function edit($id)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('shippingCharge.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        if (!is_numeric($id)) {
            return redirect('admin/shippingcharge/list')->with('error', 'Some technical error occurred. Please try again later');
        }
        $this->data['shippingcharge'] = ShippingChargeModel::where(['id' => $id])->get()->first();
        if (empty($this->data['shippingcharge'])) {
            return redirect('admin/shippingcharge/list')->with('error', 'Some technical error occurred. Please try again later');
        }

        $this->data['page_title'] = ucfirst($this->data['shippingcharge']->name);
        return view('admin.shippingcharge.edit', $this->data);
    }

    /**
     * update entry
     */
    public function update($id, Request $request)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('shippingCharge.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }

        $rules = [
            'name'     => 'required|unique:shipping_charge,name,' . $id,
            'price' => 'required',
            'status'   => 'required',
        ];

        $request->validate($rules, [
            'name.required'   => 'Please enter shipping charge name',
            'price.required'  => 'Please enter amount',
            'status.required' => 'Please select shipping charge status',
        ]);

        $updateData = [
            'name'     => trim($request->name),
            'price'    => trim($request->price),
            'status'   => trim($request->status),
            'created_by'   => Auth::user()->id,
        ];

        ShippingChargeModel::where('id', $id)->update($updateData);
        return redirect('admin/shippingcharge/list')->with('success', 'Shipping Charge successively updated !!');
    }

    /**
     * delete entry
     */
    public function delete(int $id, Request $request)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('shippingCharge.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }

        $row = ShippingChargeModel::where(['id' => $id])->get()->first();
        if (!is_null($row)) {
            $deleteData = [
                'is_delete' => 1,
                'deleted_by' => Auth::user()->id,
                'deleted_on' => Carbon::now(),
            ];
            ShippingChargeModel::where('id', $id)->update($deleteData);
        }
    }
}
