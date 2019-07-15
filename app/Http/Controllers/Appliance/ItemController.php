<?php

namespace App\Http\Controllers\Appliance;

use App\Appliance_Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function store(Request $request){
        $this->validate($request, [
            'aid' => 'required',
            'quote_id' => 'required|exists:appliance__quotes,id',
//            'qty' => 'required|integer|min:1',
        ]);
        DB::beginTransaction();
        try {
            Appliance_Item::create($request->input());
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e);
        }
        DB::commit();
        return redirect()->back()->withSuccess('添加成功！');
    }
    public function edit($id)
    {
        return view('appliance.item.edit')->withItem(Appliance_Item::find($id));
    }

    public function update(Request $request, $id)
    {
        if(is_string($request->input('price')) && $request->input('price') === '')
            $request->offsetSet('price', null);
        if(is_string($request->input('warranty')) && $request->input('warranty') === '')
            $request->offsetSet('warranty', null);

        $item = Appliance_Item::find($id);
        DB::beginTransaction();
        try {
            $item->update($request->input());
        } catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
        DB::commit();
        return redirect('appliance/quote/'.$item->quote_id)->withSuccess('更新成功！');
    }
}
