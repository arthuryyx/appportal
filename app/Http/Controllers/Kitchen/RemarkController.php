<?php

namespace App\Http\Controllers\Kitchen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Kitchen_Job_Remark;

class RemarkController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->merge(['job_id' => $id, 'created_by' => Auth::user()->id]);
        $this->validate($request, [
            'job_id' => 'required|exists:kitchen__jobs,id',
            'content' => 'required',
            'created_by' => 'required|exists:users,id'
        ]);
        try {
            Kitchen_Job_Remark::create($request->input());
        } catch(\Exception $e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        return redirect('kitchen/job/'.$id)->withSuccess('备注成功！');
    }
}
