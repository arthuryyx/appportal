<?php

namespace App\Http\Controllers\Material;

use App\Material_Item_Type;
use App\Material_Attribute_Type;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemTypeController extends Controller
{
    public function index()
    {
        return view('material.item.type.index')->withTypes(Material_Item_Type::all());
    }

    public function create()
    {
        return view('material.item.type.create')->withTypes(Material_Attribute_Type::pluck('name', 'id'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:material__item__types',
            'types' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $type = Material_Item_Type::create($request->all());
            $type->attributes()->attach($request->input('types'));
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        DB::commit();
        return redirect('material/type')->withErrors('Success!');
    }

    public function edit($id)
    {
        return view('material.item.type.edit')->withType(Material_Item_Type::find($id))->withTypes(Material_Attribute_Type::pluck('name', 'id'))->withSelected(Material_Item_Type::find($id)->attributes()->pluck('id')->all());
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:material__item__types,name,'.$id,
            'types' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $type = Material_Item_Type::find($id);
            $type->update($request->all());
            $type->attributes()->sync($request->input('types'));
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        DB::commit();
        return redirect('material/type')->withErrors('Success!');
    }

    public function show($id)
    {
        return view('material.item.index')->withType(Material_Item_Type::find($id));
    }
}
