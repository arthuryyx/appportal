<?php

namespace App\Http\Controllers\Appliance;

use App\Http\Controllers\Controller;
use App\Appliance_Item;
use App\Appliance_Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QuoteController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('appliance_view_all_quotes')){
            return view('appliance.quote.index')->withQuotes(Appliance_Quote::with('hasManyItems')
                ->with('getCreated_by')
                ->orderBy('id', 'desc')
                ->get());
        } else{
            return view('appliance.quote.index')->withQuotes(Appliance_Quote::whereDate('created_at', '>=', Carbon::today()->addDays(-30))
                ->where('created_by', Auth::user()->id)
                ->where('invoice_id', null)
                ->with('hasManyItems')
                ->with('getCreated_by')
                ->orderBy('id', 'desc')
                ->get());
        }
    }

    public function create()
    {
        return view('appliance.quote.create');
    }

    public function store(Request $request)
    {
        $request->merge(['created_by' => Auth::user()->id]);
        $this->validate($request, [
            'quote_no' => 'required|unique:appliance__quotes',
            'price' => 'required|numeric|min:0',
//            'customer_name' => 'required',
            'phone' => 'numeric',
            'email' => 'email',
//            'address' => 'required',
            'created_by' => 'required|exists:users,id',
        ]);

        try{
            $obj = Appliance_Quote::create($request->input());
        } catch (QueryException $e)
        {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
        return redirect('appliance/quote/'.$obj->id)->withSuccess('添加成功！');

    }

    public function edit($id)
    {
        return view('appliance.quote.edit')->withQuote(Appliance_Quote::find($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'quote_no' => 'required|unique:appliance__quotes,quote_no,'.$id,
            'price' => 'required|numeric|min:0',
//            'customer_name' => 'required',
            'phone' => 'numeric',
            'email' => 'email',
//            'address' => 'required',
        ]);

        DB::beginTransaction();
        try {
            Appliance_Quote::find($id)->update($request->all());
        } catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
        DB::commit();
        return redirect('appliance/quote/'.$id)->withSuccess('更新成功！');
    }

    public function show($id)
    {
        return view('appliance.quote.show')->withQuote(Appliance_Quote::with('hasManyItems.getAppliance.belongsToBrand')
            ->with('hasManyItems.getAppliance.belongsToCategory')->find($id));
    }

    public function quoteHtml($id)
    {
        return view('appliance.quote.html')->withQuote(Appliance_Quote::find($id))
            ->withItems(Appliance_Item::where('quote_id', $id)->with('getAppliance.belongsToBrand')->groupBy('aid', 'price', 'warranty')->select('aid', DB::raw('count(aid) as total'), DB::raw('sum(price) as price'), 'warranty')->get());
    }

}
