<?php

namespace App\Http\Controllers\Customer;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customer.index')->withCustomers(Customer::all());
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $request->merge(['receipt_id' => 'C'.(substr(Appliance_Invoice::where('type', 0)->max('receipt_id'), 1) + 1), 'created_by' => Auth::user()->id]);

        $this->validate($request, [
            'receipt_id' => 'required|unique:appliance__invoices',
            'job_id' => 'required',
            'price' => 'required|numeric|min:0',
            'customer_name' => 'required',
            'address' => 'required',
            'created_by' => 'required|exists:users,id',
        ]);

        $obj = Appliance_Invoice::create($request->all());
        if ($obj) {
            return redirect('appliance/invoice/job/'.$obj->id)->withErrors('添加成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }

    public function edit($id)
    {
        return view('appliance.invoice.job.edit')->withInvoice(Appliance_Invoice::find($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
//            'receipt_id' => 'required|unique:appliance__invoices,receipt_id,'.$id,
            'job_id' => 'required',
            'price' => 'required|numeric|min:0',
            'fee' => 'numeric|min:0',
            'customer_name' => 'required',
            'address' => 'required',
        ]);

        $t = $request->all();
        if($t['fee']>$t['price']){
            return redirect()->back()->withInput()->withErrors('invalid deliver fee amount！');
        }
        if (Appliance_Invoice::find($id)->update($t)) {
            return redirect('appliance/invoice/job/'.$id)->withErrors('更新成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

    public function show($id)
    {
        return view('appliance.invoice.job.show')->withInvoice(Appliance_Invoice::with('hasManyStocks')->find($id));
    }
}
