<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\User;
use App\Role;

class AccountController extends Controller
{
    public function index()
    {
        return view('admin.account.index')->withUsers(User::all())->withRoles(Role::pluck('label', 'id'));
    }

//    public function store(Request $request)
//    {
//        $this->validate($request, [
//            'name' => 'required|unique:roles',
//            'label' => 'required',
//        ]);
//
//        DB::beginTransaction();
//
//        try {
//            $role = Role::create($request->all());
//            $role->permissions()->attach($request->all()['permission']);
//
//        } catch(\Exception $e)
//        {
//            DB::rollback();
//            return redirect()->back()->withInput()->withErrors($e);
//        }
//        DB::commit();
//        return redirect()->back()->withInput()->withErrors('Success!');
//    }
//
    public function edit($id)
    {
        return view('admin/account/edit')->withUser(User::find($id))->withRoles(Role::pluck('label', 'id'))->withChecks(User::find($id)->roles()->pluck('id')->all());
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        DB::beginTransaction();
        $r = $request->all();
        if (!array_key_exists('role', $r)){
            $r['role'] = [];
        }
        try {
            $user = User::find($id);
            $user->update($r);
            $user->roles()->sync($r['role']);
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e);
        }
        DB::commit();
        return redirect('admin/account')->withInput()->withErrors('Success!');
    }

//    public function destroy($id)
//    {
//        $user = Role::find($id);
//
//        if($user->users()->count()==0){
//            $user->permissions()->sync([]);
//            $user->delete();
//            return redirect()->back()->withInput()->withErrors('删除成功！');
//        } else{
//            return redirect()->back()->withInput()->withErrors('有关联关系，删除失败！');
//        }
//    }
}
