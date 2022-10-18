<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\SchoolSession;
use App\Interfaces\UserInterface;
use App\Interfaces\SectionInterface;
use App\Interfaces\SchoolClassInterface;
use App\Repositories\PromotionRepository;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\AdministrativeStoreRequest;
use App\Interfaces\SchoolSessionInterface;
use App\Repositories\StudentParentInfoRepository;
use App\Models\User;
use App\Models\Promotion;
use App\Models\TypeNationality;
use App\Http\Requests\PadreStoreRequest;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use SchoolSession;
    protected $userRepository;
    protected $schoolSessionRepository;
    protected $schoolClassRepository;
    protected $schoolSectionRepository;

    public function __construct(UserInterface $userRepository, SchoolSessionInterface $schoolSessionRepository,
    SchoolClassInterface $schoolClassRepository, SectionInterface $schoolSectionRepository)
    {
        $this->middleware(['can:view users']);

        $this->userRepository = $userRepository;
        $this->schoolSessionRepository = $schoolSessionRepository;
        $this->schoolClassRepository = $schoolClassRepository;
        $this->schoolSectionRepository = $schoolSectionRepository;
    }

    public function getStudentList(Request $request) {
        $current_school_session_id = $this->getSchoolCurrentSession();
        $class_id = $request->query('class_id', 0);
        $section_id = $request->query('section_id', 0);

        try{
            $school_classes = $this->schoolClassRepository->getAllBySession($current_school_session_id);
            $studentList = $this->userRepository->getAllStudents($current_school_session_id, $class_id, $section_id);
           // dd($studentList );
            foreach($studentList as $student){
                if($student->student->photo == null){
                    $student->student->photo = default_image();
                }
            }            

        $data = [
            'studentList'       => $studentList,
            'school_classes'    => $school_classes,
        ];

        return view('students.list', $data);
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

        public function getStudentLegajo(Request $request) {
        $current_school_session_id = $this->getSchoolCurrentSession();
        $class_id = $request->query('class_id', 0);
        $section_id = $request->query('section_id', 0);

        try{
            $school_classes = $this->schoolClassRepository->getAllBySession($current_school_session_id);
            $studentList = $this->userRepository->getAllStudents($current_school_session_id, $class_id, $section_id);

            foreach($studentList as $student){
                if($student->student->photo == null){
                    $student->student->photo = default_image();
                }
            }            

        $data = [
            'studentList'       => $studentList,
            'school_classes'    => $school_classes,
        ];

        return view('students.legajo', $data);
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function showStudentProfile($id) {
        $student = $this->userRepository->findStudent($id);

        $current_school_session_id = $this->getSchoolCurrentSession();
        $promotionRepository = new PromotionRepository();
        $promotion_info = $promotionRepository->getPromotionInfoById($current_school_session_id, $id);

        $data = [
            'student'           => $student,
            'promotion_info'    => $promotion_info,
        ];

        return view('students.profile', $data);
    }

    public function createStudent() {
        $current_school_session_id = $this->getSchoolCurrentSession();

        $school_classes = $this->schoolClassRepository->getAllBySession($current_school_session_id);
        $nacionalidades = TypeNationality::All();

        $data = [
            'current_school_session_id' => $current_school_session_id,
            'school_classes'            => $school_classes,
            'nacionalidades'            => $nacionalidades,
        ];

        return view('students.add', $data);
    }

    public function storeStudent(Request $request){
        try {
            $data = $request->all();
            $campos = (json_decode($data['data']));

            //dd($campos);
            $data['_token'] = $campos[0]->value;
            $data['id_card_number'] = $campos[1]->value;
            $data['document'] = $campos[2]->value;
            $data['first_name'] = $campos[3]->value;
            $data['last_name'] = $campos[4]->value;
            $data['email'] = $campos[5]->value;
            $data['password'] = $campos[6]->value;
            $data['photo'] = $campos[7]->value;
            $data['birthday'] = $campos[8]->value;
            $data['gender'] = $campos[9]->value;
            $data['nationality'] = $campos[10]->value;            
            $data['address'] = $campos[11]->value;
            $data['address2'] = $campos[12]->value;
            $data['city'] = $campos[13]->value;
            $data['zip'] = $campos[14]->value;
            $data['phone'] = $campos[15]->value;
            $data['blood_type'] = $campos[16]->value;
            $data['religion'] = $campos[17]->value;
            $data['father_document'] = $campos[18]->value;
            $data['father_name'] = $campos[19]->value;
            $data['father_last_name'] = $campos[20]->value;
            $data['father_phone'] = $campos[21]->value;
            $data['father_email'] = $campos[22]->value;
            $data['father_notify'] = $campos[23]->value;
            $data['father_nationality'] = $campos[24]->value;
            $data['parent_address'] = $campos[25]->value;
            $data['class_id'] = $campos[26]->value;
            $data['section_id'] = $campos[27]->value;
            $data['board_reg_no'] = $campos[28]->value;
            $data['session_id'] = $campos[29]->value;

            $validator = Validator::make($data, [
                'document'          => 'required|string|unique:users',
                'first_name'        => 'required|string',
                'last_name'         => 'required|string',
                'email'             => 'required|string|email|max:255|unique:users',
                'gender'            => 'required|string',
                'nationality'       => 'required|string',
                'phone'             => 'nullable|string',
                'address'           => 'required|string',
                'address2'          => 'nullable|string',
                'city'              => 'required|string',
                'zip'               => 'nullable|string',
                'photo'             => 'nullable|string',
                'birthday'          => 'required|date',
                'religion'          => 'required|string',
                'blood_type'        => 'required|string',
                'password'          => 'required|string|min:8',
                // Parents' information
                'father_document'   => 'nullable|string',
                //'father_name'       => 'required|string',
                //'father_last_name'  => 'required|string',
                //'father_phone'      => 'nullable|string',
                //'father_email'      => 'nullable|string',
                //'father_notify'     => 'nullable|string',
                //'father_nationality'=> 'nullable|string',
                // Academic information
                'class_id'          => 'required',
                'section_id'        => 'required',
                'board_reg_no'      => 'nullable|string',
                'session_id'        => 'string',
                'id_card_number'    => 'nullable|string'
            ]);

            $mensaje = '';
            $result = array();
            if ($validator->fails()) {
                $result['success'] = 'false';

                foreach($validator->errors()->getMessages() as $m => $key):
                   $mensaje = $mensaje.$key[0];
                endforeach;

               $result['texto'] = $mensaje;
               return json_encode($result);   
            }

            $respuesta = $this->userRepository->createStudent($data);

            if($data['father_document'] != '' && $data['father_email'] != ''){
                $this->storePadre($data);
            }

            $result['success'] = 'true';
            $result['id']       =  $id;
            $result['texto'] = 'Alumno creado con éxito!';
          
            return json_encode($result); 

        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

/**************PADRES**********/
    public function storePadre(Request $request){
        try {
            $idPadre = User::where('document','=',$request->father_document)->first();
                        
            if(!isset($idPadre->id)){
                $mailPadre = User::where('email','=',$request->father_email)->first(); 
                    if(!isset($mailPadre)){
                        $this->userRepository->createPadre($request);
                    }else{
                        return back()->withError('El mail del padre ya esta siendo utilizado por otro usuario');
                    }
            }
            
            return back()->with('status', 'Padre creado con éxito!');

        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function editStudent($student_id) {
        $student = $this->userRepository->findStudent($student_id);
        $padre = $this->userRepository->findPadre($student->father_document);
        $studentParentInfoRepository = new StudentParentInfoRepository();
        $parent_info = $studentParentInfoRepository->getParentInfo($student_id);
        $promotionRepository = new PromotionRepository();
        $current_school_session_id = $this->getSchoolCurrentSession();
        $promotion_info = $promotionRepository->getPromotionInfoById($current_school_session_id, $student_id);
        $nacionalidades = TypeNationality::All();

        $data = [
            'student'       => $student,
            'padre'         => $padre,
            'parent_info'   => $parent_info,
            'promotion_info'=> $promotion_info,
            'nacionalidades'=> $nacionalidades,
        ];

        //dd($data);
        return view('students.edit', $data);
    }

    public function updateStudent(Request $request) {
        try {
            $this->userRepository->updateStudent($request->toArray());

            $this->userRepository->updatePadre($request->toArray());

            if($request->father_document != '' && $request->father_email != ''){
                $this->storePadre($request);
            }

            return back()->with('status', 'Alumno actualizado con éxito!');
        } catch (\Exception $e) {
            return back()->withError('Error al intentar actualizar los datos del alumno, verifique que el correo no este siendo utilizado');
        }
    }

    public function deleteStudent(Request $request) {
        try {
            $this->middleware(['can:delete users']);
            $id = $request->id;
            $usuario = User::find($id);

            $usuario->delete();

            $promocion = Promotion::where('student_id',$id)->delete();

            $result = array();
            $result['success'] = 'true';
            $result['texto'] = 'usuario eliminado con éxito!';
            return json_encode($result);

        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }    

}
