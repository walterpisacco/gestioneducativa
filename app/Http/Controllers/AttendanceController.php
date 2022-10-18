<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Interfaces\UserInterface;
use App\Interfaces\SchoolClassInterface;
use App\Interfaces\SchoolSessionInterface;
use App\Interfaces\AcademicSettingInterface;
use App\Http\Requests\AttendanceStoreRequest;
use App\Interfaces\SectionInterface;
use App\Repositories\AttendanceRepository;
use App\Repositories\CourseRepository;
use App\Traits\SchoolSession;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    use SchoolSession;
    protected $academicSettingRepository;
    protected $schoolSessionRepository;
    protected $schoolClassRepository;
    protected $sectionRepository;
    protected $userRepository;

    public function __construct(
        UserInterface $userRepository,
        AcademicSettingInterface $academicSettingRepository,
        SchoolSessionInterface $schoolSessionRepository,
        SchoolClassInterface $schoolClassRepository,
        SectionInterface $sectionRepository
    ) {
        $this->middleware(['can:view attendances']);

        $this->userRepository = $userRepository;
        $this->academicSettingRepository = $academicSettingRepository;
        $this->schoolSessionRepository = $schoolSessionRepository;
        $this->schoolClassRepository = $schoolClassRepository;
        $this->sectionRepository = $sectionRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return back();
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->query('class_id') == null){
            return abort(404);
        }
        try{
            $academic_setting = $this->academicSettingRepository->getAcademicSetting();
            $current_school_session_id = $this->getSchoolCurrentSession();

            $class_id = $request->query('class_id');
            $section_id = $request->query('section_id', 0);
            $course_id = $request->query('course_id');

            $student_list = $this->userRepository->getAllStudents($current_school_session_id, $class_id, $section_id);

            $school_class = $this->schoolClassRepository->findById($class_id);
            $school_section = $this->sectionRepository->findById($section_id);

            $school_classes = $this->schoolClassRepository->getAllBySession($current_school_session_id);

            $attendanceRepository = new AttendanceRepository();

            $fecha = Carbon::today();
            if($academic_setting->attendance_type == 'section') {
                $attendance_count = $attendanceRepository->getSectionAttendance($class_id, $section_id, $current_school_session_id,$fecha)->count();
            } else {
                $attendance_count = $attendanceRepository->getCourseAttendance($class_id, $course_id, $current_school_session_id,$fecha)->count();
            }

            $data = [
                'current_school_session_id' => $current_school_session_id,
                'academic_setting'  => $academic_setting,
                'student_list'      => $student_list,
                'school_class'      => $school_class,
                'school_section'    => $school_section,
                'attendance_count'  => $attendance_count,
                'school_classes'    => $school_classes,
            ];

            return view('attendances.take', $data);
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\AttendanceStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $current_school_session_id = $this->getSchoolCurrentSession();

           $data = $request->all(); 

           $presentes = (json_decode($data['asistencia']));

           foreach($presentes as $presente){
                if($presente->name == 'student_ids[]') {
                    $data['student_ids'][] = $presente->value;
                }else{
                    $data['status'][$presente->name] = $presente->value;
                }
           }
/*
            $this->validate($data, [
                'fecha'                 => 'date|required',
                'course_id'             => 'integer',
                'class_id'              => 'integer',
                'section_id'            => 'integer',
                'student_ids'           => 'required|array|min:1',
                'student_ids.*'         => 'integer',
                'status'                => 'required|array|min:1',
            ],
            // second array of validation messages can be passed here
            [
                'fecha.required' => 'Por favor seleccione una fecha!',
            ]);
*/
            $class_id   = $request->class_id;
            $section_id = $request->section_id;
            $fecha      = $request->fecha;


            $attendanceRepository = new AttendanceRepository();

            $attendances = $attendanceRepository->getSectionAttendance($class_id, $section_id, $current_school_session_id, $fecha);
            
            $result = array();
            $result['success'] = 'false';

            if(count($attendances) > 0){
                $result['success'] = 'false';
                $result['texto'] = 'Ya se ha tomado asistencia para este curso';
              return json_encode($result);
            }else{
                $attendanceRepository->saveAttendance($data);
                $result['success'] = 'true';
                $result['texto'] = 'Asistencia guardada con éxito!';
            }
            return json_encode($result);

        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->query('class_id') == null){
            return abort(404);
        }

        $current_school_session_id = $this->getSchoolCurrentSession();

        $class_id = $request->query('class_id');
        $section_id = $request->query('section_id');
        $course_id = $request->query('course_id');

        $attendanceRepository = new AttendanceRepository();

        try {
            $academic_setting = $this->academicSettingRepository->getAcademicSetting();

            $fecha = Carbon::today();
            
            if($academic_setting->attendance_type == 'section') {
                $attendances = $attendanceRepository->getSectionAttendance($class_id, $section_id, $current_school_session_id,$fecha);
            } else {
                $attendances = $attendanceRepository->getCourseAttendance($class_id, $course_id, $current_school_session_id);
            }
            $data = ['attendances' => $attendances];
            
            return view('attendances.view', $data);
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function showStudentAttendance($id) {
        $current_school_session_id = $this->getSchoolCurrentSession();
        $attendanceRepository = new AttendanceRepository();
        $attendances = $attendanceRepository->getStudentAttendance($current_school_session_id, $id);
        $student = $this->userRepository->findStudent($id);

        $data = [
            'attendances'   => $attendances,
            'student'       => $student,
        ];

        return view('attendances.attendance', $data);
    }

    public function tomar(Request $request)
    {
        try{
            $academic_setting = $this->academicSettingRepository->getAcademicSetting();
            $current_school_session_id = $this->getSchoolCurrentSession();

            $class_id = $request->query('class_id');
            $section_id = $request->query('section_id', 0);
            $course_id = $request->query('course_id');

            $student_list = $this->userRepository->getAllStudents($current_school_session_id, $class_id, $section_id);

            foreach($student_list as $student){
                if($student->student->photo == null){
                    $student->student->photo = default_image();
                }
            }

            $school_class = $this->schoolClassRepository->findById($class_id);
            $school_section = $this->sectionRepository->findById($section_id);

            $school_classes = $this->schoolClassRepository->getAllBySession($current_school_session_id);

            $attendanceRepository = new AttendanceRepository();

             $fecha = Carbon::today();

            if($academic_setting->attendance_type == 'section') {
                $attendance_count = $attendanceRepository->getSectionAttendance($class_id, $section_id, $current_school_session_id,$fecha)->count();
            } else {
                $attendance_count = $attendanceRepository->getCourseAttendance($class_id, $course_id, $current_school_session_id)->count();
            }

            $data = [
                'current_school_session_id' => $current_school_session_id,
                'academic_setting'  => $academic_setting,
                'student_list'      => $student_list,
                'school_class'      => $school_class,
                'school_section'    => $school_section,
                'attendance_count'  => $attendance_count,
                'school_classes'    => $school_classes,
            ];

            return view('attendances.tomar', $data);
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }    

    public function asistencia(Request $request)
    {
        try{

            $academic_setting = $this->academicSettingRepository->getAcademicSetting();
            $current_school_session_id = $this->getSchoolCurrentSession();

            $class_id = $request->query('class_id');
            $section_id = $request->query('section_id', 0);
            $course_id = $request->query('course_id');


            $student_list = $this->userRepository->getAllStudents($current_school_session_id, $class_id, $section_id);

            foreach($student_list as $student){
                if($student->student->photo == null){
                    $student->student->photo = default_image();
                }
            }

            $school_class = $this->schoolClassRepository->findById($class_id);
            $school_section = $this->sectionRepository->findById($section_id);

            $school_classes = $this->schoolClassRepository->getAllBySession($current_school_session_id);

            $attendanceRepository = new AttendanceRepository();

            $fecha = Carbon::today();

            if($academic_setting->attendance_type == 'section') {

                $attendance_count = $attendanceRepository->getSectionAttendance($class_id, $section_id, $current_school_session_id, $fecha)->count();
            } else {

                $attendance_count = $attendanceRepository->getCourseAttendance($class_id, $course_id, $current_school_session_id, $fecha)->count();
            }

            $data = [
                'current_school_session_id' => $current_school_session_id,
                'academic_setting'  => $academic_setting,
                'student_list'      => $student_list,
                'school_class'      => $school_class,
                'school_section'    => $school_section,
                'attendance_count'  => $attendance_count,
                'school_classes'    => $school_classes,
            ];

            return $data;
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    } 

    public function modificar(Request $request){
        try{

            $asistencia = Attendance::where('id','=',$request->id)->first();
            $asistencia->status = $request->valor;
            $asistencia->save();
            
            return back()->with('status', 'Asistencia guardada con éxito!');


        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    } 

}
