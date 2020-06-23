<?php

namespace App\Http\Controllers\Admin;

use App\Appliance;
use App\Brand;
use App\Category;
use App\Appliance_Stock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;


class ApplianceController extends Controller
{
    public function index()
    {
        return view('admin.appliance.index');
//        return view('admin.appliance.index')->withAppliances(Appliance::with('belongsToBrand')->with('belongsToCategory')->get());
    }

    public function  ajaxIndex()
    {
        $objects = Appliance::query()
            ->with('belongsToBrand')
            ->with('belongsToCategory');
//            ->orderBy('id', 'desc');

        return Datatables::of($objects)
            ->editColumn('brand', function ($obj) {
                return $obj->belongsToBrand->name;
            })->editColumn('category', function ($obj) {
                return $obj->belongsToCategory->name;
            })->editColumn('state', function ($obj) {
                if ($obj->state)
                    return '<label class="label label-danger">Discontinued</label>';
                else
                    return '<label class="label label-success">In Use</label>';
            })->addColumn('edit', function ($obj) {
                return '<a href="' . url('admin/appliance/' . $obj->id) . '/edit' . '" class="btn btn-success" target="_blank">编辑</a>';
            })
            ->make(true);
    }
    public function create()
    {
        return view('admin.appliance.create')->withBrands(Brand::orderBy('name')->pluck('name', 'id'))->withCategories(Category::orderBy('name')->pluck('name', 'id'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|unique:appliances,model,NULL,id,brand_id,'.$request->input('brand_id'),
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'rrp' => 'numeric|min:0',
        ]);

        $t = $request->all();
        $t['state'] = 0;
        foreach ($t as $k=>$v){
            if(is_string($v) && $v === '') unset($t[$k]);
        }

        try {
            Appliance::create($t);
        } catch (\Exception $e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        return redirect()->back()->withSuccess('添加成功！');
    }

    public function edit($id)
    {
        return view('admin/appliance/edit')->withModel(Appliance::find($id))->withBrands(Brand::orderBy('name')->pluck('name', 'id'))->withCategories(Category::orderBy('name')->pluck('name', 'id'));
    }

    public function update(Request $request, $id)
    {
        $t = $request->all();

        if(is_null($request->input('state'))) {
            $this->validate($request, [
                'model' => 'required|unique:appliances,model,'.$id.',id,brand_id,'.$request->input('brand_id'),
                'brand_id' => 'required|exists:brands,id',
                'category_id' => 'required|exists:categories,id',
                'rrp' => 'numeric|min:0',
            ]);

            foreach ($t as $k=>$v){
                if(is_string($v) && $v === '') $t[$k] = null;
            }
            $t['state'] = 0;
        } else {
            $t['state'] = 1;
        }

        try {
            Appliance::find($id)->update($t);
        } catch (\Exception $e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        return redirect()->back()->withSuccess('添加成功！');
    }

    public function destroy($id)
    {
        if(Appliance_Stock::where('aid', $id)->count()==0){
            Appliance::find($id)->delete();
            return redirect()->back()->withInput()->withErrors('删除成功！');
        } else{
            return redirect()->back()->withInput()->withErrors('有关联关系，删除失败！');
        }
    }
    
    public function barcode(Request $request)
    {
        $this->validate($request, [
            'aid' => 'required|exists:appliances,id',
            'barcode' => 'required|unique:appliances,barcode,'.$request->input('aid'),
        ]);

        try {
            Appliance::find($request->input('aid'))->update(['barcode' => $request->input('barcode')]);
        } catch (\Exception $e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        return redirect()->back()->withSuccess('更新成功！');
    }
    
     public function show($id)
    {
        return view('admin.appliance.model')
            ->withModel(Appliance::where('id', $id)->with('belongsToBrand', 'belongsToCategory')->first())
//            ->withStock(Appliance_Stock::where('aid', $id)->get())
            ->render();
//        return response()->json(Appliance_Model::where('id', $id)->with('getBrand', 'getCategory')->first());
    }


    public function importExport()
    {
        return view('admin.appliance.excel')->withBrands(Brand::orderBy('name')->pluck('name', 'id'));
    }
//
//    public function downloadExcel(Request $request, $type)
//    {
//        $data = Item::get()->toArray();
//        return Excel::create('itsolutionstuff_example', function($excel) use ($data) {
//            $excel->sheet('mySheet', function($sheet) use ($data)
//            {
//                $sheet->fromArray($data);
//            });
//        })->download($type);
//    }

    public function importExcel(Request $request)
    {
        $this->validate($request, [
            'brand_id' => 'required|exists:brands,id',
        ]);
        $bid = $request->input('brand_id');

        if($request->hasFile('import_file')){
            $path = $request->file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {})->get();
//            if(!empty($data) && $data->count()){
//                foreach ($data->toArray() as $key => $value) {
//                    if(!empty($value)){
//                        foreach ($value as $v) {
//                            $insert[] = ['brand' => $v['brand'], 'category' => $v['category']];
//                        }
//                    }
//                }
//                if(!empty($insert)){
//                    Item::insert($insert);
//                    return back()->with('success','Insert Record successfully.');
//                }
//            }
            $m = '';
            if(!empty($data) && $data->count()){
                DB::beginTransaction();
                try {
                    foreach ($data->toArray() as $key => $value) {
                        if(empty($value) || $value['model'] == '')
                            continue;
                        $obj = Appliance::where('model', $value['model'])->where('brand_id', $bid)->first();
                        if($obj==null) {
                            $m = $m . $value['model'] .'<br>';
                        }
                        else{
                            unset($value['model']);
                            $obj->update($value);
                        }
                    }
                } catch(\Exception $e)
                {
                    DB::rollback();
                    return redirect()->back()->withInput()->with('error', $e->getMessage());
                }
                DB::commit();

                if($m === ''){
                    return redirect()->back()->with('success','更新成功！');
                }else{
                    return redirect()->back()->withInput()->withErrors($m);
                }
            }
        }
        return back()->with('error','Please Check your file, Something is wrong there.');
    }
}
