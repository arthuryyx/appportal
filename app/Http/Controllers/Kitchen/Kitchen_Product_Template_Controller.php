<?php

namespace App\Http\Controllers\Kitchen;

use App\Kitchen_Product_Brand;
use App\Kitchen_Product_Category;
use App\Kitchen_Product_Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Kitchen_Product_Template_Controller extends Controller
{
    public function index()
    {
        return view('kitchen.product.template.index')->withTable(Kitchen_Product_Template::all());
    }

    public function create()
    {
        return view('kitchen.product.template.create')->withBrands(Kitchen_Product_Brand::orderBy('name')->pluck('name', 'name'))->withCategories(Kitchen_Product_Category::orderBy('name')->pluck('name', 'name'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|unique:kitchen__product__templates',
            'brand' => 'required',
            'category' => 'required',
            'l1' => 'numeric|min:0',
            'l2' => 'numeric|min:0',
            'l3' => 'numeric|min:0',
            'l4' => 'numeric|min:0',
        ]);

        $t = $request->input();
        $t['status'] = 1;
        foreach ($t as $k=>$v){
            if(is_string($v) && $v === '') unset($t[$k]);
        }

        try {
            Kitchen_Product_Template::create($t);
        } catch (\Exception $e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        return redirect()->back()->withSuccess('添加成功！');
    }

    public function edit($id)
    {
        return view('kitchen/product/template/edit')->withTemplate(Kitchen_Product_Template::find($id))->withBrands(Kitchen_Product_Brand::orderBy('name')->pluck('name', 'name'))->withCategories(Kitchen_Product_Category::orderBy('name')->pluck('name', 'name'));
    }

    public function update(Request $request, $id)
    {
        $t = $request->input();

        if(is_null($request->input('status'))) {
            $t['status'] = 0;
        } else {
            $this->validate($request, [
                'model' => 'required|unique:kitchen__product__templates,model,'.$id,
                'brand' => 'required',
                'category' => 'required',
                'lv1' => 'numeric|min:0',
                'lv2' => 'numeric|min:0',
                'lv3' => 'numeric|min:0',
                'lv4' => 'numeric|min:0',
            ]);

            foreach ($t as $k=>$v){
                if(is_string($v) && $v === '') $t[$k] = null;
            }
            $t['status'] = 1;
        }

        try {
            Kitchen_Product_Template::find($id)->update($t);
        } catch (\Exception $e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        return redirect()->back()->withSuccess('添加成功！');
    }

//    public function destroy($id)
//    {
//        if(Appliance_Stock::where('aid', $id)->count()==0){
//            Appliance::find($id)->delete();
//            return redirect()->back()->withInput()->withErrors('删除成功！');
//        } else{
//            return redirect()->back()->withInput()->withErrors('有关联关系，删除失败！');
//        }
//    }
}
