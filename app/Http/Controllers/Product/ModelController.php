<?php

namespace App\Http\Controllers\Product;

use App\Material_Item;
use App\Material_Item_Type;
use App\Product_Model;
use App\Product_Category;
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
        return view('product.create')->withTypes(Material_Item_Type::pluck('name', 'id'));
    }

    public function select(Request $request){
        $this->validate($request, [
            'model' => 'required|unique:product__models',
            'types' => 'required',
        ]);
        $data = collect();
        foreach (array_sort_recursive($request->input('types')) as $id){
            $data->push(['name' => Material_Item_Type::find($id)->name, 'values' => Material_Item::where('type_id', $id)->pluck('model', 'id')->toArray()]);
        }
        return view('product.select')->withModel($request->input('model'))->withCategories(Product_Category::pluck('name','id')->all())->withData($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|unique:product__models',
            'category_id' => 'required',
            'id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $model = Product_Model::create($request->all());
            $model->materials()->attach($request->input('id'));
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e);
        }
        DB::commit();
        return redirect('product/model')->withErrors('Success！');

    }

    public function edit($id)
    {
        return view('product.edit')->withProduct(Product_Model::find($id))->withTypes(Material_Item_Type::pluck('name', 'id'))->withChecks(Product_Model::find($id)->materials()->pluck('type_id')->all());
    }

    public function reselect(Request $request, $id){
        $this->validate($request, [
            'model' => 'required|unique:product__models,model,'.$id,
            'types' => 'required',
        ]);
        $data = collect();
        foreach (array_sort_recursive($request->input('types')) as $tid){
            $data->push(['name' => Material_Item_Type::find($tid)->name, 'values' => Material_Item::where('type_id', $tid)->pluck('model', 'id')->toArray()]);
        }
        return view('product.reselect')->withPid($id)->withModel($request->input('model'))->withCid($request->input('category_id'))->withCategories(Product_Category::pluck('name','id')->all())->withData($data)->withSelected(Product_Model::find($id)->materials()->pluck('id')->all());
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'model' => 'required|unique:product__models,model,'.$id,
            'category_id' => 'required',
            'id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $product = Product_Model::find($id);
            $product->update($request->all());
            $product->materials()->sync($request->input('id'));
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e);
        }
        DB::commit();
        return redirect('product/model')->withInput()->withErrors('Success!');

    }

    public function show($id)
    {
        return view('product.show')->withProduct(Product_Model::with('materials')->find($id));
    }
}
