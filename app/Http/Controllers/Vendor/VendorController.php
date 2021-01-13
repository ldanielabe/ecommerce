<?php

namespace App\Http\Controllers\Vendor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Vendor_client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function get()
    {
        return view('vendors');
    }
    

    public function register(Request $request){
        $usuario = new User;

            $usuario->identification=$request->identification;
            $usuario->name=$request->name;
            $usuario->address=$request->address;
            $usuario->phone=$request->phone;
            $usuario->email=$request->email;
            if($request->password!=$request->password_confirm){
                toastr()->error('Error, no se registro el vendedor.');
                
            }else{
                $usuario->password=Hash::make($request->password);
                $usuario->save();
                toastr()->success('El vendedor '.$usuario->name.', se registro correctamente.');
                return back();
            }        
    }

    public function edit(Request $request,$id){
        $usuario = User::find($id);
     
       
        $usuario->identification=$request->identification;
        $usuario->name=$request->name;
        $usuario->address=$request->address;
        $usuario->phone=$request->phone;
        $usuario->email=$request->email;
        
        if($usuario->save()){
            toastr()->success('El vendedor '.$usuario->name.', se edito correctamente.');
            return back();
        }
   
    }

    public function list(){
        $usuarios = DB::table('users')->get();

        return $usuarios;
    }
    public function delete($id){
       $vendor= User::find($id);
       $vendor->delete();
       return 200;
    }

    public function assign($id,$client){
        $assign = new Vendor_client;
        $assign->id_user=$id;
        $assign->id_client=$client;
        $assign->save();
        $data = [
            "status" => "200",
        ];
        return response()->json($data);
    }
}
