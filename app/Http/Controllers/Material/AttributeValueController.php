<?php

namespace App\Http\Controllers\Material;

use App\Material_Attribute_Value;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttributeValueController extends Controller
{
    public function create($id)
    {
        return view('material.attribute.value.create')->withId($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'value' => 'required|unique:material__attribute__values,value,NULL,id,attribute_id,'.$request->input('attribute_id'),
            'attribute_id' => 'required|exists:material__attribute__types,id',
        ]);
        if (Material_Attribute_Value::create($request->all())) {
            return redirect('material/attribute/'.$request->input('attribute_id'))->withErrors('添加成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }

    public function edit($id)
    {
        return view('material.attribute.value.edit')->withValue(Material_Attribute_Value::find($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'value' => 'required|unique:material__attribute__values,value,'.$id.',id,attribute_id,'.$request->input('attribute_id'),
        ]);

        if (Material_Attribute_Value::find($id)->update($request->all())) {
            return redirect('material/attribute/'.$request->input('attribute_id'))->withErrors('更新成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }
}
