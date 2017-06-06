<?php

namespace App\Http\Controllers\Contact;

use App\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
    public function index()
    {
        return view('contact.supplier.index')->withSuppliers(Supplier::all());
    }

    public function create()
    {
        return view('contact.supplier.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required_without_all:mobile|numeric|unique:suppliers',
            'mobile' => 'required_without_all:phone|numeric|unique:suppliers',
            'email' => 'email|unique:suppliers',
        ]);
        if (Supplier::create($request->all())) {
            return redirect('contact/supplier')->withErrors('添加成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }

    public function edit($id)
    {
        return view('contact.supplier.edit')->withSupplier(Supplier::find($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required_without_all:mobile|numeric|unique:suppliers,phone,'.$id,
            'mobile' => 'required_without_all:phone|numeric|unique:suppliers,mobile,'.$id,
            'email' => 'required|unique:suppliers,email,'.$id,
        ]);

        if (Supplier::find($id)->update($request->all())) {
            return redirect('contact/supplier/')->withErrors('更新成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

//    public function show(Request $request, $id)
//    {
//        Session::flash('backUrl', $request->fullUrl());
//        return view('customer.individual.show')->withCustomer(Customer::with('hasManyAddresses')->find($id));
//    }
}
