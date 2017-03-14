<?php

namespace App\Http\Controllers\Appliance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Controller;
use App\Appliance_Stock;
use App\Appliance;

use Barryvdh\DomPDF\Facade as PDF;

class StockController extends Controller
{
    public function index(Request $request, $state){
        Session::flash('backUrl', $request->fullUrl());
        switch ($state)
        {
            case 1:
                return view('appliance.stock.index1')
                    ->withStocks(Appliance_Stock::where(function ($query){
                        $query->where('state', 1)
                            ->whereNull('assign_to')
                            ->orWhere('state', 2)
                            ->whereNull('assign_to');
                    })->groupBy('aid')
                        ->select('aid', DB::raw('count(aid) as total'))->get())
                    ->withAppliances(
                        Appliance::whereNotExists(function($query)
                        {
                            $query->select(DB::raw(1))
                                ->from('appliance__stocks')
                                ->whereRaw('appliances.id = appliance__stocks.aid')
                                ->where(function ($query){
                                $query->where('state', 1)
                                    ->whereNull('assign_to')
                                    ->orWhere('state', 2)
                                    ->whereNull('assign_to');
                            });
                        })->get());
                break;
            case 2:
                return view('tempstock.index'.$state)->withStocks(Stock::orderBy('updated_at', 'desc')->where('state', $state)->get());
                break;
            case 3:
                return view('tempstock.index'.$state)->withStocks(Stock::where('state', $state)->get());
                break;
            case 4:
                return view('tempstock.index'.$state)->withStocks(Stock::all());
                break;

            default:
                break;
        }
    }

////    public function create(){
////        return view('tempstock.create')->withAppliances(Appliance::orderBy('model')->pluck('model', 'id'));
////
////    }

    public function store(Request $request){
        $this->validate($request, [
            'aid' => 'required',
            'amount' => 'required|integer|min:0',
        ]);
        $t = $request->all();
        if(array_key_exists('job',$t)){
            $t['init'] = $t['job'];
            $t['assign_to'] = $t['job'];
            $t['state'] = 0;
        } elseif(array_key_exists('bulk',$t)){
            $t['init'] = $t['bulk'];
            $t['state'] = 1;
        }

        DB::beginTransaction();
        try {
            for ($x=$t['amount']; $x>0; $x--) {
                Appliance_Stock::create($t);
            }
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e);
        }
        DB::commit();
        return redirect()->back()->withErrors('添加成功！');
    }

    public function edit($id){
        if (Session::has('backUrl')) {
            Session::keep('backUrl');
        }
        return view('appliance.stock.edit')->withStock(Appliance_Stock::find($id));
    }

    public function update(Request $request, $id){
        if (Session::has('backUrl')) {
            Session::keep('backUrl');
        }

        if (Appliance_Stock::find($id)->update($request->all())) {
            return redirect(Session::get('backUrl'))->withErrors('更新成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

    public function assign(Request $request){
        $this->validate($request, [
            'assign_to' => 'required',
            'sid' => 'required',
        ]);
        $t = $request->all();
        if (Appliance_Stock::find($t['sid'])->update($t)) {
            return redirect()->back()->withErrors('更新成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }

    }
//
//    public function out($id)
//    {
//        $obj = Stock::find($id);
//
//        $t = [];
//        $t['deliver_to'] = $obj['assign_to'];
//        $t['state'] = 3;
//
//        if ($obj->update($t)) {
//            return redirect()->back()->withErrors('已出库');
//        } else {
//            return redirect()->back()->withInput()->withErrors('更新失败！');
//        }
//    }
//
//    public function destroy($id)
//    {
//        Stock::find($id)->delete();
//        return redirect()->back()->withInput()->withErrors('删除成功！');
//    }

    public function detail(Request $request, $aid){
        Session::flash('backUrl', $request->fullUrl());
        return view('appliance.stock.detail')->withStocks(Appliance_Stock::where('aid', $aid)->where(function ($query){
            $query->where('state', 1)
                ->whereNull('assign_to')
                ->orWhere('state', 2)
                ->whereNull('assign_to');
        })/*->orderBy('created_at', 'desc')*/->get());
    }

    public function exportAvailable(){
        $data = Appliance_Stock::where(function ($query){
            $query->where('state', 1)
                ->whereNull('assign_to')
                ->orWhere('state', 2)
                ->whereNull('assign_to');
        })
            ->groupBy('aid')
            ->select('aid', DB::raw('count(aid) as total'))
            ->join('appliances', 'appliances.id', '=', 'appliance__stocks.aid')
            ->orderBy('brand_id')
            ->orderBy('category_id')
            ->get();

        $date = date('Y-m-d H:i:s');
        $total= array_sum($data->pluck('total')->all());
//        return view('appliance.pdf.available')->withStocks($data)->withDate($date)->withTotal($total);
        $pdf = PDF::loadView('appliance.pdf.available', [ 'stocks' => $data, 'date' => $date, 'total' => $total]);

//        if($request->has('download')){
//            return $pdf->download('available_stocks.pdf');
//        }
        return $pdf->stream();
    }

    public function exportStockCheckingList(){
        $data = Appliance_Stock::where('state', 2)->orderBy('shelf')->orderBy('aid')->get();
        $date = date('Y-m-d H:i:s');
//        return view('appliance.pdf.checking_list')->withStocks($data)->withDate($date);
        $pdf = PDF::loadView('appliance.pdf.checking_list', [ 'stocks' => $data, 'date' => $date]);

        return $pdf->stream();
    }

//    public function exportAssigned(){
//        $data = Stock::where('state', 2)->orderBy('assign_to')->get();
//        $date = date('Y-m-d H:i:s');
//        $pdf = PDF::loadView('tempstock.pdfTemplate.checking_list', [ 'stocks' => $data, 'date' => $date]);
//
//        return $pdf->stream();
//    }
}
