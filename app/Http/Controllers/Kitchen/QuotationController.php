<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;

use App\Kitchen_Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Address;
use App\Customer;
use App\Kitchen_Quotation;


class QuotationController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('kitchen_view_all_quotations')){
            return view('kitchen.quotation.index')->withQuotations(Kitchen_Quotation::all());
        } else{
            return view('kitchen.quotation.index')->withQuotations(Kitchen_Quotation::where('created_by', Auth::user()->id)->get());
        }
    }

    public function create()
    {
        return view('kitchen.quotation.create');
    }

    public function store(Request $request)
    {
        $request->merge(['created_by' => Auth::user()->id]);

        $this->validate($request, [
            'first' => 'required',
            'phone' => 'required_without_all:mobile|numeric|unique:customers',
            'mobile' => 'required_without_all:phone|numeric|unique:customers',
            'email' => 'email|unique:customers',
            'address' => 'required|unique:addresses',
            'created_by' => 'required|exists:users,id',
        ]);

        $inputs = $request->all();
        foreach ($inputs as $k=>$v){
            if(is_string($v) && $v === '') unset($inputs[$k]);
        }

        DB::beginTransaction();
        try {
            $inputs['customer_id'] = Customer::create($inputs)->id ;
            $inputs['address_id'] = Address::create($inputs)->id ;
            $inputs['quot_id'] = Kitchen_Quotation::create($inputs)->id;
            Auth::user()->customers()->attach($inputs['customer_id']);
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
        DB::commit();

        return redirect('kitchen/quot/'.$inputs['quot_id'])->withErrors('添加成功！');
    }

    public function show($id)
    {
        return view('kitchen.quotation.show')->withQuotation(Kitchen_Quotation::find($id));
    }

    public function selectProduct(Request $request) {
        $this->validate($request, [
            'product_id' => 'required|exists:product__models,id',
            'quotation_id' => 'required|exists:kitchen__quotations,id',
        ]);

        if (Kitchen_Product::create($request->all())) {
            return redirect()->back()->withErrors('添加成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }

}
