<?php

namespace App\Http\Controllers\Product;

use App\Material_Item;
use App\Material_Item_Type;
use App\Product_Model;
use App\Product_Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductModelController extends Controller
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

//    public function edit($id)
//    {
//        return view('material.attribute.type.edit')->withAttribute(Material_Attribute_Type::find($id));
//    }
//
//    public function update(Request $request, $id)
//    {
//        $this->validate($request, [
//            'name' => 'required|unique:material__attribute__types,name,'.$id,
////            'unit' => 'required',
//        ]);
//
//        if (Material_Attribute_Type::find($id)->update($request->all())) {
//            return redirect('material/attribute/')->withErrors('更新成功！');
//        } else {
//            return redirect()->back()->withInput()->withErrors('更新失败！');
//        }
//    }
//
//    public function show($id)
//    {
//        return view('material.attribute.type.show')->withAttribute(Material_Attribute_Type::with('hasManyValues')->find($id));
//    }
}
