<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\StudentAcademicInfo;
use App\Models\User;
use App\Repositories\MarkRepository;
use Illuminate\Http\Request;
use App\Traits\SchoolSession;
use App\Interfaces\SchoolSessionInterface;


class StudentAcademicInfoController extends Controller
{
    use SchoolSession;

    protected $schoolSessionRepository;
    
    public function __construct(
        SchoolSessionInterface $schoolSessionRepository,
    ) {
        $this->schoolSessionRepository = $schoolSessionRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function showStudentBoletin(Request $request){

        if(isset($request->id)){
            $request->session()->put('student_id', $request->id);
        }
        $student_id = $request->session()->get('student_id');
        $current_school_session_id = $this->getSchoolCurrentSession();

        $alumno = User::where('id',$student_id)->first();

        $markRepository = new MarkRepository();
        $marks = $markRepository->getAllMarksByStudentId($current_school_session_id, $student_id);

        $coursesCant = $markRepository->getAllCoursesByStudentId($current_school_session_id, $student_id);
        $coursesApro = $markRepository->getExamenesAprobadosCant($current_school_session_id, $student_id);
        $coursesDesapro = $markRepository->getExamenesDesaprobadosCant($current_school_session_id, $student_id);
        $coursesAusente = $markRepository->getExamenesAusenteCant($current_school_session_id, $student_id);
        
        $dataNotas[0]  = $coursesApro[0];
        $dataNotas[1] = $coursesDesapro[0];
        $dataNotas[2]  = $coursesAusente[0];

        $dataMarks = [];
        $cantidad = 1; 
        $i = 0;

        for ($x = 0; $x <= $coursesCant; $x++) {
            $dataMarks['label'][] = 'Examen '.$x;
        }
        

        if(count($marks)>0){
            $materia = $marks[0]->course->course_name;
            $dataMarks['dataset'][$i]['label']  = $materia;
        }


        foreach($marks as $mark){
            $cantidad++;
            $nota = $mark->marks;

            if($nota > 0){
                if($materia == $mark->course->course_name){
                    $color = rand(0,255).', '.rand(0,255).', '.rand(0,255);
                    $dataMarks['dataset'][$i]['borderColor']  = 'rgb('.$color.')';
                    $dataMarks['dataset'][$i]['backgroundColor']  = 'rgba('.$color.', 0.5)';
                    $dataMarks['dataset'][$i]['data'][]  = $nota;
                }else{
                    $i++;
                    $materia = $mark->course->course_name;
                    $dataMarks['dataset'][$i]['label']  = $materia;
                    $dataMarks['dataset'][$i]['borderColor']  = 'rgb(255, 99, 132)';
                    $dataMarks['dataset'][$i]['backgroundColor']  = 'rgba(255, 99, 132, 0.5)';
                    $dataMarks['dataset'][$i]['data'][]  = $nota;                
                }
            }
        }

        $marks = json_encode($dataMarks);  
        
        $data = [
            'student'=> $alumno,
            'marks' => $marks,
            'notas' => $dataNotas,
        ];

        return view('students.boletin',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentAcademicInfo  $studentAcademicInfo
     * @return \Illuminate\Http\Response
     */
    public function show(StudentAcademicInfo $studentAcademicInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentAcademicInfo  $studentAcademicInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentAcademicInfo $studentAcademicInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentAcademicInfo  $studentAcademicInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentAcademicInfo $studentAcademicInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentAcademicInfo  $studentAcademicInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentAcademicInfo $studentAcademicInfo)
    {
        //
    }
}
