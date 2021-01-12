<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function get()
    {
        return view('products');
    }
    

    public function register(Request $request){
        $products = new Product;

            $products->name=$request->name;
            $products->price=$request->price;
            $products->stock=$request->stock;
            $products->save();
            toastr()->success('El producto '.$products->name.', se registro correctamente.');
            return back();
                
    }

    public function edit(Request $request,$id){
        $products = Product::find($id);
     
       
        $products->name=$request->name;
        $products->price=$request->price;
        $products->stock=$request->stock;
        
        if($products->save()){
            toastr()->success('El producto '.$products->name.', se edito correctamente.');
            return back();
        }
   
    }

    public function list(){
        $products = DB::table('products')->get();

        return $products;
    }
    public function delete($id){
       $products= Product::find($id);
       $products->delete();
       return 200;
    }
}
