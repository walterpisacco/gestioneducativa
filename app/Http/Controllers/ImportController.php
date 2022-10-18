<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Imports\StudentImport;
use App\Imports\TeacherImport;
use App\Models\SchoolSession;

class ImportController extends Controller
{

    public function studentsImportar(Request $request){
        if($request->hasFile('file')){
            $path = $request->file('file')->getRealPath();
            $class_id = $request->class_id;
            $section_id = $request->section_id;
            $session_id =  SchoolSession::where('school_id','=',auth()->user()->school_id)->first();

            $datos =  Excel::import(new StudentImport($class_id,$section_id,$session_id->id),request()->file('file'));

            $result = array();
            $result['success'] = 'true';
            $result['texto'] = 'Importación realizada con éxito!';
            
            return json_encode($result);
        }
    }
    public function teachersImportar(Request $request){
        if($request->hasFile('file')){
            $path = $request->file('file')->getRealPath();
            $session_id =  SchoolSession::where('school_id','=',auth()->user()->school_id)->first();

            $datos =  Excel::import(new TeacherImport($session_id->id),request()->file('file'));

            $result = array();
            $result['success'] = 'true';
            $result['texto'] = 'Importación realizada con éxito!';
            
            return json_encode($result);
        }
    }
}
