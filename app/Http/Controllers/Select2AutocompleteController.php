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
            $data = Stock::join('appliances', 'appliances.id', 'stocks.aid')->where('appliances.model','LIKE',"%$search%")->where('stocks.state', 1)->select('stocks.id', 'model', 'shelf')->get();
        }
        return response()->json($data);
    }
}
