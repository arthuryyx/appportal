<?php

namespace App\Http\Controllers\Appliance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Appliance_Invoice;

class BulkController extends Controller
{
    public function index()
    {
        return view('appliance.invoice.bulk.index')->withInvoices(Appliance_Invoice::where('type', 1)->get());
    }

    public function create()
    {
        return view('appliance.invoice.bulk.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'receipt_id' => 'required|unique:projects',
        ]);

        $t = $request->all();
        $t['type'] = 1;
        $t['created_by'] = Auth::user()->id;

        if (Appliance_Invoice::create($t)) {
            return redirect('appliance/invoice/bulk')->withErrors('添加成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }

    public function edit($id)
    {
        return view('appliance.invoice.bulk.edit')->withInvoice(Appliance_Invoice::find($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'receipt_id' => 'required|unique:projects,receipt_id,'.$id,
        ]);

        if (Appliance_Invoice::find($id)->update($request->all())) {
            return redirect('appliance/invoice/bulk')->withErrors('更新成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

    public function show($id)
    {
        return view('appliance.invoice.bulk.show')->withInvoice(Appliance_Invoice::with('hasManyStocks')->find($id));
    }
}
