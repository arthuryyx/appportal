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
        if(Auth::user()->can('appliance_view_all_jobs')){
            return view('appliance.invoice.job.index')->withInvoices(Appliance_Invoice::with('hasManyStocks')->with('getCreated_by')->with('hasManyDeposits')->with('getState')->get());
        } else{
            return view('appliance.invoice.job.index')->withInvoices(Appliance_Invoice::where('created_by', Auth::user()->id)->with('hasManyStocks')->with('getCreated_by')->with('hasManyDeposits')->with('getState')->get());
        }
    }

    public function create()
    {
        return view('appliance.invoice.job.create');
    }

    public function store(Request $request)
    {
        $request->merge(['receipt_id' => 'C'.(substr(Appliance_Invoice::latest()->first()->receipt_id, 1) + 1), 'created_by' => Auth::user()->id]);
        $this->validate($request, [
            'receipt_id' => 'required|unique:appliance__invoices',
            'price' => 'required|numeric|min:0',
            'customer_name' => 'required',
            'phone' => 'numeric',
            'email' => 'email',
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
            'price' => 'required|numeric|min:0',
            'customer_name' => 'required',
            'phone' => 'numeric',
            'email' => 'email',
            'address' => 'required',
        ]);

        if (Appliance_Invoice::find($id)->update($request->all())) {
            return redirect('appliance/invoice/job/'.$id)->withErrors('更新成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

    public function show($id)
    {
        return view('appliance.invoice.job.show')->withInvoice(Appliance_Invoice::with('hasManyStocks.appliance.belongsToBrand')->with('hasManyStocks.appliance.belongsToCategory')->find($id));
    }

    public function cidToJob($id)
    {
        if ($job = Appliance_Invoice::where('receipt_id', 'C'.$id)->select('id')->first()){
            return redirect('appliance/invoice/job/'.$job->id);
        }else{
            return redirect()->back()->withErrors("Job doesn't exist!");
        }
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

//    public function html($id){
//        return view('appliance.pdf.invoice')->withInvoice(Appliance_Invoice::with('hasManyStocks')->find($id));
//    }
}
