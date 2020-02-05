<?php

namespace App\Http\Controllers\Kitchen;

use App\Kitchen_Product_Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Kitchen_Product_Brand_Controller extends Controller
{
    public function index()
    {
        return view('kitchen.product.brand.index')->withTable(Kitchen_Product_Brand::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:kitchen__product__brands',
        ]);

        DB::beginTransaction();
        try {
            Kitchen_Product_Brand::create($request->input());

        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e);
        }
        DB::commit();
        return redirect()->back()->withInput()->withErrors('Success!');
    }

    public function edit($id)
    {
        return view('kitchen.product.brand.edit')->withBrand(Kitchen_Product_Brand::find($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:kitchen__product__brands,name,'.$id,
        ]);

        DB::beginTransaction();

        try {
            Kitchen_Product_Brand::find($id)->update($request->input());
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e);
        }
        DB::commit();
        return redirect('kitchen/product/brand')->withInput()->withErrors('Success!');
    }
}
