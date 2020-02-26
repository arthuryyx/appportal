<?php

namespace App\Http\Controllers\Kitchen;

use App\Kitchen_Job_Quote;
use App\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Kitchen_Job_Quote_Controller extends Controller
{
    public function index()
    {
        if(Auth::user()->can('root')){
            return view('kitchen.job.quote.index')->withQuotes(Kitchen_Job_Quote::with('hasManyItems')
                ->with('getCreated_by')
                ->orderBy('id', 'desc')
                ->get());
        } else{
            return view('kitchen.job.quote.index')->withQuotes(Kitchen_Job_Quote::where('created_by', Auth::user()->id)
                ->with('hasManyItems')
                ->with('getCreated_by')
                ->orderBy('id', 'desc')
                ->get());
        }
    }

    public function create()
    {
        return view('kitchen.job.quote.create')->withRegions(Auth::user()->regions->pluck('name', 'code'));
    }

    public function store(Request $request)
    {
        $request->merge(['quote_no' => $request->input('code').(Kitchen_Job_Quote::where('quote_no', 'LIKE', $request->input('code')."%")->count() + 1), 'created_by' => Auth::user()->id]);
        $this->validate($request, [
            'quote_no' => 'required|unique:kitchen__job__quotes',
//            'price' => 'required|numeric|min:0',
            'customer' => 'required',
            'phone' => 'numeric',
            'email' => 'email',
//            'address' => 'required',
            'created_by' => 'required|exists:users,id',
        ]);

        try{
            $obj = Kitchen_Job_Quote::create($request->input());
        } catch (QueryException $e)
        {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
        return redirect('kitchen/job/quote/'.$obj->id)->withSuccess('添加成功！');

    }

    public function edit($id)
    {
        return view('kitchen.job.quote.edit')->withQuote(Kitchen_Job_Quote::find($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
//            'quote_no' => 'required|unique:kitchen__job__quotes,quote_no,'.$id,
//            'price' => 'required|numeric|min:0',
            'customer' => 'required',
            'phone' => 'numeric',
            'email' => 'email',
//            'address' => 'required',
        ]);

        DB::beginTransaction();
        try {
            Kitchen_Job_Quote::find($id)->update($request->all());
        } catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
        DB::commit();
        return redirect('kitchen/job/quote/'.$id)->withSuccess('更新成功！');
    }

    public function show($id)
    {
        return view('kitchen.job.quote.show')->withQuote(Kitchen_Job_Quote::with('hasManyItems')->find($id));
    }

//    public function quoteHtml($id)
//    {
//        return view('appliance.quote.html')->withQuote(Kitchen_Job_Quote::find($id))
//            ->withItems(Appliance_Item::where('quote_id', $id)->with('getAppliance.belongsToBrand')->groupBy('aid', 'price', 'warranty')->select('aid', DB::raw('count(aid) as total'), DB::raw('sum(price) as price'), 'warranty')->get());
//    }
}
