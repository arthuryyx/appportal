<?php

namespace App\Http\Controllers\Appliance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Appliance_Invoice;

class JobController extends Controller
{
    public function index()
    {
        return view('appliance.invoice.job.index')->withInvoices(Appliance_Invoice::where('type', 0)->get());
    }

    public function create()
    {
        return view('appliance.invoice.job.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'receipt_id' => 'required|unique:appliance__invoices',
            'job_id' => 'required',
            'customer_name' => 'required',
            'address' => 'required',
        ]);

        $t = $request->all();
        $t['created_by'] = Auth::user()->id;

        if (Appliance_Invoice::create($t)) {
            return redirect('appliance/invoice/job')->withErrors('添加成功！');
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
            'receipt_id' => 'required|unique:appliance__invoices,receipt_id,'.$id,
            'job_id' => 'required',
            'customer_name' => 'required',
            'address' => 'required',
        ]);

        if (Appliance_Invoice::find($id)->update($request->all())) {
            return redirect('appliance/invoice/job')->withErrors('更新成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

    public function show($id)
    {
        return view('appliance.invoice.job.show')->withInvoice(Appliance_Invoice::with('hasManyStocks')->find($id));
    }
}
