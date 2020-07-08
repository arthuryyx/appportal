<?php

namespace App\Http\Controllers\Kitchen;

use App\Kitchen_Board_Arrive;
use App\Kitchen_Board_Stock;
use App\Kitchen_Board_Usage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class Kitchen_Board_Stock_Controller extends Controller
{
    public function index()
    {
        return view('kitchen.board.stock.index');
    }

    public function  ajaxIndex()
    {
        $objects = Kitchen_Board_Stock::query();

        return Datatables::of($objects)
            ->addColumn('edit', function ($order) {
                return '<a href="'.url('kitchen/board/stock/'.$order->id.'/edit').'" class="btn btn-success" >查看</a>';
            })
            ->make(true);
    }

    public function create()
    {
        return view('kitchen.board.stock.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:kitchen__board__stocks,title,NULL,id,brand,'.$request->input('brand'),
            'brand' => 'required',
            'size' => 'required',
            'qty' => 'numeric|min:0',
        ]);

        try {
            Kitchen_Board_Stock::create($request->input());
        } catch (\Exception $e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        return redirect()->back()->withSuccess('添加成功！');
    }

    public function edit($id)
    {
        return view('kitchen.board.stock.edit')->withStock(Kitchen_Board_Stock::find($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'brand' => 'required',
            'title' => 'required|unique:kitchen__board__stocks,title,'.$id.',id,brand,'.$request->input('brand_id'),
            'size' => 'required',
            'qty' => 'numeric|min:0',
        ]);

        try{
            Kitchen_Board_Stock::find($id)->update($request->input());
        } catch (QueryException $e)
        {
            return redirect()->back()->withInput()->withErrors('修改失败！');
        }
        return redirect('kitchen/board/stock')->withSuccess('修改成功！');
    }

    public function getIdByName(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = Kitchen_Board_Stock::where('kitchen__board__stocks.title', 'LIKE',"%$search%")
                ->select('id', 'brand', 'title', 'size')
                ->get();
        }
        return response()->json($data);
    }

    public function arrived()
    {
        return view('kitchen.board.stock.arrived');
    }

    public function  ajaxArrived()
    {
        $objects = Kitchen_Board_Arrive::query()
            ->with('getItem.getStock')
            ->with('getItem.getOrder')
            ->with('getCreated_by')
        ;

        return Datatables::of($objects)
            ->addColumn('order', function ($obj) {
                return '<a href="'.url('kitchen/board/order/'.$obj->getItem->order_id).'" class="btn btn-success" target="_blank">查看</a>';
            }) ->addColumn('brand', function ($obj) {
                return $obj->getItem->getStock->brand;
            })->addColumn('title', function ($obj) {
                return $obj->getItem->getStock->title . ', ' . $obj->getItem->getStock->size;
            }) ->editColumn('created_by', function ($obj) {
                return $obj->getCreated_by->name;
            })->editColumn('created_at', function ($obj) {
                return $obj->created_at->format('Y-m-d');
            })
            ->make(true);
    }

    public function usage()
    {
        return view('kitchen.board.stock.usage');
    }

    public function  ajaxUsage()
    {
        $objects = Kitchen_Board_Usage::query()
            ->with('getStock')
            ->with('getCreated_by')
        ;

        return Datatables::of($objects)
            ->addColumn('brand', function ($obj) {
                return $obj->getStock->brand;
            })->addColumn('title', function ($obj) {
                return $obj->getStock->title . ', ' . $obj->getStock->size;
            }) ->editColumn('created_by', function ($obj) {
                return $obj->getCreated_by->name;
            })->editColumn('created_at', function ($obj) {
                return $obj->created_at->format('Y-m-d');
            })
            ->make(true);
    }

    public function uses(Request $request)
    {
        $this->validate($request, [
            'stock_id' => 'required|exists:kitchen__board__stocks,id',
            'qty' => 'required|min:1',
        ]);
        $by = Auth::user()->id;
        DB::beginTransaction();
        try {
            $stock = Kitchen_Board_Stock::find($request->input('stock_id'));
            if ($stock->qty< $request->input('qty'))
                throw new \Exception('库存不足，操作失败！');
            $stock->update(['qty' => $stock->qty - $request->input('qty')]);
            Kitchen_Board_Usage::create([
                'stock_id'=>$request->input('stock_id'),
                'job_no'=> $request->input('job_no'),
                'qty'=>$request->input('qty'),
                'created_by'=>$by]);
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        DB::commit();
        return redirect()->back()->withSuccess('更新成功！');
    }
}
