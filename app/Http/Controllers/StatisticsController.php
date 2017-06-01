<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Appliance;
use App\Appliance_Stock;
use App\Appliance_Invoice;
use App\Appliance_Deposit;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function salesBar(){
        $array = Appliance_Stock::whereYear('updated_at', date('Y'))
            ->whereMonth('updated_at', date('m'))
            ->where(function ($query){
            $query->where('state', 2)
                ->whereNotNull('assign_to')
                ->orWhere('state', 3);
        })->groupBy('aid')
            ->select('aid', DB::raw('count(aid) as total'))
            ->orderBy('total', 'desc')
            ->take(10)
            ->pluck('aid');

        $year = date('Y');
        $month = date('m');
        $data = array();
        foreach ($array as $value){
            $data [count($data)]['y']=Appliance::where('id', $value)->select('model')->first()->model;
            $data [count($data)-1]['a']=Appliance_Stock::where('aid', $value)->whereYear('updated_at', $year)->whereMonth('updated_at', $month)->where('state', 2)->whereNotNull('assign_to')->count();
            $data [count($data)-1]['b']=Appliance_Stock::where('aid', $value)->whereYear('updated_at', $year)->whereMonth('updated_at', $month)->where('state', 3)->count();
        }
        return $data;
    }

    public function salesChart(){
        $sales = Role::where('name', 'sales')->first()->users()->pluck('id');
        $array = Appliance_Invoice::whereIn('created_by', $sales)
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->groupBy('created_by')
            ->select('created_by', DB::raw('sum(price) as value'))
            ->pluck('value', 'created_by');
        $data = array();
        foreach ($array as $key => $value){
            $data [count($data)]['label']=User::where('id', $key)->select('name')->first()->name;
            $data [count($data)-1]['value']=floor($value);
        }
        return $data;
    }

    public function salesLine(){
        $data = array();

        $date = Carbon::now();
        for ($i = 0; $i<30; $i++){
            $dateString = $date->toDateString();
            $data [count($data)]['y'] = $dateString;
            $data [count($data)-1]['a'] = floor(Appliance_Invoice::whereDate('created_at', $dateString)->where('type', 0)->sum('price'));
            $data [count($data)-1]['b'] = floor(Appliance_Deposit::whereDate('created_at', $dateString)->sum('amount'));
            $date->subDay(1);
        }
        return $data;
    }
}
