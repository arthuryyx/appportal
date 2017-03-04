<?php

namespace App\Http\Controllers\Admin;

use App\Board;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BoardController extends Controller
{
    public function index()
    {
        return view('admin.board.index')->withBoards(Board::all());
    }

    public function store(Request $request)
    {

        $data = $request->all();
        $data['name'] = $data['thickness'].' '.$data['brand'].' '.$data['color'].' '.$data['finish'].' '.$data['making'].' D/S';
        if (Board::create($data)) {
            return redirect()->back();
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }


    public function destroy($id)
    {
        $obj = Board::find($id);
//        if($obj->hasManyAppliances()->count()==0){
            $obj->delete();
            return redirect()->back()->withInput()->withErrors('删除成功！');
//        } else{
//            return redirect()->back()->withInput()->withErrors('有关联关系，删除失败！');
//        }
    }
}
