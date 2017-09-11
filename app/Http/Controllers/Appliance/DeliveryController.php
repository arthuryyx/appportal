<?php

namespace App\Http\Controllers\Appliance;

use App\Appliance_Stock;
use App\Appliance_Delivery;
use App\Appliance_Dispatch;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    public function index($invoice){
        return view('appliance.invoice.job.deliver')
            ->withDeliveries(Appliance_Delivery::where('invoice_id', $invoice)->get())
            ->withRequests(Appliance_Dispatch::where('invoice_id', $invoice)->with('getSchedule')->get());
    }
    public function exportPackingSlip($delivery){
        $data = Appliance_Delivery::with('hasManyStocks')->with('getInvoice')->find($delivery);
        return view('appliance.pdf.slip')->withDelivery($data);
        $pdf = PDF::loadView('appliance.pdf.slip', [ 'delivery' => $data]);

        return $pdf->stream();
    }

    public function requestDelivery(Request $request, $invoice)
    {
        $this->validate($request, [
            'fee' => 'required|numeric|min:0',
        ]);

        $t = $request->all();
        if($t['date'] === ''){
            $t['date'] = null;
        }
        $t['state'] = array_has($t, 'post')?2:0;
        $t['created_by'] = Auth::user()->id;
        $t['invoice_id'] = $invoice;

        try {
            Appliance_Dispatch::create($t);
        } catch(\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }
        return redirect('appliance/invoice/job/'.$invoice)->withErrors('申请新建成功！');
    }

    public function editDispatch($id)
    {
        return view('appliance.delivery.edit')->withDispatch(Appliance_Dispatch::find($id));
    }

    public function updateDispatch(Request $request, $id)
    {
        $this->validate($request, [
            'fee' => 'required|numeric|min:0',
        ]);
        $d = Appliance_Dispatch::find($id);

        $t = $request->all();
        if($t['date'] === ''){
            $t['date'] = null;
        }
        if($d->state == 0 && isEmptyOrNullString($d->schedule_id)){
            $t['state'] = 1;
        }

        if ($d->update($t)) {
            return redirect('appliance/delivery/index/'.$d->invoice_id)->withErrors('更新成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

    public function dataConvert (){

        DB::beginTransaction();
        try {
            foreach (Appliance_Stock::where('aid', 546)->pluck('id')->all() as $id){
                $s = Appliance_Stock::find($id);

                $t['invoice_id'] = $s->assign_to;
                $t['fee'] = $s->price?$s->price:0;
                $t['created_by'] = $s->getAssignTo->created_by;
                $t['state'] = $s->state;
                Appliance_Dispatch::create($t);
            }
        } catch(\Exception $e)
        {
            DB::rollback();
            return dd($e->getMessage());
        }
        DB::commit();
        return dd('成功！');


    }
}
