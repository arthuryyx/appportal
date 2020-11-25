<?php

namespace App\Http\Controllers\Appliance;

use App\Appliance_Record;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecordController extends Controller
{
    public function index(Request $request, $type){
//        Session::flash('backUrl', $request->fullUrl());
        switch ($type)
        {
            case 2:
                return view('appliance.record.index'.$type)
                    ->withRecords(Appliance_Record::where('type', $type)->with('getCreated_by', 'stock.appliance.belongsToBrand', 'stock.getOrder.getInvoice')->orderBy('id', 'desc')->paginate(25));
                break;
            default:
                break;
        }
    }
}
