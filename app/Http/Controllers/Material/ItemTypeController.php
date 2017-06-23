<?php

namespace App\Http\Controllers\Material;

use App\Material_Item_Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemTypeController extends Controller
{
    public function index()
    {
        return view('material.item.type.index')->withTypes(Material_Item_Type::all());
    }

    public function create()
    {
        return view('material.item.type.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:material__item__types',
        ]);
        if (Material_Item_Type::create($request->all())) {
            return redirect('material/type')->withErrors('添加成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }

    public function edit($id)
    {
        return view('material.item.type.edit')->withType(Material_Item_Type::find($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:material__item__types,name,'.$id,
        ]);

        if (Material_Item_Type::find($id)->update($request->all())) {
            return redirect('material/type/')->withErrors('更新成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }
}
