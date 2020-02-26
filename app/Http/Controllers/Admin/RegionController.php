<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Region;

class RegionController extends Controller
{
    public function index()
    {
        return view('admin.region.index')->withRegions(Region::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:regions',
            'code' => 'required|unique:regions',
        ]);
        $t = $request->input();
        $t['status'] = 1;

        if (Region::create($t)) {
            return redirect()->back();
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }

    public function edit($id)
    {
        return view('admin/region/edit')->withRegion(Region::find($id));
    }

    public function update(Request $request, $id)
    {
        $t = $request->input();

        if(is_null($request->input('status'))) {
            $t['status'] = 0;
        } else {
            $this->validate($request, [
                'name' => 'required|unique:regions,name,'.$id,
                'code' => 'required|unique:regions,code,'.$id,
            ]);
            $t['status'] = 1;
        }

        if (Region::find($id)->update($t)) {
            return redirect('admin/region/'.$request->get('type'));
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

//    public function destroy($id)
//    {
//        $region = Region::find($id);
//        if($region->roles()->count()==0){
//            $region->delete();
//            return redirect()->back()->withInput()->withErrors('删除成功！');
//        } else{
//            return redirect()->back()->withInput()->withErrors('有关联关系，删除失败！');
//        }
//    }
}
