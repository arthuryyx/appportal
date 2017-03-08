<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        return view('admin.project.index')->withProjects(Project::all());
    }

    public function create()
    {
        return view('admin.project.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'receipt_id' => 'required|unique:projects',
            'customer_name' => 'required',
            'address' => 'required',
        ]);

        $t = $request->all();
        if(is_string($t['job_id']) && $t['job_id'] === '') unset($t['job_id']);
        $t['created_by'] = Auth::user()->id;

        if (Project::create($t)) {
            return redirect('admin/project');
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }

    public function edit($id)
    {
        return view('admin.project.edit')->withProject(Project::find($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'receipt_id' => 'required|unique:projects,receipt_id,'.$id,
            'customer_name' => 'required',
            'address' => 'required',
        ]);

        $t = $request->all();
        if(is_string($t['job_id']) && $t['job_id'] === '') unset($t['job_id']);

        if (Project::find($id)->update($t)) {
            return redirect('admin/project');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

    public function show($id)
    {
        return view('admin.project.show')->withProject(Project::with('hasManyAppliances')->find($id));
    }

//    public function destroy($id)
//    {
//        Project::find($id)->delete();
//        return redirect()->back()->withInput()->withErrors('删除成功！');
//    }

    public function generateDeliveryList(){
        return view('admin.project.pdf.delivery');
    }
}
