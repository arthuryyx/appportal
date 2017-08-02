<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;

use App\Kitchen_Product;
use App\Kitchen_Product_Material;
use App\Product_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Address;
use App\Customer;
use App\Material_Item;
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

    public function selectAjax(Request $request)
    {
        if($request->ajax()){
            $data = array();
            foreach (Product_Model::find($request->model_id)->parts()->get() as $part){
                $data[$part->id] = Material_Item::whereIn('type_id', $part->materialTypes->pluck('id')->all())->pluck('model', 'id')->all();
            }
            return view('kitchen.quotation.parts')->withParts(Product_Model::find($request->model_id)->parts()->get())->withData($data)->render();
//            return response()->json(['options'=>$data]);
        }
    }

    public function selectProduct(Request $request) {
        $this->validate($request, [
            'product_id' => 'required|exists:product__models,id',
            'quotation_id' => 'required|exists:kitchen__quotations,id',
        ]);

        $price = 0;
        foreach (request()->input('materials') as $value){
            $price += Material_Item::find($value['mid'])->price * $value['qty'];
        }
        $request->merge(['price' => $price]);
//        dd($price);

        DB::beginTransaction();
        try {
            $kpi = Kitchen_Product::create($request->all())->id;
            foreach (request()->input('materials') as $key => $value){
                Kitchen_Product_Material::create(['kitchen_product_id' => $kpi, 'product_part_id' => $key, 'material_item_id' => $value['mid'], 'qty' => $value['qty']===''?null:$value['qty']]);
            }
        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        DB::commit();

        return redirect()->back()->withErrors('添加成功！');
    }

    public function deleteProduct(Request $request){
        $this->validate($request, [
            'qid' => 'required',
            'id' => 'required',
        ]);

        if(Kitchen_Quotation::find($request->input('qid'))->state >0) {
            return redirect()->back()->withInput()->withErrors('删除失败！');
        }

        DB::beginTransaction();
        try {
            foreach ($request->input('id') as $id){
                Kitchen_Product::find($id)->delete();
            }

        } catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        DB::commit();
        return redirect()->back()->withInput()->withErrors('删除成功！');
    }

    public function approve(Request $request) {
        $this->validate($request, [
            'id' => 'required|exists:kitchen__quotations,id',
        ]);
        if (Kitchen_Quotation::find($request->input('id'))->update(['state'=>1])) {
            return redirect('kitchen/quot/'.$request->input('id'))->withErrors('更新成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

}
