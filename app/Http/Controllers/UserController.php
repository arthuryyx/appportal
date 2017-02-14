<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function settings(){
        return view('user.settings')->withUser(Auth::user());
    }

    public function reset(Request $request){
        $this->validate($request, [
            'current' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $input = $request->all();
        $user = User::find(auth()->user()->id);

        if(Hash::check($input['current'], $user->password)){

            $r = $user->forceFill([
                'password' => bcrypt($input['password']),
                'remember_token' => Str::random(60),
            ])->save();

            Auth::guard()->login($user);
            if($r){
                return redirect()->back()->withInput()->withErrors('修改成功！');
            }else{
                return redirect()->back()->withInput()->withErrors('修改失敗！');
            }

        }else{
            return redirect()->back()->withInput()->withErrors('Return error with current passowrd is not match');
        }
    }
}