<?php

namespace App\Http\Controllers\Appliance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Appliance_Invoice;
use Yajra\Datatables\Datatables;

class JobController extends Controller
{
    public function index()
    {
        return view('appliance.invoice.job.index');
    }

    public function  ajaxIndex()
    {
        if(Auth::user()->can('appliance_view_all_jobs')){
            $invs = Appliance_Invoice::query()
                ->with('hasManyStocks.appliance')
                ->with('getCreated_by')
                ->with('hasManyDeposits')
                ->with('getState');
//                ->orderBy('id', 'desc');
        } else{
            $invs = Appliance_Invoice::query()
                ->where('created_by', Auth::user()->id)
                ->with('hasManyStocks.appliance')
                ->with('getCreated_by')
                ->with('hasManyDeposits')
                ->with('getState')
                ->orderBy('id', 'desc');

        }

        return Datatables::of($invs)
            ->editColumn('created_by', function ($inv) {
                return $inv->getCreated_by->name;
            })->editColumn('created_at', function ($inv) {
                return $inv->created_at->format('Y-m-d');
            })->addColumn('status', function ($inv) {
                $str = '';
                if($inv->price != 0)
                    $str = '<label class="label label-info">&nbsp;&nbsp;'.round((1-$inv->hasManyStocks->sum('appliance.lv4')/$inv->price)*100, 2).'%&nbsp;&nbsp;</label>';
                if($inv->price == 0)
                    $str = $str.'<label class="label label-warning">&nbsp;&nbsp;&nbsp;$'.$inv->hasManyDeposits->sum('amount').'&nbsp;&nbsp;&nbsp;</label>';
                elseif($inv->hasManyDeposits->sum('amount')==$inv->price)
                    $str= $str.'<label class="label label-success">&nbsp;&nbsp;&nbsp;Paid&nbsp;&nbsp;&nbsp;</label>';
                elseif($inv->hasManyDeposits->count() == 0)
                    $str = $str.'<label class="label label-danger">&nbsp;Unpaid&nbsp;</label>';
                else
                    $str = $str.'<label class="label label-warning">&nbsp;&nbsp;&nbsp;&nbsp;'.round(($inv->hasManyDeposits->sum('amount')/$inv->price)*100).'%&nbsp;&nbsp;&nbsp;&nbsp;</label>';
                if($inv->hasManyStocks->count() == 0)
                    $str = $str.'<label class="label label-warning">&nbsp;&nbsp;Empty&nbsp;&nbsp;</label>';
                elseif($inv->getState->count() == 0)
                    $str = $str.'<label class="label label-success">Delivered</label>';
                elseif($inv->getState->count() > 0)
                    $str = $str.'<label class="label label-danger">&nbsp;&nbsp;&nbsp;Hold&nbsp;&nbsp;&nbsp;</label>';
                else
                    $str = $str.'<label class="label label-primary">Exception</label>';
                return $str;
            })->addColumn('action', function ($inv) {
                return '<a href="'.url('appliance/invoice/job/'.$inv->id).'" class="btn btn-success" target="_blank">详情</a>';
            })
            ->make(true);
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
        return view('appliance.invoice.job.show')->withInvoice(Appliance_Invoice::with('hasManyStocks.appliance.belongsToBrand')
            ->with('hasManyStocks.appliance.belongsToCategory')
            ->with('hasManyDeposits')
            ->find($id));
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

    public function unpaidList(Request $request, $uid)
    {
        return view('appliance.invoice.job.indexall')
            ->withInvoices(Appliance_Invoice::whereBetween('created_at', [$request->input('start'), $request->input('end')])
            ->where('created_by', $uid)
            ->with('hasManyStocks')
            ->with('getCreated_by')
            ->with('hasManyDeposits')
            ->with('getState')
            ->orderBy('id', 'desc')
            ->get());
    }
}
