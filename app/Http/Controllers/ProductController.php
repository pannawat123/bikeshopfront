<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Config, Validator;

class ProductController extends Controller
{
    // rp = Result per Page
    var $rp = 2;

    public function index() {
        $products = Product::paginate($this->rp); //ตัวแปร products เป็นผลมาจากการดึงข้อมูลทั้งหมดขึ้นมา
        return view('product/index' , compact('products')); //ส่งตัวแปร products ไปที่ view
    }

    public function search (Request $request) {
        $query = $request->q;
        if($query) {
            $products = Product::where('code', 'like', '%'.$query.'%')
            ->orWhere('name', 'like', '%'.$query.'%')
            ->orWhere('price', 'like', '%'.$query.'%')
            ->paginate($this->rp);

            //get image
            foreach ($products as $product) {
                $product->image_url = asset('./../'.$product->image_url);
            }
            
        } else {
                $products = Product::paginate($this->rp);
        }
        return view('product/index' , compact('products'));
    }

    public function edit($id = null){
        $categories = Category::pluck('name' , 'id')->prepend('เลือกรายการ' , "");
        if($id) {
            // edit view
            $product = Product::where('id', $id)->first(); 
            return view('product/edit')
            ->with('product', $product)
            ->with('categories', $categories);
        } else {
            //add view
            return view('product/add')
            ->with('categories', $categories);
        }
    }

    public function update(Request $request) {
        $rules = array(
            'code' => 'required', 'name' => 'required',
            'category_id' => 'required|numeric', 
            'price' => 'numeric',
            'stock_qty' => 'numeric',
        );

        $messages = array(
            'required' => 'กรุณากรอกข้อมูล :attribute ให้ครบถ้วน', 
            'numeric' => 'กรุณากรอกข้อมูล :attribute ให้เป็นตัวเลข',
        );

        $id = $request->id;
        $temp = array('name' => $request->name, 
                      'code' => $request->code, 
                      'category_id' => $request->category_id, 
                      'price' => $request->price, 
                      'stock_qty' => $request->stock_qty);
       

       
        $validator = Validator::make($temp, $rules, $messages);
        if ($validator->fails()) {
            return redirect('product/edit/'.$id)
            ->withErrors($validator)
            ->withInput();
        }
        
        $product = Product::find($id);
        $product->code = $request->code;
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->stock_qty = $request->stock_qty;
        
        $product->save();

        if($request->hasFile('image')){
            $f = $request->file('image');
            $upload_to = 'upload/image';
        }

        // get path
        $relative_path = $upload_to.'/'.$f->getClientOriginalName(); //path แบบสัมพันธ์
        $absolute_path = public_path().'/'.$upload_to; // path แท้จริง
        
        // upload file
        $f->move($absolute_path, $f->getClientOriginalName()); //อ่านจากเครื่องเจ้าหน้าที่ มาใน path แท้จริง'
        $product->image_url = $relative_path; 
        $product->save();
        
    
        return redirect('product')
        ->with('ok', 'True')
        ->with('msg', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    //create function insert
    public function insert(Request $request){
        //inset data
        $rules = array(
            'code' => 'required', 'name' => 'required',
            'category_id' => 'required|numeric', 
            'price' => 'numeric',
            'stock_qty' => 'numeric',
        );

        $messages = array(
            'required' => 'กรุณากรอกข้อมูล :attribute ให้ครบถ้วน', 'numeric' => 'กรุณากรอกข้อมูล
            :attribute ให้เป็นตัวเลข',
        );

        $id = $request->id;
        $temp = array('code' => $request->code, 
                        'name' => $request->name, 
                      'category_id' => $request->category_id, 
                      'price' => $request->price, 
                      'stock_qty' => $request->stock_qty);

        $validator = Validator::make($temp, $rules, $messages);
        if ($validator->fails()) {
            return redirect('product/edit/'.$id)
            ->withErrors($validator)
            ->withInput();
        }

        $product = new Product();
        $product->code = $request->code;
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->stock_qty = $request->stock_qty;
        
        $product->save();



        

        if($request->hasFile('image')){
            $f = $request->file('image');
            $upload_to = 'upload/image';
        }

        // get path
        $relative_path = $upload_to.'/'.$f->getClientOriginalName(); //path แบบสัมพันธ์
        $absolute_path = public_path().'/'.$upload_to; // path แท้จริง

        // upload file
        $f->move($absolute_path, $f->getClientOriginalName()); //อ่านจากเครื่องเจ้าหน้าที่ มาใน path แท้จริง'
        $product->image_url = $relative_path;

        $product->save();

        return redirect('product')
        ->with('ok', 'True')
        ->with('msg', 'บันทึกข้อมูลเรียบร้อยแล้ว');


    }

    public function remove($id) {
        Product::find($id)->delete();
        return redirect('product')
        ->with('ok', 'True')
        ->with('msg', 'ลบข้อมูลเรียบร้อยแล้ว');

    }
}