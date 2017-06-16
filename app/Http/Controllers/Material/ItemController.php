<?php

namespace App\Http\Controllers\Material;

use App\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Material_Attribute_Type;
use App\Material_Attribute_Value;
use App\Material_Item;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    public function index()
    {
        return view('material.item.index')->withItems(Material_Item::all());
    }

    public function selectType()
    {
        return view('material.item.type')->withTypes(Material_Attribute_Type::pluck('name', 'id'));
    }

    public function setValue(Request $request){
        $data = collect();
        foreach (array_sort_recursive($request->input('types')) as $id){
            $data->push(['name' => Material_Attribute_Type::find($id)->name, 'values' => Material_Attribute_Value::where('attribute_id', $id)->pluck('value', 'id')->toArray()]);
        }
        return view('material.item.value')->withModel($request->input('model'))->withSuppliers(Supplier::pluck('name', 'id')->sortBy('name')->toArray())->withData($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required',
            'id' => 'required',
        ]);

        if(Material_Item::where('model', $request->input('model'))->count()>0){
            foreach (Material_Item::where('model', $request->input('model'))->get() as $item){
                if($item->values->pluck('id')->all() == $request->input('id')){
                    return redirect('material/item')->withErrors('This set of attribute values already exist!');
                }
            }
        }

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
        return redirect('material/item')->withErrors('Success!');
    }
}
