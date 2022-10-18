<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SchoolRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
   public function create(Request $request){
        $schoolRep = new SchoolRepository();
        $id = $schools = $schoolRep->create($request->all());

        $result = array();
        $result['success'] = 'true';
        $result['id']       =  $id;
        $result['texto'] = 'Escuela creada con éxito!';
        
        return json_encode($result);        
   }

   public function list(){

    $schoolRep = new SchoolRepository();
    $schools = $schoolRep->getAll();

    $data = [
    'schools' => $schools,
    ];

    return view('schools.index',$data);
   }

   public function createAdmin(Request $request){
        try {
           $validator = Validator::make($request->all(), [
               'email'             => 'required|string|email|max:255|unique:users',
               'password'          => 'required|string|min:8',
           ]);

          $mensaje = '';
           if ($validator->fails()) {
               $result = array();
               $result['success'] = 'false';

              foreach($validator->errors()->getMessages() as $m => $key):
                   $mensaje = $mensaje.$key[0];
              endforeach;

              $result['texto'] = $mensaje;
               return json_encode($result);   
           }

           $userRep = new UserRepository();
          $id = $userRep->createAdmin($request->all());

          $result = array();
          $result['success'] = 'true';
          $result['id']       =  $id;
          $result['texto'] = 'Administrador creado con éxito!';
          
          return json_encode($result);   

        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
  

   }

}
