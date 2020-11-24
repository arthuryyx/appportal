<?php

namespace App\Http\Controllers\Kitchen;

use App\Kitchen_Job;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function salesChart(){
//        $sales = Role::where('name', 'sales')->first()->users()->pluck('id');
        $data = array();
        for ($i=0; $i<4; $i++){
            $date = Carbon::today()->subMonthsWithOverflow($i);
            $temp = Kitchen_Job::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->groupBy('created_by')
                ->select('created_by', DB::raw('sum(price) as value'))
//            ->having('value', '>', 0)
                ->pluck('value', 'created_by');
            $array = array();
            if(count($temp)==0){
                $array [0]['label']='No Data';
                $array [0]['value']=0;
            }else{
                foreach ($temp as $key => $value){
                    $array [count($array)]['label']=User::find($key)->name;
                    $array [count($array)-1]['value']=floor($value);
                }
            }
            array_push($data, $array);
        }
        return $data;
    }
}
