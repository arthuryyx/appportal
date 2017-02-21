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
        return view('admin.appliance.index')->withAppliances(Appliance::all());
    }

    public function create()
    {
        return view('admin.appliance.create')->withBrands(Brand::pluck('name', 'id'))->withCategories(Category::pluck('name', 'id'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|unique:appliances',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'best' => 'integer|min:1',
        ]);

        $t = $request->all();
        foreach ($t as $k=>$v){
            if(is_string($v) && $v === '') unset($t[$k]);
        }

        if (Appliance::create($t)) {
            return redirect('admin/appliance');
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }

    public function edit($id)
    {
        return view('admin/appliance/edit')->withAppliance(Appliance::find($id))->withBrands(Brand::pluck('name', 'id'))->withCategories(Category::pluck('name', 'id'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'model' => 'required|unique:appliances,model,'.$id,
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'best' => 'integer|min:0',
        ]);


        $t = $request->all();
        foreach ($t as $k=>$v){
            if(is_string($v) && $v === '') $t[$k] = null;
        }


        if (Appliance::find($id)->update($t)) {
            return redirect('admin/appliance')->withErrors('更新成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
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
}
