<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Stock;
use App\Appliance;
use Illuminate\Support\Facades\Session;

use Barryvdh\DomPDF\Facade as PDF;

class StockController extends Controller
{
    public function list(Request $request, $state){
        Session::flash('backUrl', $request->fullUrl());
        switch ($state)
        {
            case 1:
                return view('tempstock.index'.$state)->withStocks(Stock::where('state', $state)->groupBy('aid')->select('aid', DB::raw('count(aid) as total'))->get())->withTotal(Stock::where('state', $state)->count());
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

    public function create(){
        return view('tempstock.create')->withAppliances(Appliance::orderBy('model')->pluck('model', 'id'));

    }

    public function store(Request $request){
        $this->validate($request, [
            'aid' => 'required',
//            'receipt' => 'required',
        ]);
        $t = $request->all();
        if($t['job']){
            $t['init'] = $t['job'];
            $t['assign_to'] = $t['job'];
            $t['state'] = 0;
        } else{
            $t['state'] = 1;
        }
        foreach ($t as $k=>$v){
            if(is_string($v) && $v === '') unset($t[$k]);
        }
        DB::beginTransaction();

        try {
            for ($x=$t['mount']; $x>0; $x--) {
                Stock::create($t);
            }
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e);
        }
        DB::commit();
        return redirect()->back()->withErrors('更新成功！');
    }


    public function edit($id)
    {
        if (Session::has('backUrl')) {
            Session::keep('backUrl');
        }
        return view('tempstock.edit')->withStock(Stock::find($id));
    }


    public function update(Request $request, $id)
    {
        if (Session::has('backUrl')) {
            Session::keep('backUrl');
        }

        $t = $request->all();

//        if($t['job']){
//            $t['assign_to'] = $t['job'];
//            $t['state'] = 2;
//        } else{
//            $t['assign_to'] = null;
//            $t['state'] = 1;
//        }
        unset($t['aid']);
        unset($t['receipt']);

        foreach ($t as $k=>$v){
            if(is_string($v) && $v === '') $t[$k] = null;
        }

        if (Stock::find($id)->update($t)) {
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
        $t['state'] = 2;
        if (Stock::find($t['sid'])->update($t)) {
            return redirect()->back()->withErrors('更新成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }

    }

    public function out($id)
    {
        $obj = Stock::find($id);

        $t = [];
        $t['deliver_to'] = $obj['assign_to'];
        $t['state'] = 3;

        if ($obj->update($t)) {
            return redirect()->back()->withErrors('已出库');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

    public function destroy($id)
    {
        Stock::find($id)->delete();
        return redirect()->back()->withInput()->withErrors('删除成功！');
    }

    public function detail(Request $request, $aid){
        Session::flash('backUrl', $request->fullUrl());
        return view('tempstock.detail')->withStocks(Stock::where(['aid'=> $aid, 'state'=> 1])->orderBy('created_at', 'desc')->get());
    }

    public function exportAvailable(){
        $data = Stock::where('state', 1)->groupBy('aid')->select('aid', DB::raw('count(aid) as total'))->leftJoin('appliances', 'appliances.id', '=', 'stocks.aid')->orderBy('brand_id')->orderBy('category_id')->get();
        $date = date('Y-m-d H:i:s');
        $total= array_sum($data -> pluck('total')->all());
        $pdf = PDF::loadView('tempstock.pdfTemplate.available', [ 'stocks' => $data, 'date' => $date, 'total' => $total]);

//        if($request->has('download')){
//            return $pdf->download('available_stocks.pdf');
//        }
        return $pdf->stream();
    }

    public function exportStockCheckingList(){
        $data = Stock::where('state', 1)->orWhere('state', 2)->orderBy('shelf')->orderBy('aid')->get();
        $date = date('Y-m-d H:i:s');
        $pdf = PDF::loadView('tempstock.pdfTemplate.checking_list', [ 'stocks' => $data, 'date' => $date]);

        return $pdf->stream();
    }

    public function exportAssigned(){
        $data = Stock::where('state', 2)->orderBy('assign_to')->get();
        $date = date('Y-m-d H:i:s');
        $pdf = PDF::loadView('tempstock.pdfTemplate.checking_list', [ 'stocks' => $data, 'date' => $date]);

        return $pdf->stream();
    }
}
