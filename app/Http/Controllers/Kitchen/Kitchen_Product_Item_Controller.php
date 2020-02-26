<?php

namespace App\Http\Controllers\Kitchen;

use App\Kitchen_Product_Item;
use App\Kitchen_Product_Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Kitchen_Product_Item_Controller extends Controller
{
    public function store(Request $request){
        $this->validate($request, [
            'template_id' => 'required',
            'quote_id' => 'required|exists:kitchen__job__quotes,id',
        ]);
        $template = Kitchen_Product_Template::find($request->input('template_id'));
        $template['template_id'] = $request->input('template_id');
        $template['quote_id'] = $request->input('quote_id');
        $template['price'] = $template['lv1'];

        DB::beginTransaction();
        try {
            Kitchen_Product_Item::create($template->toArray());
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e);
        }
        DB::commit();
        return redirect()->back()->withSuccess('添加成功！');
    }
//    public function edit($id)
//    {
//        return view('appliance.item.edit')->withItem(Appliance_Item::find($id));
//    }
//
//    public function update(Request $request, $id)
//    {
//        if(is_string($request->input('price')) && $request->input('price') === '')
//            $request->offsetSet('price', null);
//        if(is_string($request->input('warranty')) && $request->input('warranty') === '')
//            $request->offsetSet('warranty', null);
//
//        $item = Appliance_Item::find($id);
//        DB::beginTransaction();
//        try {
//            $item->update($request->input());
//        } catch (\Exception $e)
//        {
//            DB::rollback();
//            return redirect()->back()->withInput()->withErrors('更新失败！');
//        }
//        DB::commit();
//        return redirect('appliance/quote/'.$item->quote_id)->withSuccess('更新成功！');
//    }
}
