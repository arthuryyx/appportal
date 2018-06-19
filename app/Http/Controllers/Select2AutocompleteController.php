<?php

namespace App\Http\Controllers;

use App\Appliance;
use App\Appliance_Stock;
use App\Product_Model;
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

    public function activeModel(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = Appliance::where('model','LIKE',"%$search%")->where('state', 0)->select('id', 'model')->get();
        }
        return response()->json($data);
    }

    public function availableModel(Request $request)
    {
        if($request->has('q')){
            $search = $request->q;
            $id1 = Appliance::where('model','LIKE',"%$search%")->where('state', 0)->pluck('id');
            $id2 = Appliance_Stock::where('state', 2)->whereNull('assign_to')->whereIn('aid', Appliance::where('state', 1)->where('model','LIKE',"%$search%")->pluck('id'))->distinct()->pluck('aid');
            if($id2->count()){
                return Appliance::whereIn('id', array_collapse([$id1, $id2]))->select('id', 'model')->get();
            }
            return Appliance::whereIn('id', $id1)->select('id', 'model')->get();
        }
    }

    public function productModel(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = Product_Model::where('model','LIKE',"%$search%")->select('id', 'model')->get();
        }
        return response()->json($data);
    }

    public function unsigned(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = Appliance_Stock::where(function ($query){
                $query->where('state', 1)
                    ->whereNull('assign_to')
                    ->orWhere('state', 2)
                    ->whereNull('assign_to');
            })->join('appliances', 'appliances.id', 'appliance__stocks.aid')
                ->where('appliances.model','LIKE',"%$search%")
                ->select('appliance__stocks.id', 'model', 'shelf')
                ->get();
        }
        return response()->json($data);
    }

    public function available(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = Appliance_Stock::where(function ($query){
                $query->where('appliance__stocks.state', 2)
                    ->whereNull('assign_to');
            })->join('appliances', 'appliances.id', 'appliance__stocks.aid')
                ->where('appliances.model','LIKE',"%$search%")
                ->select('appliance__stocks.id', 'model', 'shelf')
                ->get();
        }
        return response()->json($data);
    }
}
