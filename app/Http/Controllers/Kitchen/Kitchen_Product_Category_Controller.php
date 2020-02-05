<?php

namespace App\Http\Controllers\Kitchen;

use App\Kitchen_Product_Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Kitchen_Product_Category_Controller extends Controller
{
    public function index()
    {
        return view('kitchen.product.category.index')->withTable(Kitchen_Product_Category::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:kitchen__product__categories',
        ]);

        DB::beginTransaction();
        try {
            Kitchen_Product_Category::create($request->input());

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
        return view('kitchen.product.category.edit')->withCategory(Kitchen_Product_Category::find($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:kitchen__product__categories,name,'.$id,
        ]);

        DB::beginTransaction();

        try {
            Kitchen_Product_Category::find($id)->update($request->input());
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e);
        }
        DB::commit();
        return redirect('kitchen/product/category')->withInput()->withErrors('Success!');
    }
}
