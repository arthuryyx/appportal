<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Material_Item_Type;
use App\Product_Part;

class PartController extends Controller
{
    public function index()
    {
        return view('product.part.index')->withParts(Product_Part::all());
    }

    public function create()
    {
        return view('product.part.create')->withTypes(Material_Item_Type::pluck('name', 'id')->toArray());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:product__parts',
            'id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $part = Product_Part::create($request->all());
            $part->materialTypes()->attach($request->input('id'));
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e);
        }
        DB::commit();
        return redirect('product/part')->withErrors('Success！');
    }

    public function edit($id)
    {
        return view('product.part.edit')->withPart(Product_Part::find($id))->withTypes(Material_Item_Type::pluck('name', 'id')->toArray())->withSelected(Product_Part::find($id)->materialTypes()->pluck('type_id')->all());
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:product__parts,name,'.$id,
            'id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $product = Product_Part::find($id);
            $product->update($request->all());
            $product->materialTypes()->sync($request->input('id'));
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e);
        }
        DB::commit();
        return redirect('product/part')->withInput()->withErrors('Success!');
    }

}
