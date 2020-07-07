<?php

namespace App\Http\Controllers\Kitchen;

use App\Kitchen_Board_Arrive;
use App\Kitchen_Board_Order;
use App\Kitchen_Board_Order_Item;
use App\Kitchen_Board_Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class Kitchen_Board_Order_Controller extends Controller
{
    public function index()
    {
        return view('kitchen.board.order.index');
    }

    public function  ajaxIndex()
    {
        $objects = Kitchen_Board_Order::query()
            ->with('getCreated_by');

        return Datatables::of($objects)
            ->editColumn('created_by', function ($obj) {
                return $obj->getCreated_by->name;
            })->editColumn('created_at', function ($obj) {
                return $obj->created_at->format('Y-m-d');
           })->addColumn('view', function ($order) {
                return '<a href="'.url('kitchen/board/order/'.$order->id).'" class="btn btn-success" target="_blank">查看</a>';
            })
            ->make(true);
    }

    public function create()
    {
        return view('kitchen.board.order.create');
    }

    public function store(Request $request)
    {
        $request->merge(['created_by' => Auth::user()->id]);
        $this->validate($request, [
            'ref' => 'required|unique:kitchen__board__orders',
            'created_by' => 'required|exists:users,id',
        ]);

        $obj = Kitchen_Board_Order::create($request->input());
        if ($obj) {
            return redirect('kitchen/board/order/'.$obj->id)->withErrors('添加成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }

    public function show($id)
    {
        return view('kitchen.board.order.show')->withOrder(Kitchen_Board_Order::with('hasManyItem.getStock')->with('hasManyItem.hasManyArrive')->find($id));
    }

    public function itemStore(Request $request)
    {
        $this->validate($request, [
            'stock_id' => 'required|exists:kitchen__board__stocks,id',
            'order_id' => 'required|exists:kitchen__board__orders,id',
            'qty' => 'numeric|min:1',
        ]);
        $input = $request->input();
        $input['remain'] = $input['qty'];
        try {
            Kitchen_Board_Order_Item::create($input);
        } catch (\Exception $e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        return redirect()->back()->withSuccess('添加成功！');
    }

    public function arriving(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'qty' => 'required',
        ]);
        $by = Auth::user()->id;

        DB::beginTransaction();
        try {
            foreach ($request->input('id') as $id){
                if (!array_key_exists($id,$request->input('qty')))
                    continue;
                $qty = $request->input('qty')[$id];
                $item = Kitchen_Board_Order_Item::find($id);
                $item->update(['remain' => $item->remain - $qty]);
                $stock = Kitchen_Board_Stock::find($item->stock_id);
                $stock->update(['qty' => $stock->qty + $qty]);
                Kitchen_Board_Arrive::create(['order_item_id'=>$id, 'value'=> $qty, 'created_by'=>$by]);
            }
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e);
        }
        DB::commit();

        return redirect()->back()->withSuccess('更新成功！');
    }

    public function cancelItem($id)
    {
        $by = Auth::user()->id;

        DB::beginTransaction();
        try {
            $item = Kitchen_Board_Order_Item::find($id);
            $qty = $item->remain;
            $item->update(['remain' => 0]);
            Kitchen_Board_Arrive::create(['order_item_id'=>$id, 'value'=> -$qty, 'created_by'=>$by]);
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withErrors($e);
        }
        DB::commit();

        return redirect()->back()->withSuccess('更新成功！');
    }

    public function pending()
    {
        return view('kitchen.board.order.pending');
    }

    public function  ajaxPending()
    {
        $objects = Kitchen_Board_Order_Item::query()
            ->where('remain', '>', 0)
            ->with('getStock')
            ->with('getOrder')
            ->with('hasManyArrive');

        return Datatables::of($objects)
            ->addColumn('title', function ($obj) {
                return $obj->getStock->title . ', ' . $obj->getStock->size;
            })->addColumn('order', function ($obj) {
                return '<a href="'.url('kitchen/board/order/'.$obj->order_id).'" class="btn btn-success" target="_blank">'.$obj->getOrder->ref.'</a>';
            })->editColumn('job_no', function ($obj) {
                return $obj->job_no;
            })->editColumn('remain', function ($obj) {
                return $obj->remain;
            })->editColumn('created_at', function ($obj) {
                return $obj->created_at->format('Y-m-d');
            })->make(true);
    }
}
