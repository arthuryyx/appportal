<?php

namespace App\Http\Controllers\Appliance;

use App\Appliance_Invoice;
use App\Appliance_Order;
use App\Appliance_Stock;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function index()
    {
        return view('appliance.order.index')->withOrders(Appliance_Order::with('getInvoice')->with('getCreated_by')->get());
    }

    public function create()
    {
        return view('appliance.order.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'ref' => 'required|unique:appliance__orders,ref,NULL,id,invoice_id,NULL',
        ]);

        $t = $request->all();
        $t['state'] = 0;
        $t['created_by'] = Auth::user()->id;

        if (Appliance_Order::create($t)) {
            return redirect('appliance/order')->withErrors('添加成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }

    public function edit($id)
    {
        return view('appliance.order.edit')->withOrder(Appliance_Order::find($id));
    }

    public function update(Request $request, $id)
    {
        $invoice = Appliance_Order::find($id);
        if(!$invoice->invoice_id){
            $this->validate($request, [
                'ref' => 'required|unique:appliance__orders,ref,'.$id.',id,invoice_id,NULL',
            ]);
        }
        if ($invoice->update($request->all())) {
            return redirect('appliance/order')->withErrors('更新成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

    public function show($id)
    {
        return view('appliance.order.show')->withOrder(Appliance_Order::with('getStocks.appliance.belongsToBrand')->with('getStocks.appliance.belongsToCategory')->with('getCreated_by')->find($id));
    }

    public function confirmOrder(Request $request){
        $this->validate($request, [
            'id' => 'required',
        ]);
        $m = '';

        DB::beginTransaction();
        try {
            $order = Appliance_Order::find($request->input('id'));
            foreach ($order->getStocks as $stock){
                if($stock->state == 0){
                    $stock->update(['state' => 1]);
                }else{
                    $m = $m.$stock->appliance->model.' not updated.<br>';
                }
            }
            $order->update(['state'=>1, 'created_by'=>Auth::user()->id]);
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

    public function mergeOrders(Request $request)
    {
        $this->validate($request, [
            'ref' => 'required|unique:appliance__orders,ref,NULL,id,invoice_id,NULL',
            'id' => 'required',
        ]);

        $t = $request->all();
        $t['state'] = 0;
        $t['created_by'] = Auth::user()->id;

        DB::beginTransaction();
        try {
            $order = Appliance_Order::create($t);
            foreach (Appliance_Stock::whereIn('id', $t['id'])->get() as $stock){
                $stock->update(['order_id'=>$order->id]);
            }
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        DB::commit();
        return redirect('appliance/order/'.$order->id)->withErrors('订单合并成功！');
    }

    public function jobOrders($id){
        return view('appliance.order.index')->withOrders(Appliance_Invoice::find($id)->getOrders);

    }

}
