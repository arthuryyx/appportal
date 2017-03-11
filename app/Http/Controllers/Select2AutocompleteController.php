<?php

namespace App\Http\Controllers;

use App\Appliance;
use App\Stock;
use Illuminate\Http\Request;

class Select2AutocompleteController extends Controller
{
    public function applianceModel(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = Appliance::where('model','LIKE',"%$search%")->select('id', 'model')->get();
        }
        return response()->json($data);
    }

    public function available(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = Stock::where(function ($query){
                $query->where('state', 1)
                    ->whereNull('assign_to')
                    ->orWhere('state', 2)
                    ->whereNull('assign_to');
            })->join('appliances', 'appliances.id', 'stocks.aid')
                ->where('appliances.model','LIKE',"%$search%")
                ->select('stocks.id', 'model', 'shelf')
                ->get();
        }
        return response()->json($data);
    }
}