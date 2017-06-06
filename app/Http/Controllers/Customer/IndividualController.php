<?php

namespace App\Http\Controllers\Customer;

use App\Address;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class IndividualController extends Controller
{
    public function index()
    {
        return view('customer.individual.index')->withCustomers(Customer::where('type', 0)->with('getDefaultAddress')->get());
    }

    public function create()
    {
        return view('customer.individual.create');
    }

    public function store(Request $request)
    {
        $t = $request->all();
        $this->validate($request, [
            'first' => 'required',
            'phone' => 'required_without_all:mobile|numeric|unique:customers',
            'mobile' => 'required_without_all:phone|numeric|unique:customers',
            'email' => 'email|unique:customers',
            'street' => 'required|unique:addresses',
            'sub' => 'required',
            'city' => 'required',
//            'zip' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $customer = Customer::create($t);
            $t['customer_id'] = $customer->id ;
            $t['type'] = 1;
            Address::create($t);
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
        DB::commit();
        return redirect('customer/individual')->withErrors('添加成功！');
    }

    public function edit($id)
    {
        return view('customer.individual.edit')->withCustomer(Customer::find($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
//            'type' => 'required|min:0|max:1',
            'first' => 'required',
            'phone' => 'required_without_all:mobile|numeric|unique:customers,phone,'.$id,
            'mobile' => 'required_without_all:phone|numeric|unique:customers,mobile,'.$id,
            'email' => 'unique:customers,email,'.$id,
        ]);

        if (Customer::find($id)->update($request->all())) {
            return redirect('customer/individual/'.$id)->withErrors('更新成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

    public function show(Request $request, $id)
    {
        Session::flash('backUrl', $request->fullUrl());
        return view('customer.individual.show')->withCustomer(Customer::with('hasManyAddresses')->find($id));
    }

}
