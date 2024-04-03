<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DiscountCodeModel;
use Auth;
use Carbon\Carbon;

class DiscountCodeController extends Controller
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
        if (is_null(Auth::user()) || !Auth::user()->can('discountCode.view')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $this->data['discountcodes'] = DiscountCodeModel::select('discount_code.*', 'users.name as created_by_name')
            ->join('users', 'users.id', '=', 'discount_code.created_by')
            ->where(['discount_code.is_delete' => 0])
            ->orderBy("discount_code.id", "desc")
            ->paginate(100);

        $this->data['page_title'] = 'Discount Code';
        return view('admin.discountcode.list', $this->data);
    }


    /**
     * load add resource view
     */
    public function add()
    {
        if (is_null(Auth::user()) || !Auth::user()->can('discountCode.create')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $this->data['page_title'] = 'Add Discount Code';
        return view('admin.discountcode.add', $this->data);
    }

    /**
     * save resource info
     */
    public function store(Request $request)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('discountCode.create')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $rules = [
            'name'     => 'required|unique:discount_code',
            'type'    => 'required',
            'percent_amount' => 'required',
            'expire_date' => 'required',
            'status'   => 'required',
        ];

        $request->validate($rules, [
            'name.required'   => 'Please enter discount code name',
            'type.required'  => 'Please select discount type',
            'percent_amount.required'  => 'Please enter amount',
            'expire_date.required'  => 'Please enter expiration date',
            'status.required' => 'Please select discount code status',
        ]);

        $saveData = [
            'name'     => trim($request->name),
            'type'    => trim($request->type),
            'percent_amount'    => trim($request->percent_amount),
            'expire_date'    => trim($request->expire_date),
            'status'   => trim($request->status),
            'created_by'   => Auth::user()->id,
        ];
        DiscountCodeModel::create($saveData);
        return redirect('admin/discountcode/list')->with('success', 'DiscountCode ' . $request->name . ' created !!');
    }


    /**
     * edit resource details
     */
    public function edit($id)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('discountCode.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        if (!is_numeric($id)) {
            return redirect('admin/discountcode/list')->with('error', 'Some technical error occurred. Please try again later');
        }
        $this->data['discountcode'] = DiscountCodeModel::where(['id' => $id])->get()->first();
        if (empty($this->data['discountcode'])) {
            return redirect('admin/discountcode/list')->with('error', 'Some technical error occurred. Please try again later');
        }

        $this->data['page_title'] = ucfirst($this->data['discountcode']->name);
        return view('admin.discountcode.edit', $this->data);
    }

    /**
     * update entry
     */
    public function update($id, Request $request)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('discountCode.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $rules = [
            'name'     => 'required|unique:discount_code,name,' . $id,
            'type'    => 'required',
            'percent_amount' => 'required',
            'expire_date' => 'required',
            'status'   => 'required',
        ];

        $request->validate($rules, [
            'name.required'   => 'Please enter discount code name',
            'type.required'  => 'Please select discount type',
            'percent_amount.required'  => 'Please enter amount',
            'expire_date.required'  => 'Please enter expiration date',
            'status.required' => 'Please select discount code status',
        ]);

        $updateData = [
            'name'     => trim($request->name),
            'type'    => trim($request->type),
            'percent_amount'    => trim($request->percent_amount),
            'expire_date'    => trim($request->expire_date),
            'status'   => trim($request->status),
            'created_by'   => Auth::user()->id,
        ];

        DiscountCodeModel::where('id', $id)->update($updateData);
        return redirect('admin/discountcode/list')->with('success', 'Discount Code successively updated !!');
    }

    /**
     * delete entry
     */
    public function delete(int $id, Request $request)
    {
        if (is_null(Auth::user()) || !Auth::user()->can('discountCode.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to access this page');
        }
        $row = DiscountCodeModel::where(['id' => $id])->get()->first();
        if (!is_null($row)) {
            $deleteData = [
                'is_delete' => 1,
                'deleted_by' => Auth::user()->id,
                'deleted_on' => Carbon::now(),
            ];
            DiscountCodeModel::where('id', $id)->update($deleteData);
        }
    }
}
