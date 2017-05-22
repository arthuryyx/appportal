<?php

namespace App\Http\Controllers\Customer;

use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    public function create($cid)
    {
        if (Session::has('backUrl')) {
            Session::keep('backUrl');
        }
        return view('customer.address.create')->withCid($cid);
    }

    public function store(Request $request)
    {
        if (Session::has('backUrl')) {
            Session::keep('backUrl');
        }
        $t = $request->all();
        $this->validate($request, [
            'customer_id' => 'required|exists:customers,id',
            'street' => 'required|unique:addresses',
            'sub' => 'required',
            'city' => 'required',
//            'zip' => 'required',
        ]);
        $t['type'] = 2;
        if (Address::create($t)) {
            return redirect(Session::get('backUrl'))->withErrors('新建成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('新建失败！');
        }
    }

    public function edit($id)
    {
        if (Session::has('backUrl')) {
            Session::keep('backUrl');
        }
        return view('customer.address.edit')->withAddress(Address::find($id));
    }

    public function update(Request $request, $id)
    {
        if (Session::has('backUrl')) {
            Session::keep('backUrl');
        }
        $this->validate($request, [
            'street' => 'required|unique:addresses,street,'.$id,
            'sub' => 'required',
            'city' => 'required',
        ]);
        
        if (Address::find($id)->update($request->all())) {
            return redirect(Session::get('backUrl'))->withErrors('更新成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

}
