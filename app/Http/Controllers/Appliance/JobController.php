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
        if(Auth::user()->can('root')){
            return view('appliance.invoice.job.index')->withInvoices(Appliance_Invoice::where('type', 0)->get());
        } else{
            return view('appliance.invoice.job.index')->withInvoices(Appliance_Invoice::where('type', 0)->where('created_by', Auth::user()->id)->get());
        }
    }

    public function create()
    {
        return view('appliance.invoice.job.create');
    }

    public function store(Request $request)
    {
        $request->merge(['receipt_id' => 'C'.(substr(Appliance_Invoice::where('type', 0)->max('receipt_id'), 1) + 1), 'created_by' => Auth::user()->id]);

        $this->validate($request, [
            'receipt_id' => 'required|unique:appliance__invoices',
            'job_id' => 'required',
            'price' => 'required|integer|min:0',
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
            'price' => 'required|integer|min:0',
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

    public function paid(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:appliance__invoices,id',
        ]);
        $obj = Appliance_Invoice::with('hasManyDeposits')->find($request->all()['id']);
        if($obj->price <= array_sum($obj->hasManyDeposits->pluck('amount')->all())){
            if($obj->update(['state' => 1])){
                return redirect()->back();
            }else{
                return redirect()->back()->withErrors('更新失败！');
            }
        }else{
            return redirect()->back()->withErrors('定金不足！');
        }
    }
}
