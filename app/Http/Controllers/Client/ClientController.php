<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Client;
use App\Question_client;
use App\Type_client;
use App\Answers_client;

class ClientController extends Controller
{
    public function get()
    {
        $client=DB::select('SELECT * FROM clients AS c, answers_clients AS a, question_clients AS q WHERE c.id=a.id_client AND q.id=a.id_question');
        $number_client=DB::select('SELECT MAX(id) as max FROM clients')[0]->max;
        $type_clients=DB::select('SELECT * FROM type_clients');
  
        return view('clients.clients',["client"=>$client,"type_clients"=>$type_clients,"number_client"=>$number_client]);
    }


    public function type()
    {
        
       
        return view('clients.type');
    }
    

    public function register(Request $request,$id){
       
        $preguntas=DB::select('SELECT * FROM question_clients AS prg WHERE prg.id_type='.$id); 
        $id_client=DB::select('SELECT MAX(id) as max FROM clients'); 
        $array=$request->request->all();
        $client = new Client;
        $client->id_type=$id;
        $client->name=$id;
        $client->save();
        
       
     
        for($i=2;$i<sizeof($request->request);$i++){

            DB::table('answers_clients')->insert([
                'answer'=>array_values($array)[$i],
                'id_question'=>$preguntas[$i-2]->id,
                'id_client'=>$id_client[0]->max
            ]);
        }

      
         toastr()->success('Se registro correctamente.');
        
      
      return back();
      //return response()->json($answer);    
    }

    public function type_register(Request $request){
        $type = new Type_client;
            $type->name=$request->name;
         
            if($type->save()){
                toastr()->success('El tipo '.$type->name.', se registro correctamente.');
                return back();
                
            }else{
                toastr()->error('Error, no se registro el vendedor.');
                
            }        
    }


    public function question_register($id,$preguntas)
    {
      
        $data = ["status" => "500"];

        if($preguntas!="1"){
            DB::table('question_clients')->insert([
                'question'=>urldecode($preguntas),
                'id_type'=>$id
            ]);
            $data = [
                "status" => "200",
            ];
        }
      
        return response()->json($data);
    }


    public function edit(Request $request,$id){
        $usuario = Client::find($id);
        $array=$request->request->all();
        $preguntas=DB::select('SELECT * FROM question_clients AS prg WHERE prg.id_type='.$usuario->id_type); 
       
       
     
        for($i=2;$i<sizeof($request->request);$i++){

            DB::table('answers_clients')->update([
                'answer'=>array_values($array)[$i]
            ]);
        }
 
        if($usuario->save()){
            toastr()->success('El cliente '.$usuario->name.', se edito correctamente.');
            return back();
        }

        

   
    }

    public function question_edit($id,$preguntas){
        $data = ["status" => "500"];

        if($preguntas!=""||$preguntas!=null){
           
            DB::table('question_clients')->where('id',$id)->update(['question'=>urldecode($preguntas)]);
           
            $data = [
                "status" => "200",
            ];
        }
      
       
        return response()->json($data);
    }

    public function type_edit(Request $request,$id){
        $usuario = Type_client::find($id);
        $usuario->name=$request->name;
        
        if($usuario->save()){
            toastr()->success('El tipo '.$usuario->name.', se edito correctamente.');
            return back();
        }
   
    }

    public function list(){
        $client=DB::select('SELECT * FROM clients AS c, answers_clients AS a WHERE a.id_client=c.id');
        $id_client=DB::select('SELECT MAX(id) as max FROM clients')[0]->max; 

        $data = [
            "status" => "200",
            "client" => $client,
            "id_client"=>$id_client
        ];
        
        return  response()->json($data);
    }

    public function type_list(){
        $type = DB::table('type_clients')->get();
        return $type;
    }


    public function question_list($id,$bol)
    { 

        if($bol==1){
            $id=DB::select('SELECT prg.id_type FROM question_clients AS prg WHERE prg.id='.$id);
        }
      
        $preguntas=DB::select('SELECT * FROM question_clients AS prg WHERE prg.id_type='.$id);
       
        $data = [
            "status" => "200",
            "preguntas" => $preguntas
        ];
        
        return response()->json($data);
    }

    public function delete($id){
       $vendor= User::find($id);
       $vendor->delete();
       return 200;
    }

    public function question_delete($id){
        $vendor= Question_client::find($id);
        $vendor->delete();
        return 200;
     }

    public function type_delete($id){
        $type= Type_client::find($id);
        $type->delete();
        return 200;
     }

     public function all_question_client($id){
        $question=DB::select('SELECT * FROM question_clients AS q, type_clients AS t WHERE t.id=q.id_type AND q.id_type='.$id);
    
        return response()->json($question);
    } 
}
