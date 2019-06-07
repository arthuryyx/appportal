<?php

namespace App\Http\Controllers\Appliance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Appliance_Deposit;
use App\Http\Controllers\Controller;

class DepositController extends Controller
{
    public function index($invoice){
        return view('appliance.invoice.job.deposit')
            ->withDeposits(Appliance_Deposit::where('invoice_id', $invoice)->get());
    }

    public function store(Request $request)
    {
        $request->merge(['created_by' => Auth::user()->id]);
        $this->validate($request, [
            'invoice_id' => 'required|exists:appliance__invoices,id',
            'amount' => 'required|numeric',
            'created_by' => 'required|exists:users,id',
        ]);

        if (Appliance_Deposit::create($request->all())) {
            return redirect()->back()->withErrors('添加成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }

    public function pending()
    {
        return view('appliance.invoice.job.payment')->withDeposits(Appliance_Deposit::where('confirmed', 0)->with('getInvoice')->get());
    }

    public function confirm($id)
    {
        try {
            $deposit = Appliance_Deposit::find($id);
            $deposit->confirmed = 1;
            $deposit->update();
        } catch(\Exception $e)
        {
            return redirect()->back()->withErrors('操作失败！');
        }
        return redirect()->back()->withErrors('操作成功！');
    }

}
