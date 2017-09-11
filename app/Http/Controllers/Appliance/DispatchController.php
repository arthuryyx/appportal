<?php

namespace App\Http\Controllers\Appliance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Appliance_Dispatch;

class DispatchController extends Controller
{
    public function requestList(){
        if(Auth::user()->can('menu_shipping_schedule')){
            return view('appliance.delivery.requests')->withDispatches(Appliance_Dispatch::where('state', '<' ,2)->with('getInvoice', 'getSchedule', 'getCreated_by')->get());
        } else{
            return view('appliance.delivery.requests')->withDispatches(Appliance_Dispatch::where('state', '<' ,2)->with('getInvoice', 'getSchedule', 'getCreated_by')->where('created_by', Auth::user())->get());
        }
    }
}
