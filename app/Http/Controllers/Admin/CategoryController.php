<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index($type)
    {
        return view('admin.category.index')->withCategories(Category::where('type', $type)->get())->withType($type);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories',
            'type' => 'required',
        ]);

        if (Category::create($request->all())) {
            return redirect()->back();
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }

    public function edit($id)
    {
        return view('admin/category/edit')->withCategory(Category::find($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name,'.$id,
            'type' => 'required',
        ]);

        if (Category::find($id)->update($request->all())) {
            return redirect('admin/category/'.$request->get('type'));
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }
    public function destroy($id)
    {
        Category::find($id)->delete();
        return redirect()->back()->withInput()->withErrors('删除成功！');
    }
}
