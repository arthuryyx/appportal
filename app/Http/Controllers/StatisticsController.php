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
        $invoices = Appliance_Invoice::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->pluck('id');
        $aids = array_unique(
            Appliance_Stock::whereIn('assign_to', $invoices)
            ->select('aid', DB::raw('count(aid) as total'))
            ->groupBy('aid')
            ->orderBy('total', 'desc')
            ->take(10)->pluck('aid')->all());

        $sales = Appliance_Stock::whereIn('assign_to', $invoices)->whereIn('aid', $aids)
            ->select('aid', 'state', DB::raw('count(aid) as total'))->groupBy('aid', 'state')
            ->with('appliance')->get();

        $data = array();
        foreach ($aids as $aid){
            $ass = $sales->where('aid', $aid);
            $data [count($data)]['y']=$sales->where('aid', $aid)->first()->appliance->model;
            $data [count($data)-1]['a']=$ass->contains('state', 0)?$ass->where('state', 0)->first()->total:0;
            $data [count($data)-1]['b']=$ass->contains('state', 1)?$ass->where('state', 1)->first()->total:0;
            $data [count($data)-1]['c']=$ass->contains('state', 2)?$ass->where('state', 2)->first()->total:0;
            $data [count($data)-1]['d']=$ass->contains('state', 3)?$ass->where('state', 3)->first()->total:0;
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
            ->having('value', '>', 0)
            ->with('getCreated_by')->get();

        $data = array();
        foreach ($array as $invoice){
            $data [count($data)]['label']=$invoice->getCreated_by->name;
            $data [count($data)-1]['value']=floor($invoice->value);
        }
        return $data;
    }

    public function salesLine(){
        $invoices = Appliance_Invoice::whereDate('created_at', '>=', Carbon::today()->addDays(-30))->whereDate('created_at' , '<=', Carbon::today())
            ->select(DB::raw('sum(price) as price'),DB::raw('date(created_at) as date'))->groupBy('date')->get();

        $deposits = Appliance_Deposit::whereDate('created_at', '>=', Carbon::today()->addDays(-30))->whereDate('created_at' , '<=', Carbon::today())
            ->select(DB::raw('sum(amount) as amount'),DB::raw('date(created_at) as date'))->groupBy('date')->get();

        $data = array();
        $date = Carbon::today();
        for ($i = 0; $i<30; $i++){
            $dateString = $date->toDateString();
            $data [count($data)]['y'] = $dateString;
            $data [count($data)-1]['a'] = $invoices->contains('date', $dateString)?floor($invoices->where('date', $dateString)->first()->price):0;
            $data [count($data)-1]['b'] = $deposits->contains('date', $dateString)?floor($deposits->where('date', $dateString)->first()->amount):0;
            $date->subDay(1);
        }
        return $data;
    }

    public function applianceSalesTable(){
        $invoices = Appliance_Invoice::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->pluck('id');
        $data = Appliance_Stock::whereIn('assign_to', $invoices)
            ->groupBy('aid')
            ->select('aid', DB::raw('count(aid) as total'))->with('appliance.belongsToBrand')->get();
        return view('statistics.index')->withData($data);
    }

    public function personalBar(){
        $sales = Role::where('name', 'sales')->first()->users()->pluck('id');
        $date0 = Carbon::now()->subMonthsWithOverflow(3);
        $date1 = Carbon::now()->subMonthsWithOverflow(2);
        $date2 = Carbon::now()->subMonthsWithOverflow(1);

        $data = array();
        foreach ($sales as $uid){
            $data [count($data)]['y']=User::where('id', $uid)->select('name')->first()->name;
            $data [count($data)-1]['a']=floor(Appliance_Invoice::whereYear('created_at', $date0->year)->whereMonth('created_at', $date0->month)->where('created_by', $uid)->sum('price'));
            $data [count($data)-1]['b']=floor(Appliance_Invoice::whereYear('created_at', $date1->year)->whereMonth('created_at', $date1->month)->where('created_by', $uid)->sum('price'));
            $data [count($data)-1]['c']=floor(Appliance_Invoice::whereYear('created_at', $date2->year)->whereMonth('created_at', $date2->month)->where('created_by', $uid)->sum('price'));
        }
        return ['data'=>$data, 'date'=>[$date0->format('M Y'), $date1->format('M Y'), $date2->format('M Y')]];
    }
}
