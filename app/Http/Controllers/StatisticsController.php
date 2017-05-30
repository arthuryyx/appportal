<?php

namespace App\Http\Controllers;

use App\Role;
use App\Appliance_Invoice;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
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
            $data [count($data)-1]['value']=sprintf("%.2f", $value);
        }
        return $data;
    }
}
