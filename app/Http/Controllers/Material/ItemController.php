<?php

namespace App\Http\Controllers\Material;

use App\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Material_Item;
use App\Material_Item_Type;
use App\Material_Attribute_Value;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    public function create($tid)
    {
        return view('material.item.create')->withType(Material_Item_Type::find($tid))->withSuppliers(Supplier::pluck('name', 'id'));
    }

    public function store(Request $request)
    {
        $this->processRequest($request);
        $this->validate($request, [
            'model' => 'unique:material__items,model,NULL,id,type_id,'.$request->input('type_id').',supplier_id,'.$request->input('supplier_id'),
            'supplier_id' => 'required',
            'type_id' => 'required',
            'price' => 'required|numeric|min:0',
            'id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $item = Material_Item::create($request->all());
            $item->values()->attach($request->input('id'));
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage());
        }
        DB::commit();
        return redirect('material/type/'.$request->input('type_id'))->withErrors('Success!');
    }

    public function edit($id)
    {
        return view('material.item.edit')->withItem(Material_Item::find($id))->withSuppliers(Supplier::pluck('name', 'id')->sortBy('name'));
    }

    public function update(Request $request, $id)
    {
        $this->processRequest($request);
        $this->validate($request, [
            'model' => 'unique:material__items,model,'.$id.',id,type_id,'.$request->input('type_id').',supplier_id,'.$request->input('supplier_id'),
            'supplier_id' => 'required',
            'type_id' => 'required',
            'price' => 'required|numeric|min:0',
            'id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $item = Material_Item::find($id);
            $item->update($request->all());
            $item->values()->sync($request->input('id'));
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withErrors($e);
        }
        DB::commit();
        return redirect('material/type/'.$request->input('type_id'))->withErrors('Success!');
    }

    private function processRequest(Request $request)
    {
        $model = trim($request->input('model'));
        $request->merge(['bak'=>$model]);
        $values = Material_Attribute_Value::whereIn('id', $request->input('id'))->pluck('value', 'attribute_id')->all();
        foreach (Material_Item_Type::find($request->input('type_id'))->attributes->pluck('id')->all() as $tid){
            $model=='' ? $model.=$values[$tid] : $model.='-'.$values[$tid];
        }
        $request->merge(['model'=>$model]);
    }
}
