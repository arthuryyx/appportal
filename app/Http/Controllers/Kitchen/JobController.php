<?php

namespace App\Http\Controllers\Kitchen;

use App\Kitchen_Job;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;

class JobController extends Controller
{
    public function index()
    {
        return view('kitchen.job.index');
    }

    public function  ajaxIndex()
    {
        if(Auth::user()->can('root')){
            $jobs = Kitchen_Job::query()
                ->with('getCreated_by')
                ->with('getPayments');
        } else{
            $jobs = Kitchen_Job::query()
                ->where('created_by', Auth::user()->id)
                ->with('getCreated_by')
                ->with('getPayments');

        }
        return Datatables::of($jobs)
            ->editColumn('created_by', function ($job) {
                return $job->getCreated_by->name;
            })->editColumn('created_at', function ($job) {
                return $job->created_at->format('Y-m-d');
            })->addColumn('status', function ($job) {
                $str = '';
//                if($inv->price != 0)
//                    $str = '<label class="label label-info">&nbsp;&nbsp;'.round((1-$inv->hasManyStocks->sum('appliance.lv4')/$inv->price)*100, 2).'%&nbsp;&nbsp;</label>';
                if($job->price == 0)
                    $str = $str.'<label class="label label-warning">&nbsp;&nbsp;&nbsp;$'.$job->getPayments->sum('amount').'&nbsp;&nbsp;&nbsp;</label>';
                elseif($job->getPayments->sum('amount')==$job->price)
                    $str= $str.'<label class="label label-success">&nbsp;&nbsp;&nbsp;Paid&nbsp;&nbsp;&nbsp;</label>';
                elseif($job->getPayments->count() == 0)
                    $str = $str.'<label class="label label-danger">&nbsp;Unpaid&nbsp;</label>';
                else
                    $str = $str.'<label class="label label-warning">&nbsp;&nbsp;&nbsp;&nbsp;'.round(($job->getPayments->sum('amount')/$job->price)*100).'%&nbsp;&nbsp;&nbsp;&nbsp;</label>';
//                if($inv->hasManyStocks->count() == 0)
//                    $str = $str.'<label class="label label-warning">&nbsp;&nbsp;Empty&nbsp;&nbsp;</label>';
//                elseif($inv->getState->count() == 0)
//                    $str = $str.'<label class="label label-success">Delivered</label>';
//                elseif($inv->getState->count() > 0)
//                    $str = $str.'<label class="label label-danger">&nbsp;&nbsp;&nbsp;Hold&nbsp;&nbsp;&nbsp;</label>';
//                else
//                    $str = $str.'<label class="label label-primary">Exception</label>';
                return $str;
            })->addColumn('action', function ($job) {
                return '<a href="'.url('kitchen/job/'.$job->id).'" class="btn btn-success" target="_blank">查看</a>';
            })
            ->make(true);
    }

    public function create()
    {
        return view('kitchen.job.create')->with('users', User::where('active', 1)->pluck('name', 'id'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'job' => Kitchen_Job::count()==0? 'K1001':'K'.(substr(Kitchen_Job::latest()->first()->job, 1) + 1),
            'created_by' => $request->input('created_by')? :Auth::user()->id]);
        $this->validate($request, [
            'job' => 'required|unique:kitchen__jobs',
            'customer_name' => 'required',
            'phone' => 'numeric',
            'email' => 'email',
            'created_by' => 'required|exists:users,id'
        ]);
        foreach ($request->input() as $k=>$v) {
            if (!empty($v)) $t[$k] = $v;
        }
        try {
            $obj = Kitchen_Job::create($t);
//            $t['job_id'] = $obj->id;
//            Appliance_Job_Remark::create($t);
        } catch(\Exception $e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        return redirect('kitchen/job/'.$obj->id)->withSuccess('添加成功！');
    }

    public function edit($id)
    {
        return view('kitchen.job.edit')->withJob(Kitchen_Job::find($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
//            'receipt_id' => 'required|unique:appliance__invoices,receipt_id,'.$id,
//            'price' => 'required|numeric|min:0',
            'customer_name' => 'required',
            'phone' => 'numeric',
            'email' => 'email',
//            'address' => 'required',
        ]);
        try {
            Kitchen_Job::find($id)->update($request->input());
        } catch(\Exception $e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        return redirect('kitchen/job/'.$id)->withSuccess('更新成功！');
    }

    public function show($id)
    {
        return view('kitchen.job.show')
//            ->withRegion(Auth::user()->sites()->pluck('name', 'id'))
            ->withJob(Kitchen_Job::with('getPayments.getCreated_by')
                ->with('getRemarks.getCreated_by')
                ->find($id));
    }
}
