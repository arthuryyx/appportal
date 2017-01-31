<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    public function index($type)
    {
        return view('admin.brand.index')->withBrands(Brand::where('type', $type)->get())->withType($type);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:brands',
            'type' => 'required',
        ]);

        if (Brand::create($request->all())) {
            return redirect()->back();
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }

    public function edit($id)
    {
        return view('admin/brand/edit')->withBrand(Brand::find($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:brands,name,'.$id,
            'type' => 'required',
        ]);

        if (Brand::find($id)->update($request->all())) {
            return redirect('admin/brand/'.$request->get('type'));
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }
    public function destroy($id)
    {
        Brand::find($id)->delete();
        return redirect()->back()->withInput()->withErrors('删除成功！');
    }
}
