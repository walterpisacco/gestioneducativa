<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\SchoolSession;
use App\Interfaces\UserInterface;
use App\Repositories\NoticeRepository;
use App\Interfaces\SchoolClassInterface;
use App\Interfaces\SchoolSessionInterface;
use App\Repositories\AttendanceRepository;
use App\Repositories\PromotionRepository;
use Carbon\Carbon;

class HomeController extends Controller
{
    use SchoolSession;
    protected $schoolSessionRepository;
    protected $schoolClassRepository;
    protected $userRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        UserInterface $userRepository, SchoolSessionInterface $schoolSessionRepository, SchoolClassInterface $schoolClassRepository)
    {
        // $this->middleware('auth');
        $this->userRepository = $userRepository;
        $this->schoolSessionRepository = $schoolSessionRepository;
        $this->schoolClassRepository = $schoolClassRepository;
    }

    public function privacidad()
    {
        return view('privacidad');
    }

    public function condiciones()
    {
        return view('condiciones');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $current_school_session_id = $this->getSchoolCurrentSession();

        $classCount             = $this->schoolClassRepository->getAllBySession($current_school_session_id)->count();

        $studentCount           = $this->userRepository->getAllStudentsBySessionCount($current_school_session_id);

        $studentClassCount      = $this->userRepository->getAllStudentsByClassCount($current_school_session_id);


        $day = Carbon::now()->format('Y-m-d');

        $attendanceRepository   = new AttendanceRepository();
        $studentAttendance      = $attendanceRepository->getAllAttendanceByDay($current_school_session_id, $day);

        $dataClases = [];
        foreach($studentClassCount as $class){
            $dataClases['label'][] = $class->class;
            $dataClases['data'][]  = $class->cantidad;
        }
        $clasesChart           = json_encode($dataClases);

        $promotionRepository    = new PromotionRepository();
        $maleStudentsBySession  = $promotionRepository->getMaleStudentsBySessionCount($current_school_session_id);

        $teacherCount           = $this->userRepository->getAllTeachers()->count();
        $directivosCount        = $this->userRepository->getAllDirectivos()->count();
        $preceptoresCount       = $this->userRepository->getAllPreceptores()->count();
        $administrativosCount   = $this->userRepository->getAllAdministrativos()->count();

        $noticeRepository = new NoticeRepository();
        $user_id = auth()->user()->id;
        $notices = $noticeRepository->getAll($current_school_session_id,$user_id);


        $dataAlumnos = [];
        $dataAlumnos['label'][] ='mujeres';
        $dataAlumnos['label'][] ='varones';
        $dataAlumnos['data'][]  = $studentCount - $maleStudentsBySession;
        $dataAlumnos['data'][]  = $maleStudentsBySession;
        $alumnosChart           = json_encode($dataAlumnos);

        $dataAdministrativos            = [];
        $dataAdministrativos['label'][] ='directivos';
        $dataAdministrativos['label'][] ='profesores';
        $dataAdministrativos['label'][] ='Preceptores';
        $dataAdministrativos['label'][] ='Administrativos';
        $dataAdministrativos['data'][]  = $directivosCount;
        $dataAdministrativos['data'][]  = $teacherCount;
        $dataAdministrativos['data'][]  = $preceptoresCount;
        $dataAdministrativos['data'][]  = $preceptoresCount;
        $administrativosChart           = json_encode($dataAdministrativos);

        
        $dataPresentismo = [];
        $cantidadConsultados = 0;

        $dataPresentismo['label'][0] ='Presentes';
        $dataPresentismo['data'] [0]  = 0; 
        $dataPresentismo['label'][1] ='Llegada Tarde';
        $dataPresentismo['data'] [1]  = 0;
        $dataPresentismo['label'][2] ='Ausentes';
        $dataPresentismo['data'] [2]  = 0; 
        $dataPresentismo['label'][3] ='Sin Controlar';
        $dataPresentismo['data'] [3]  = 0;

        foreach($studentAttendance as $attendance){
            switch($attendance->status){
            case 'on':
                $dataPresentismo['label'][0] ='Presentes';
                $dataPresentismo['data'] [0]  = $attendance->cantidad; 
                break;    
            case 'tarde':
                $dataPresentismo['label'][1] ='Llegada Tarde';
                $dataPresentismo['data'] [1]  = $attendance->cantidad; 
                break;
            case 'off':
                $dataPresentismo['label'][2] ='Ausentes';
                $dataPresentismo['data'] [2]  = $attendance->cantidad; 
                break;
            }       
            $cantidadConsultados = $cantidadConsultados + $attendance->cantidad;        
        }

            $dataPresentismo['label'][3] ='Sin Controlar';
            $dataPresentismo['data'] [3]  = $studentCount - $cantidadConsultados;

       
        $presentismoChart           = json_encode($dataPresentismo);        

        $data = [
            'AlumnosCant'       => $studentCount,
            'classCount'        => $classCount,
            'notices'           => $notices,
            'dataAlumnos'       => $alumnosChart,
            'dataAdmin'         => $administrativosChart,
            'dataClases'        => $clasesChart,
            'dataPresentismo'   => $presentismoChart,
        ];

        return view('home', $data);
    }
}
