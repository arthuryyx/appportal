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
//    public function salesBar(){
//        $invoices = Appliance_Invoice::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->pluck('id');
//        $aids = array_unique(
//            Appliance_Stock::whereIn('assign_to', $invoices)
//            ->select('aid', DB::raw('count(aid) as total'))
//            ->groupBy('aid')
//            ->orderBy('total', 'desc')
//            ->take(10)->pluck('aid')->all());
//
//        $sales = Appliance_Stock::whereIn('assign_to', $invoices)->whereIn('aid', $aids)
//            ->select('aid', 'state', DB::raw('count(aid) as total'))->groupBy('aid', 'state')
//            ->with('appliance')->get();
//
//        $data = array();
//        foreach ($aids as $aid){
//            $ass = $sales->where('aid', $aid);
//            $data [count($data)]['y']=$sales->where('aid', $aid)->first()->appliance->model;
//            $data [count($data)-1]['a']=$ass->contains('state', 0)?$ass->where('state', 0)->first()->total:0;
//            $data [count($data)-1]['b']=$ass->contains('state', 1)?$ass->where('state', 1)->first()->total:0;
//            $data [count($data)-1]['c']=$ass->contains('state', 2)?$ass->where('state', 2)->first()->total:0;
//            $data [count($data)-1]['d']=$ass->contains('state', 3)?$ass->where('state', 3)->first()->total:0;
//        }
//        return $data;
//    }

    public function salesChart(){
//        $sales = Role::where('name', 'sales')->first()->users()->pluck('id');
        $data = array();
        for ($i=0; $i<4; $i++){
            $date = Carbon::today()->subMonthsWithOverflow($i);
            $temp = Appliance_Invoice::whereYear('created_at', $date->year)
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

    public function personalBar(){
        $sales = Role::where('name', 'sales')->first()->users()->pluck('id');
//        date('Y-m-01', strtotime('-3 month'))
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

//    public function salesLine(){
//        $invoices = Appliance_Invoice::whereDate('created_at', '>=', Carbon::today()->addDays(-30))->whereDate('created_at' , '<=', Carbon::today())
//            ->select(DB::raw('sum(price) as price'),DB::raw('date(created_at) as date'))->groupBy('date')->get();
//
//        $deposits = Appliance_Deposit::whereDate('created_at', '>=', Carbon::today()->addDays(-30))->whereDate('created_at' , '<=', Carbon::today())
//            ->select(DB::raw('sum(amount) as amount'),DB::raw('date(created_at) as date'))->groupBy('date')->get();
//
//        $data = array();
//        $date = Carbon::today();
//        for ($i = 0; $i<30; $i++){
//            $dateString = $date->toDateString();
//            $data [$i]['y'] = $dateString;
//            $data [$i]['a'] = $invoices->contains('date', $dateString)?floor($invoices->where('date', $dateString)->first()->price):0;
//            $data [$i]['b'] = $deposits->contains('date', $dateString)?floor($deposits->where('date', $dateString)->first()->amount):0;
//            $date->subDay(1);
//        }
//        return $data;
//    }

    public function salesArea(){
        $invoices = Appliance_Invoice::whereDate('created_at', '>=', Carbon::today()->addDays(-30))->whereDate('created_at' , '<=', Carbon::today())
            ->select(DB::raw('sum(price) as price'),DB::raw('date(created_at) as date'))->groupBy('date')->get();

        $deposits = DB::table('appliance__invoices')
            ->join('appliance__deposits', 'appliance__invoices.id', '=', 'appliance__deposits.invoice_id')
            ->select(DB::raw('sum(appliance__deposits.amount) as amount'), DB::raw('date(appliance__invoices.created_at) as date'))
            ->groupBy('date')
            ->whereDate('appliance__invoices.created_at', '>=', Carbon::today()->addDays(-30))
            ->get();

        $data = array();
        $date = Carbon::today();
        $m = 0;
        $n= 0;
        for ($i = 0; $i<30; $i++){
            $dateString = $date->toDateString();
            $data [$i]['y'] = $dateString;
            $data [$i]['a'] = $invoices->contains('date', $dateString)?floor($invoices->where('date', $dateString)->first()->price):0;
            $data [$i]['b'] = $deposits->contains('date', $dateString)?floor($deposits->where('date', $dateString)->first()->amount):0;
            $date->subDay(1);
            $m=$m+$data [$i]['a'];
            $n=$n+$data [$i]['b'];
        }
        $array = array();
        $array[0]['label'] = 'Paid';
        $array[0]['value'] = $n;
        $array[1]['label'] = 'Unpaid';
        $array[1]['value'] = $m-$n;

        return array('area'=>$data, 'payment'=>$array);
    }

    public function applianceSalesTable(Request $request){
        if ($request->getMethod()=='GET'){
            $invoices = [];
        }else{
            $invoices = Appliance_Invoice::whereBetween('created_at', [$request->input('StartDate'), $request->input('EndDate')])->pluck('id');
        }
        $data = Appliance_Stock::whereIn('assign_to', $invoices)
            ->groupBy('aid')
            ->select('aid', DB::raw('count(aid) as total'))->with('appliance.belongsToBrand')->get();
        return view('statistics.index')->withData($data)->withDate($request->input('StartDate').' to '.$request->input('EndDate'));
    }

    public function payment()
    {
        return view('statistics.payment')->withData(array_unique(Appliance_Invoice::whereDate('created_at', '>=', Carbon::today()->subMonthsWithOverflow(3)->startOfMonth())->pluck('created_by')->toArray()));
    }

    public function paymentChart($id)
    {
        $data = array();
        for ($i=0; $i<4; $i++){
            $date = Carbon::today()->subMonthsWithOverflow($i);
            $temp = Appliance_Invoice::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('created_by', $id)
                ->get();
            $array = array();
            if(count($temp)==0){
                $array [0]['label']='No Data';
                $array [0]['value']=0;
            }else{
                $m = $temp->sum('price');
                $n = Appliance_Deposit::whereIn('invoice_id', $temp->pluck('id'))->sum('amount');
                if (floor($n)>0)
                {
                    $array[count($array)]['label'] = 'Paid';
                    $array[count($array)-1]['value'] = floor($n);
                }
                if (floor($m-$n) >0)
                {
                    $array[count($array)]['label'] = 'Unpaid';
                    $array[count($array)-1]['value'] = floor($m-$n);
                }
            }
            array_push($data, $array);
        }
        $data['name'] = User::find($id)->name;
        return $data;
    }
}
