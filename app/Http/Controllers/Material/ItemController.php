<?php

namespace App\Http\Controllers\Material;

use App\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Material_Attribute_Type;
use App\Material_Attribute_Value;
use App\Material_Item;
use App\Material_Item_Type;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    public function create($tid)
    {
        return view('material.item.create')->withType(Material_Item_Type::find($tid))->withSuppliers(Supplier::pluck('name', 'id'));
    }

    public function store(Request $request)
    {
        $model = $request->input('model');
        $values = Material_Attribute_Value::whereIn('id', $request->input('id'))->pluck('value', 'attribute_id')->all();
        foreach (Material_Item_Type::find($request->input('type_id'))->attributes->pluck('id')->all() as $tid){
            $model==='' ? $model.=$values[$tid] : $model.='-'.$values[$tid];
        }
        $request->merge(['model'=>$model]);

        $this->validate($request, [
            'model' => 'unique:material__items,model,NULL,id,supplier_id,'.$request->input('supplier_id'),
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
            return redirect()->back()->withInput()->withErrors($e);
        }
        DB::commit();
        return redirect('material/type/'.$request->input('type_id'))->withErrors('Success!');
    }

    public function edit($id)
    {
        return view('material.item.edit')->withItem(Material_Item::find($id))->withSuppliers(Supplier::pluck('name', 'id')->sortBy('name'))->withTypes(Material_Attribute_Type::pluck('name', 'id'))->withChecks(Material_Item::find($id)->values()->pluck('attribute_id')->all());
    }

    public function reselect(Request $request, $id){
        $this->validate($request, [
            'model' => 'unique:material__items,model,'.$id.',id,supplier_id,'.$request->input('supplier_id'),
            'types' => 'required',
        ]);
        $data = collect();
        foreach (array_sort_recursive($request->input('types')) as $tid){
            $data->push(['name' => Material_Attribute_Type::find($tid)->name, 'values' => Material_Attribute_Value::where('attribute_id', $tid)->pluck('value', 'id')->toArray()]);
        }
        return view('material.item.reselect')->withIid($id)->withModel($request->input('model'))->withTid($request->input('type_id'))->withSupplier(Supplier::find($request->input('supplier_id')))->withTypes(Material_Item_Type::pluck('name', 'id')->toArray())->withData($data)->withSelected(Material_Item::find($id)->values()->pluck('id')->all());
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'model' => 'required',
            'supplier_id' => 'required',
            'type_id' => 'required',
            'price' => 'required|numeric|min:0',
            'id' => 'required',
        ]);

//        if(Material_Item::where('model', $request->input('model'))->count()>0){
//            foreach (Material_Item::where('model', $request->input('model'))->get() as $item){
//                if($item->values->pluck('id')->all() == $request->input('id')){
//                    return redirect('material/item')->withErrors('This set of attribute values already exist!');
//                }
//            }
//        }

        DB::beginTransaction();
        try {
            $item = Material_Item::find($id);
            $item->update($request->all());
            $item->values()->sync($request->input('id'));
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e);
        }
        DB::commit();
        return redirect('material/item')->withInput()->withErrors('Success!');

    }
}
