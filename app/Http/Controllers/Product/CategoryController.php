<?php

namespace App\Http\Controllers\Product;

use App\Product_Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function manageCategory()
    {
        $categories = Product_Category::where('parent_id', '=', 0)->get();
        $allCategories = Product_Category::pluck('name','id')->all();
        $types = array(1 => 'Cabinet', 2 => 'Benchtop');
        return view('product.category.categoryTreeview',compact('categories','allCategories','types'));
    }

    public function addCategory(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
        ]);

        Product_Category::create($request->all());
        return back()->with('success', 'New Category added successfully.');
    }

    public function selectAjax(Request $request)
    {
        if($request->has('parent_id')){
            return Product_Category::find($request->parent_id)->type;
        }
    }
}
