<?php

namespace App\Http\Controllers\Appliance;

use App\Appliance;
use App\Appliance_Stock;
use App\Appliance_Invoice;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AirConController extends Controller
{
    public function  airConIndex()
    {
        $model = Appliance::where('category_id', 36)->pluck('id');
        $aircon = Appliance_Stock::whereIn('aid', $model)->groupBy('assign_to')->pluck('assign_to');

        if (Auth::user()->can('appliance_view_all_jobs')) {
            $invs = Appliance_Invoice::query()
                ->whereIn('id', $aircon)
                ->with('hasManyStocks.appliance')
                ->with('getCreated_by')
                ->with('hasManyDeposits')
                ->with('getState');
//                ->orderBy('id', 'desc');
        } else {
            $invs = Appliance_Invoice::query()
                ->whereIn('id', $aircon)
                ->where('created_by', Auth::user()->id)
                ->with('hasManyStocks.appliance')
                ->with('getCreated_by')
                ->with('hasManyDeposits')
                ->with('getState')
                ->orderBy('id', 'desc');

        }

        return Datatables::of($invs)
            ->editColumn('created_by', function ($inv) {
                return $inv->getCreated_by->name;
            })->editColumn('created_at', function ($inv) {
                return $inv->created_at->format('Y-m-d');
            })->addColumn('status', function ($inv) {
                $str = '';
                if ($inv->price != 0)
                    $str = '<label class="label label-info">&nbsp;&nbsp;' . round((1 - $inv->hasManyStocks->sum('appliance.lv4') / $inv->price) * 100, 2) . '%&nbsp;&nbsp;</label>';
                if ($inv->price == 0)
                    $str = $str . '<label class="label label-warning">&nbsp;&nbsp;&nbsp;$' . $inv->hasManyDeposits->sum('amount') . '&nbsp;&nbsp;&nbsp;</label>';
                elseif ($inv->hasManyDeposits->sum('amount') == $inv->price)
                    $str = $str . '<label class="label label-success">&nbsp;&nbsp;&nbsp;Paid&nbsp;&nbsp;&nbsp;</label>';
                elseif ($inv->hasManyDeposits->count() == 0)
                    $str = $str . '<label class="label label-danger">&nbsp;Unpaid&nbsp;</label>';
                else
                    $str = $str . '<label class="label label-warning">&nbsp;&nbsp;&nbsp;&nbsp;' . round(($inv->hasManyDeposits->sum('amount') / $inv->price) * 100) . '%&nbsp;&nbsp;&nbsp;&nbsp;</label>';
                if ($inv->hasManyStocks->count() == 0)
                    $str = $str . '<label class="label label-warning">&nbsp;&nbsp;Empty&nbsp;&nbsp;</label>';
                elseif ($inv->getState->count() == 0)
                    $str = $str . '<label class="label label-success">Delivered</label>';
                elseif ($inv->getState->count() > 0)
                    $str = $str . '<label class="label label-danger">&nbsp;&nbsp;&nbsp;Hold&nbsp;&nbsp;&nbsp;</label>';
                else
                    $str = $str . '<label class="label label-primary">Exception</label>';
                return $str;
            })->addColumn('action', function ($inv) {
                return '<a href="' . url('appliance/invoice/job/' . $inv->id) . '" class="btn btn-success" target="_blank">详情</a>';
            })
            ->make(true);
    }
}
