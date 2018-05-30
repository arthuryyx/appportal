<?php

namespace App\Http\Controllers\Admin;

use App\Appliance;
use App\Brand;
use App\Category;
use App\Stock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApplianceController extends Controller
{
    public function index()
    {
        return view('admin.appliance.index')->withAppliances(Appliance::with('belongsToBrand')->with('belongsToCategory')->get());
    }

    public function create()
    {
        return view('admin.appliance.create')->withBrands(Brand::orderBy('name')->pluck('name', 'id'))->withCategories(Category::orderBy('name')->pluck('name', 'id'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|unique:appliances,model,NULL,id,brand_id,'.$request->input('brand_id'),
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'rrp' => 'numeric|min:0',
        ]);

        $t = $request->all();
        $t['state'] = 0;
        foreach ($t as $k=>$v){
            if(is_string($v) && $v === '') unset($t[$k]);
        }

        try {
            Appliance::create($t);
        } catch (\Exception $e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        return redirect()->back()->withSuccess('添加成功！');
    }

    public function edit($id)
    {
        return view('admin/appliance/edit')->withModel(Appliance::find($id))->withBrands(Brand::orderBy('name')->pluck('name', 'id'))->withCategories(Category::orderBy('name')->pluck('name', 'id'));
    }

    public function update(Request $request, $id)
    {
        $t = $request->all();

        if(is_null($request->input('state'))) {
            $this->validate($request, [
                'model' => 'required|unique:appliances,model,'.$id.',id,brand_id,'.$request->input('brand_id'),
                'brand_id' => 'required|exists:brands,id',
                'category_id' => 'required|exists:categories,id',
                'rrp' => 'numeric|min:0',
            ]);

            foreach ($t as $k=>$v){
                if(is_string($v) && $v === '') $t[$k] = null;
            }
            $t['state'] = 0;
        } else {
            $t['state'] = 1;
        }

        try {
            Appliance::find($id)->update($t);
        } catch (\Exception $e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        return redirect()->back()->withSuccess('添加成功！');
        }

    public function destroy($id)
    {
        if(Stock::where('aid', $id)->count()==0){
            Appliance::find($id)->delete();
            return redirect()->back()->withInput()->withErrors('删除成功！');
        } else{
            return redirect()->back()->withInput()->withErrors('有关联关系，删除失败！');
        }
    }
    
    public function barcode(Request $request)
    {
        $this->validate($request, [
            'aid' => 'required|exists:appliances,id',
            'barcode' => 'required|unique:appliances,barcode,'.$request->input('aid'),
        ]);

        try {
            Appliance::find($request->input('aid'))->update(['barcode' => $request->input('barcode')]);
        } catch (\Exception $e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        return redirect()->back()->withSuccess('更新成功！');
    }
    
}
