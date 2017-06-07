<?php

namespace App\Http\Controllers\Material;

use App\Material_Attribute_Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttributeTypeController extends Controller
{
    public function index()
    {
        return view('material.attribute.type.index')->withAttributes(Material_Attribute_Type::all());
    }

    public function create()
    {
        return view('material.attribute.type.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:material__attribute__types',
//            'unit' => 'required',
        ]);
        if (Material_Attribute_Type::create($request->all())) {
            return redirect('material/attribute')->withErrors('添加成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }

    public function edit($id)
    {
        return view('material.attribute.type.edit')->withAttribute(Material_Attribute_Type::find($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:material__attribute__types,name,'.$id,
//            'unit' => 'required',
        ]);

        if (Material_Attribute_Type::find($id)->update($request->all())) {
            return redirect('material/attribute/')->withErrors('更新成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

    public function show($id)
    {
        return view('material.attribute.type.show')->withAttribute(Material_Attribute_Type::with('hasManyValues')->find($id));
    }
}
