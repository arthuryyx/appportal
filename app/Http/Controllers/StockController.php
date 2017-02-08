<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appliance;
use App\Stock;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function list($state){
        switch ($state)
        {
            case 1:
                return view('tempstock.index'.$state)->withStocks(Stock::where('state', $state)->get());
                break;
            case 2:
                return view('tempstock.index'.$state)->withStocks(Stock::where('state', $state)->get());
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
            'receipt' => 'required',
        ]);
        $t = $request->all();
        if($t['job']){
            $t['init'] = $t['job'];
            $t['assign_to'] = $t['job'];
            $t['state'] = 2;
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
        return redirect()->back();
    }


    public function edit($id)
    {
        return view('tempstock.edit')->withStock(Stock::find($id))->withAppliances(Appliance::pluck('model', 'id'));
    }


    public function update(Request $request, $id)
    {

        $t = $request->all();

        if($t['job']){
            $t['assign_to'] = $t['job'];
            $t['state'] = 2;
        } else{
            $t['assign_to'] = null;
            $t['state'] = 1;
        }
        unset($t['aid']);
        unset($t['receipt']);

        foreach ($t as $k=>$v){
            if(is_string($v) && $v === '') $t[$k] = null;
        }


        if (Stock::find($id)->update($t)) {
            return redirect('tempstock/list/2');
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
            return redirect('tempstock/list/2');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

    public function destroy($id)
    {
        Stock::find($id)->delete();
        return redirect()->back()->withInput()->withErrors('删除成功！');
    }
}
