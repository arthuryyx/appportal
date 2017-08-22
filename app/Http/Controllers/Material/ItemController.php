<?php

namespace App\Http\Controllers\Material;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Supplier;
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
        if($request->offsetExists('id')){
            $combinations = $this->carteSian(array_values($request->input('id')));
        }else{
            $combinations = [[]];
        }

        DB::beginTransaction();
        try {
            foreach ($combinations as $set){
                $request->merge(['id' => $set]);
                $this->processRequest($request);
                $this->validate($request, [
                    'model' => 'required|unique:material__items,model,NULL,id,type_id,'.$request->input('type_id').',supplier_id,'.$request->input('supplier_id'),
                    'supplier_id' => 'required',
                    'type_id' => 'required',
                    'price' => 'required|numeric|min:0',
//                  'id' => 'required',
                ]);

                $item = Material_Item::create($request->all());
                if($request->offsetExists('id')){
                    $item->values()->attach($request->input('id'));
                }
            }
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
            'model' => 'required|unique:material__items,model,'.$id.',id,type_id,'.$request->input('type_id').',supplier_id,'.$request->input('supplier_id'),
            'supplier_id' => 'required',
            'type_id' => 'required',
            'price' => 'required|numeric|min:0',
//            'id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $item = Material_Item::find($id);
            $item->update($request->all());
            if($request->offsetExists('id')){
                $item->values()->sync($request->input('id'));
            } else{
                $item->values()->detach();
            }
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
        $model = trim($request->input('bak'));

        if($request->offsetExists('id')){
            if(empty(array_filter($request->input('id')))){
                $request->offsetUnset('id');
            }else{
                $request->merge(['id'=>array_filter($request->input('id'))]);

                $values = Material_Attribute_Value::whereIn('id', $request->input('id'))->pluck('value', 'attribute_id')->all();
                foreach (Material_Item_Type::find($request->input('type_id'))->attributes->pluck('id')->all() as $tid){
                    if(array_has($values, $tid)){
                        $model=='' ? $model.=$values[$tid] : $model.='-'.$values[$tid];
                    }
                }
            }
        }
        $request->merge(['model'=>$model]);
    }

    private function carteSian(array $params, array $temporary = [], array $products = [])
    {
        foreach (array_shift($params) as $param) {
            array_push($temporary, $param);
            if($params){
                $products = $this->carteSian($params, $temporary, $products) ;
            }else{
                array_push($products, $temporary);
            }
            array_pop($temporary);
        }
        return $products;
    }

    public function reconstruct($tid)
    {
        $attributes = Material_Item_Type::find($tid)->attributes->pluck('id')->all();
        foreach (Material_Item_Type::find($tid)->hasManyItems->pluck('id')->all() as $id){
            $item = Material_Item::find($id);
            $model = $item->bak;
            if(!empty($item->values->all())){
                $values = $item->values->pluck('value', 'attribute_id')->all();
                foreach ($attributes as $tid){
                    if(array_has($values, $tid)){
                        $model=='' ? $model.=$values[$tid] : $model.=' '.$values[$tid];
                    }
                }
            }
            $validator = Validator::make(['model' => $model], [
                'model' => 'required|unique:material__items,model,'.$item->id.',id,type_id,'.$item->type_id.',supplier_id,'.$item->supplier_id,
            ]);

            if ($validator->fails()) {
                $item->update(['model' => 'duplicate'.$item->id]);
            }else{
                $item->update(['model' => $model]);
            }
        }
        return redirect('material/type/'.$item->type_id)->withErrors('Success!');
    }
}
