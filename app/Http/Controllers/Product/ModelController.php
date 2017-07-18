<?php

namespace App\Http\Controllers\Product;

use App\Material_Item;
use App\Material_Item_Type;
use App\Product_Model;
use App\Product_Category;
use App\Product_Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ModelController extends Controller
{
    public function index()
    {
        return view('product.index')->withProducts(Product_Model::all());
    }

    public function create()
    {
        return view('product.create')->withCategories(Product_Category::pluck('name','id')->all())->withParts(Product_Part::pluck('name', 'id'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|unique:product__models',
            'category_id' => 'required',
            'part' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $model = Product_Model::create($request->all());
            foreach ($request->input('part') as $value){
                if (is_string($value['qty']) && $value['qty'] === ''){
                    $model->parts()->attach($value['id']);
                }else{
                    $model->parts()->attach($value['id'], ['qty' => $value['qty']]);
                }
            }
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        DB::commit();
        return redirect('product/model')->withErrors('Success！');
    }

    public function edit($id)
    {
        return view('product.edit')->withProduct(Product_Model::find($id))->withCategories(Product_Category::pluck('name','id')->all())->withParts(Product_Part::pluck('name', 'id'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'model' => 'required|unique:product__models,model,'.$id,
            'category_id' => 'required',
            'part' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $model = Product_Model::find($id);
            $model->update($request->all());
            $model->parts()->detach();
            foreach ($request->input('part') as $value){
                if (is_string($value['qty']) && $value['qty'] === ''){
                    $model->parts()->attach($value['id']);
                }else{
                    $model->parts()->attach($value['id'], ['qty' => $value['qty']]);
                }
            }
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        DB::commit();
        return redirect('product/model')->withInput()->withErrors('Success!');

    }

    public function show($id)
    {
        return view('product.show')->withProduct(Product_Model::with('parts')->find($id));
    }
}
