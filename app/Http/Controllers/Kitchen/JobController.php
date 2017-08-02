<?php

namespace App\Http\Controllers\Kitchen;

use App\Kitchen_Job;
use App\Kitchen_Quotation;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('kitchen_view_all_jobs')){
            return view('kitchen.job.index')->withJobs(Kitchen_Job::all());
        } else{
            return view('kitchen.job.index')->withJobs(Kitchen_Job::where('created_by', Auth::user()->id)->get());
        }
    }

    public function store(Request $request, $qid)
    {
        $request->merge(['quotation_id' => $qid]);

        $this->validate($request, [
            'quotation_id' => 'required|exists:kitchen__quotations,id',
        ]);

        $quotation = Kitchen_Quotation::find($qid);
        $total = $quotation->products->sum('price');

        DB::beginTransaction();
        try {
            $job_id = Kitchen_Job::create(['quotation_id'=>$qid, 'total'=>$total, 'created_by'=>Auth::user()->id])->id;
            $quotation->update(['state'=>3]);
            foreach ($quotation->products as $product) {
                $product->update(['job_id'=>$job_id]);
            }
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        DB::commit();

        return redirect('kitchen/job/'.$job_id)->withErrors('新建成功！');
    }

    public function show($id)
    {
        return view('kitchen.job.show')->withJob(Kitchen_Job::find($id));
    }

}
