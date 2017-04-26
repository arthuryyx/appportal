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
}
