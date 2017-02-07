<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;

class ProjectController extends Controller
{
    public function index()
    {
        return view('admin.project.index')->withProjects(Project::all());
    }
//
    public function create()
    {
        return view('admin.project.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'customer_id' => 'required',
            'job_id' => 'required|unique:projects',
            'address' => 'required',

        ]);


        $t = $request->all();
        foreach ($t as $k=>$v){
            if(is_string($v) && $v === '') unset($t[$k]);
        }


        if (Project::create($t)) {
            return redirect('admin/project');
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }

    public function edit($id)
    {
        return view('admin.project.edit')->withProject(Project::with('haManyAppliances')->find($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'customer_id' => 'required',
            'job_id' => 'required|unique:projects,job_id,'.$id,
            'address' => 'required',
        ]);


        $t = $request->all();
        foreach ($t as $k=>$v){
            if(is_string($v) && $v === '') $t[$k] = null;
        }


        if (Project::find($id)->update($t)) {
            return redirect('admin/project');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

//    public function show($id)
//    {
//        return view('admin.project.show')->withProject(Project::with('haManyAppliances')->find($id));
//    }

    public function destroy($id)
    {
        Project::find($id)->delete();
        return redirect()->back()->withInput()->withErrors('删除成功！');
    }
}
