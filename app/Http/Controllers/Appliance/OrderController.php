<?php

namespace App\Http\Controllers\Appliance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Appliance_Invoice;

class OrderController extends Controller
{
    public function  index($invoice){
        return view('appliance.order.index')
            ->withInvoice(Appliance_Invoice::with('hasManyInits')->find($invoice));
    }
}
