<?php

namespace App\Http\Controllers\Appliance;

use App\Appliance_Order;
use App\Appliance_Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Controller;

use App\Appliance;
use App\Appliance_Stock;
use App\Appliance_Invoice;
use App\Appliance_Delivery;

use Barryvdh\DomPDF\Facade as PDF;

class StockController extends Controller
{
    public function index(Request $request, $state){
        Session::flash('backUrl', $request->fullUrl());
        switch ($state)
        {
            case 0:
                return view('appliance.stock.index'.$state)
                    ->withStocks(Appliance_Stock::where('state', $state)->with('appliance.belongsToBrand')->with('appliance.belongsToCategory')->with('getAssignTo')->get());
                break;
            case 1:
                return view('appliance.stock.index'.$state)
                    ->withStocks(Appliance_Stock::where('state', $state)->with('appliance.belongsToBrand')->with('appliance.belongsToCategory')->with('getOrder.getInvoice')->get());
                break;
            case 2:
                return view('appliance.stock.index'.$state)
                    ->withStocks(Appliance_Stock::where(function ($query){
                        $query->where('state', 1)
                            ->whereNull('assign_to')
                            ->orWhere('state', 2)
                            ->whereNull('assign_to');
                    })->groupBy('aid')
                        ->select('aid', DB::raw('count(aid) as total'))->with('appliance.belongsToBrand')->with('appliance.belongsToCategory')->get())
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
                        })->with('belongsToBrand')->with('belongsToCategory')->get());
                break;
            case 3:
                return view('appliance.stock.index'.$state)
                    ->withStocks(Appliance_Stock::where('state', $state)->with('appliance.belongsToBrand')->with('appliance.belongsToCategory')->with('getDeliveryHistory.getInvoice')->get());
                break;
            case 4:
                return view('appliance.stock.index'.$state)
                    ->withStocks(Appliance_Stock::where('state', 2)->whereNotNull('assign_to')->get());
                break;
            case 5:
                return view('appliance.stock.index'.$state)
                    ->withStocks(Appliance_Stock::where('state', $state)->get());
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
            'order_id' => 'required|exists:appliance__orders,id',
            'qty' => 'required|integer|min:1',
        ]);
        $t = $request->all();
        $t['state'] = 0;
        DB::beginTransaction();
        try {
            for ($x=$t['qty']; $x>0; $x--) {
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

    public function listing(Request $request){
        Session::flash('backUrl', $request->fullUrl());
        return view('appliance.stock.listing')
            ->withStocks(Appliance_Stock::where('state', 2)->whereNull('shelf')->with('appliance.belongsToBrand')->with('appliance.belongsToCategory')->get());
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
        $t = $request->all();
        if(is_string($t['shelf']) && $t['shelf'] === '') $t['shelf'] = null;
        if (Appliance_Stock::find($id)->update($t)) {
            return redirect(Session::get('backUrl'))->withErrors('更新成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

    public function editPrice($id){
        return view('appliance.invoice.job.price')->withSid($id);
    }

    public function updatePrice(Request $request, $id){
        if(is_string($request->input('price')) && $request->input('price') === '')
            $request->offsetSet('price', null);
        if(is_string($request->input('warranty')) && $request->input('warranty') === '')
            $request->offsetSet('warranty', null);
	        $obj = Appliance_Stock::find($id);
        if ($obj->update($request->all())) {
            return redirect('appliance/invoice/job/'.$obj->assign_to)->withErrors('更新成功！');
        } else {
            return redirect('appliance/invoice/job/'.$obj->assign_to)->withErrors('更新失败！');
        }
    }

    public function allocation(Request $request){
        $this->validate($request, [
            'aid' => 'required',
            'assign_to' => 'required|exists:appliance__invoices,id',
            'price' => 'numeric',
            'warranty' => 'numeric',
        ]);

        if(is_string($request->input('price')) && $request->input('price') === '')
            $request->offsetUnset('price');
        if(is_string($request->input('warranty')) && $request->input('warranty') === '')
            $request->offsetUnset('warranty');

        $stock = Appliance_Stock::where('aid', $request->input('aid'))
            ->whereNull('assign_to')
            ->where('state', 2)
            ->lockForUpdate()
            ->first();

        if(!$stock)
            $stock = Appliance_Stock::where('aid', $request->input('aid'))
                ->whereNull('assign_to')
                ->where('state', 1)
                ->lockForUpdate()
                ->first();

        if($stock){
            if ($stock->update(['assign_to' => $request->input('assign_to'), 'price' => $request->input('price'), 'warranty' => $request->input('warranty')])) {
                return redirect('appliance/invoice/job/'.$request->input('assign_to'))->withErrors('更新成功！');
            } else {
                return redirect('appliance/invoice/job/'.$request->input('assign_to'))->withErrors('更新失败！');
            }
        }else{
            $request->merge(['state'=>0]);
            if (Appliance_Stock::create($request->all())) {
                return redirect('appliance/invoice/job/'.$request->input('assign_to'))->withErrors('更新成功！');
            } else {
                return redirect('appliance/invoice/job/'.$request->input('assign_to'))->withErrors('更新失败！');
            }
        }
    }

    public function reentry(Request $request){
        $this->validate($request, [
            'sid' => 'required|exists:appliance__stocks,id',
        ]);
        $request->merge(['shelf' => null, 'deliver_to' => null, 'state' => 2]);
        if (Appliance_Stock::find($request->all()['sid'])->update($request->all())) {
            return redirect()->back()->withErrors('更新成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

    public function display(Request $request){
        if (Session::has('backUrl')) {
            Session::keep('backUrl');
        }
        $this->validate($request, [
            'sid' => 'required',
            'shelf' => 'required',
        ]);
        if (Appliance_Stock::find($request->input('sid'))->update(['state' => 5, 'shelf' => $request->input('shelf')])) {
            return redirect()->back()->withErrors('更新成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

    public function placeOrder(Request $request, $invoice){
        $this->validate($request, [
            'id' => 'required',
        ]);

        if (Appliance_Stock::whereIn('id', $request->input('id'))->whereNull('order_id')->count() == 0){
            return redirect()->back()->withErrors('电器已在订单中！');
        }
        $m = '';

        DB::beginTransaction();
        try {
            $order = Appliance_Order::create(['ref'=>Appliance_Order::where('invoice_id', $invoice)->count()+1, 'invoice_id'=>$invoice, 'state'=>1, 'created_by'=>Auth::user()->id]);
            foreach ($request->input('id') as $id){
                $obj = Appliance_Stock::find($id);
                if($obj->state == 0 && $obj->assign_to == $invoice && $obj->order_id == null){
                    $obj->update(['order_id'=>$order->id, 'state' => 1]);
                }else{
                    $m = $m.$obj->appliance->model.' not updated.<br>';
                }
            }
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        DB::commit();

        if($m === ''){
            return redirect()->back()->withErrors('更新成功！');
        }else{
            return redirect()->back()->withErrors($m);
        }
    }

    public function switchStock(Request $request){
        $this->validate($request, [
            'id' => 'required',
        ]);

        $obj = Appliance_Stock::find($request->input('id')[0]);

        if($obj->state > 1) {
            return redirect()->back()->withInput()->withErrors('Not allow to switch!');
        }

        $arr = Appliance_Stock::where('aid', $obj->aid)
            ->where('appliance__stocks.state', 2)
            ->where('assign_to', '!=', $obj->assign_to)
            ->join('appliance__invoices', 'assign_to', '=', 'appliance__invoices.id')
            ->pluck('receipt_id', 'appliance__stocks.id')
            ->all();

//        $avi = Appliance_Stock::where('aid', $obj->aid)->where('state', 2)->whereNull('assign_to')->first();
//        if($avi){
//            $arr = array_add($arr, $avi->id, 'Stock');
//        }

        if(count($arr) == 0) {
            return redirect()->back()->withInput()->withErrors('No Appliance To Switch!');
        }
        return view('appliance.stock.switch')->withObj($obj)->withArr($arr);
    }

    public function exchange(Request $request) {
        $this->validate($request, [
            'id' => 'required',
            'target' => 'required',
        ]);

        $original = Appliance_Stock::where('id', $request->input('id'))->select('assign_to', 'warranty', 'price')->first()->getAttributes();

        DB::beginTransaction();
        try {
            Appliance_Stock::find($request->input('id'))->update(Appliance_Stock::where('id', $request->input('target'))->select('assign_to', 'warranty', 'price')->first()->getAttributes());
            Appliance_Stock::find($request->input('target'))->update($original);
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        DB::commit();
        return redirect('appliance/invoice/job/'.$original['assign_to'])->withErrors('更新成功！');

    }

    public function warehousing(Request $request){
        $this->validate($request, [
            'id' => 'required',
        ]);
        $t = $request->all();
        $m = '';
        $by = Auth::user()->id;

        DB::beginTransaction();
        try {
            foreach ($t['id'] as $id){
                $obj = Appliance_Stock::find($id);
                if($obj->state == 1){
                    $obj->update(['state' => 2]);
                    Appliance_Record::create(['sid'=>$id, 'type'=> 2, 'created_by'=>$by]);
                }else{
                    $m = $m.$obj->appliance->model.' not updated.<br>';
                }
            }
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e);
        }
        DB::commit();

        if($m === ''){
            return redirect()->back()->withErrors('更新成功！');
        }else{
            return redirect()->back()->withInput()->withErrors($m);
        }
    }

    public function release(Request $request){
        $this->validate($request, [
            'id' => 'required',
        ]);
        $t = $request->all();
        $m = '';
        foreach ($t['id'] as $id){
            $obj = Appliance_Stock::find($id);
            if($obj->state == 1 || $obj->state == 2){
                $obj->update(['assign_to' => null, 'price' => null, 'warranty' => null]);
            }else{
                $m = $m.$obj->appliance->model.' not updated.<br>';
            }
        }
        if($m === ''){
            return redirect()->back()->withErrors('更新成功！');
        }else{
            return redirect()->back()->withInput()->withErrors($m);
        }
    }

    public function delivery(Request $request, $invoice)
    {
        $this->validate($request, [
            'id' => 'required',
            'carrier' => 'required',
        ]);
        $t = $request->all();
        $stocks = Appliance_Stock::where('state', 2)->whereIn('id', $t['id'])->get();
        if($stocks->count()==0){
            return redirect()->back()->withErrors('出库失败！');
        }
        DB::beginTransaction();
        try {
            $dr = Appliance_Delivery::create(['invoice_id' => $invoice, 'carrier' => $t['carrier'], 'created_by' => Auth::user()->id]);
            foreach ($stocks as $stock){
                $stock->update(['state' => 3, 'deliver_to'=> $dr->id]);
            }
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withErrors($e);
        }
        DB::commit();
        return redirect('appliance/delivery/index/'.$invoice)->withErrors('出库成功！');
    }

    public function delete(Request $request){
        $this->validate($request, [
            'id' => 'required',
        ]);
        $m = '';
        $n = 0;
        DB::beginTransaction();
        try {
            foreach ($request->input('id') as $id){
                $obj = Appliance_Stock::find($id);
                if($obj->state < 2){
                    $obj->delete();
                    $n++;
                }else{
                    $m .= $obj->appliance->model.' not deleted.<br>';
                }
            }
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e);
        }
            DB::commit();
            if($m === ''){
                return redirect()->back()->withErrors('成功删除'.$n.'个');
            }else{
                return redirect()->back()->withInput()->withErrors('成功删除'.$n.'个<br>'.$m);
        }
    }

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
//        $data = Appliance_Stock::where('state', 2)->orderBy('shelf')->orderBy('aid')->with('appliance.belongsToBrand')->with('appliance.belongsToCategory')->with('getAssignTo')->get();
        $date = date('Y-m-d H:i:s');
        return view('appliance.pdf.checking_list')->withStocks(Appliance_Stock::where('state', 2)->groupBy('aid')->select('aid', DB::raw('count(aid) as total'))->with('appliance.belongsToBrand')->with('appliance.belongsToCategory')->get())->withDate($date);
//        $pdf = PDF::loadView('appliance.pdf.checking_list', [ 'stocks' => $data, 'date' => $date]);
//        return $pdf->stream();
    }


    public function invoiceHtml($id){
        return view('appliance.pdf.invoice')->withInvoice(Appliance_Invoice::find($id))
            ->withStocks(Appliance_Stock::where('assign_to', $id)->groupBy('aid', 'price', 'warranty')->select('aid', DB::raw('count(aid) as total'), DB::raw('sum(price) as price'), 'warranty')->get());
    }

//    public function exportAssigned(){
//        $data = Stock::where('state', 2)->orderBy('assign_to')->get();
//        $date = date('Y-m-d H:i:s');
//        $pdf = PDF::loadView('tempstock.pdfTemplate.checking_list', [ 'stocks' => $data, 'date' => $date]);
//
//        return $pdf->stream();
//    }
}
