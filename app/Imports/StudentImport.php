<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Promotion;
use App\Models\StudentParentInfo;
//use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
/*
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
*/
//class StudentImport implements ToModel
class StudentImport implements ToCollection
{
    public $class_id;
    public $section_id;
    public $session_id;
        
    public function __construct($class_id,$section_id,$session_id)
    {
        $this->class_id = $class_id;
        $this->section_id = $section_id;
        $this->session_id = $session_id;
    }

     public function collection(Collection $rows)
    {
         Validator::make($rows->toArray(), [
             '*.1' => 'required',
         ])->validate();

            foreach ($rows as $row) {
                if($row[0]=='Alumno'){
                    if($row[6]=='F'){$sexo = 'Hombre';}else{$sexo = 'Mujer';}
                    $user= User::create([
                            'school_id'         =>  auth()->user()->school_id,
                            'document'          =>  $row[2],
                            'first_name'        =>  $row[3],
                            'last_name'         =>  $row[4],
                            'email'             =>  $row[5],
                            'role'              =>  'student',
                            'gender'            =>  $sexo ,
                            'nationality'       =>  1,
                            'photo'             =>  '/photos/profile.png',
                            'birthday'          =>  $row[7],
                            'religion'          =>  'Cristiana',
                            'father_document'   =>  $row[12],
                            'password'          =>  Hash::make($row[2])
                        ]);
                    $lastInsertedId= $user->id;

                    $user->givePermissionTo(
                        'view menu dashboard',
                        'view attendances',
                        'view marks',
                        'view users',
                        'view routines',
                        'view syllabi',
                        'view events',
                        'view notices',
                        'view menu examenes',
                        'view menu misasignaturas',
                        'view menu miasistencia',
                        'view menu mishorarios'
                    );
                    Promotion::create([
                        'student_id'        =>  $lastInsertedId,
                        'class_id'          =>  $this->class_id,
                        'section_id'        =>  $this->section_id,
                        'session_id'        =>  $this->session_id,
                        'id_card_number'    =>  $row[1],
                    ]);
                    StudentParentInfo::create([
                        'student_id'        =>  $lastInsertedId,
                        'father_name'       =>  $row[8],
                        'father_last_name'  =>  $row[9],
                        'father_phone'      =>  $row[10],
                        'father_email'      =>  $row[11],
                        'father_notify'     =>  1,
                        'gender'            =>  'Hombre',
                    ]);                    
                }
            }

            foreach ($rows as $row) {
                if($row[0]=='Alumno'){
                    $idPadre = User::where('document','=',$row[12])->first();
                    if(!isset($idPadre->id)){
                        $mailPadre = User::where('email','=',$row[11])->first(); 
                        if(!isset($mailPadre)){
                            $user= User::create([
                                'school_id'         =>  auth()->user()->school_id,
                                'document'          =>  $row[12],
                                'first_name'        =>  $row[8],
                                'last_name'         =>  $row[9],
                                'email'             =>  $row[11],
                                'role'              =>  'padre',
                                'nationality'       =>  1,
                                'photo'             =>  '/photos/profile.png',
                                'religion'          =>  'Cristiana',
                                'father_document'   =>  0,
                                'password'          =>  Hash::make($row[2])
                            ]);
                        }else{
                            return back()->withError('El mail del padre ya esta siendo utilizado por otro usuario');
                        }
                    }
                }
            }
    }
}
