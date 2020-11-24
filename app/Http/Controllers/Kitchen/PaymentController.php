<?php

namespace App\Http\Controllers\Kitchen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Kitchen_Job;
use App\Kitchen_Payment;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->merge(['created_by' => Auth::user()->id]);
        $this->validate($request, [
            'job_id' => 'required|exists:kitchen__jobs,id',
            'amount' => 'required|numeric',
            'created_by' => 'required|exists:users,id',
        ]);

        $job = Kitchen_Job::find($request->input('job_id'));
        if ($request->input('amount') > $job->price - $job->getPayments->sum('amount'))
            return redirect()->back()->withInput()->withErrors("金额错误，请确认后重试！");

//        DB::beginTransaction();
        try {
            Kitchen_Payment::create($request->input());
//            $job->update(['outstanding' => $job->outstanding - $request->input('amount')]);
        } catch(\Exception $e)
        {
//            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage());
        }
//        DB::commit();
        return redirect()->back()->withSuccess('Success!');
    }
//
//    public function edit($id)
//    {
//        return view('appliance.payment.edit')->withData(Appliance_Deposit::find($id));
//    }

    public function update(Request $request, $id)
    {
        try {
            if (empty($request->input('amount')))
                Kitchen_Payment::find($id)->delete();
            else
                Kitchen_Payment::find($id)->update($request->input());
        } catch (\Exception $e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        return redirect()->back()->withSuccess('记录删除成功！');
    }
}
