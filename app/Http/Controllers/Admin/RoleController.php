<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.role.index')->withRoles(Role::all())->withPermissions(Permission::pluck('label', 'id'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles',
            'label' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $role = Role::create($request->all());
            $role->permissions()->attach($request->all()['permission']);
//            throw new \Exception();
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
        return view('admin/role/edit')->withRole(Role::find($id))->withPermissions(Permission::pluck('label', 'id'))->withChecks(Role::find($id)->permissions()->pluck('id')->all());
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name,'.$id,
            'label' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $role = Role::find($id);
            $role->update($request->all());
            $role->permissions()->sync($request->all()['permission']);
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e);
        }
        DB::commit();
        return redirect('admin/role')->withInput()->withErrors('Success!');
    }
    public function destroy($id)
    {
        $role = Role::find($id);
//        dd($role);
        if($role->users()->count()==0){
            $role->permissions()->sync([]);
            $role->delete();
            return redirect()->back()->withInput()->withErrors('删除成功！');
        } else{
            return redirect()->back()->withInput()->withErrors('有关联关系，删除失败！');
        }
    }
}
