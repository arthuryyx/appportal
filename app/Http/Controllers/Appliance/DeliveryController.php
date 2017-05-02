<?php

namespace App\Http\Controllers\Appliance;

use App\Appliance_Delivery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeliveryController extends Controller
{
    public function index($invoice){
        return view('appliance.invoice.job.delivery')
            ->withDeliveries(Appliance_Delivery::where('invoice_id', $invoice)->get());
    }
    public function exportPackingSlip($delivery){
        $data = Appliance_Delivery::with('hasManyStocks')->with('getInvoice')->find($delivery);
        return view('appliance.pdf.slip')->withDelivery($data);
        $pdf = PDF::loadView('appliance.pdf.slip', [ 'delivery' => $data]);

        return $pdf->stream();
    }
}
