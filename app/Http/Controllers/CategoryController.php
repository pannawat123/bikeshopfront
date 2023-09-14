<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Config, Validator;

class CategoryController extends Controller
{
    var $rp = 2;
    public function index()
    {
        $categories = Category::paginate($this->rp);
        return view('category/index', compact('categories'));
    }

    public function search(Request $request)
    {
        $query = $request->q;
        if ($query) {
            $categories = Category::where('id', 'like', '%' . $query . '%')
                ->orWhere('name', 'like', '%' . $query . '%')
                ->paginate($this->rp);
        } else {
            $categories = Category::paginate($this->rp);
        }

        return view('category/index', compact('categories'));
    }

    public function edit($id = null)
    {
        if ($id) {
            $category = Category::where('id', $id)->first();
            return view('category/edit')
                ->with('category', $category);
        } else {
            return view('category/add');
        }
    }

    public function update(Request $request)
    {

        $rules = array(
            'name' => 'required',
        );
        $messages = array(
            'required' => 'กรุณากรอกข้อมูล :attribute ให้ครบถ้วน', 
        );

        $id = $request->id;
        $temp = array(
            'id' => $request->id,
            'name' => $request->name, 
        );

        $validator = Validator::make($temp, $rules, $messages);
        if ($validator->fails()) {
            return redirect('category/edit/'.$id)
            ->withErrors($validator)
            ->withInput();
        }

        $category = Category::find($id);
        $category->name = $request->name;
       

        $category->save();

        return redirect('category')
        ->with('ok' , 'true')
        ->with('msg' ,'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    public function insert(Request $request) {
        $rules = array(
            'name' => 'required',
        );
        $messages = array(
            'required' => 'กรุณากรอกข้อมูล :attribute ให้ครบถ้วน', 
        );

        $temp = array(
            'name' => $request->name, 
        );

        $validator = Validator::make($temp, $rules, $messages);
        if ($validator->fails()) {
            return redirect('category/edit')
            ->withErrors($validator)
            ->withInput();
        }

        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return redirect('category')
        ->with('ok' , 'true')
        ->with('msg' ,'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    public function remove ($id){
        Category::find($id)->delete();
        return redirect('category')
        ->with('ok' , 'true')
        ->with('msg' ,'ลบข้อมูลเรียบร้อยแล้ว');
    }
    


}