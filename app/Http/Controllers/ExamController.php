<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExamStoreRequest;
use App\Models\Exam;
use Illuminate\Http\Request;
use App\Traits\SchoolSession;
use App\Interfaces\SemesterInterface;
use App\Interfaces\SchoolClassInterface;
use App\Interfaces\SchoolSessionInterface;
use App\Repositories\AssignedTeacherRepository;
use App\Repositories\ExamRepository;
use App\Repositories\ExamRuleRepository;

class ExamController extends Controller
{
    use SchoolSession;

    protected $schoolClassRepository;
    protected $semesterRepository;
    protected $schoolSessionRepository;

    public function __construct(SchoolSessionInterface $schoolSessionRepository, SchoolClassInterface $schoolClassRepository, SemesterInterface $semesterRepository)
    {
        $this->schoolSessionRepository = $schoolSessionRepository;
        $this->schoolClassRepository = $schoolClassRepository;
        $this->semesterRepository = $semesterRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $semester_id = $request->query('semester_id', 0);
        $class_id = $request->query('class_id', 0);
        $section_id = $request->query('section_id', 0);

        $current_school_session_id = $this->getSchoolCurrentSession();

        $semesters = $this->semesterRepository->getAll($current_school_session_id);

        $school_classes = $this->schoolClassRepository->getAllBySession($current_school_session_id);

        $examRepository = new ExamRepository();
        $teacher_id = (auth()->user()->role == "teacher")?auth()->user()->id : 0;
        if($teacher_id> 0){
            $exams = $examRepository->getAll($current_school_session_id, $semester_id, $class_id, $section_id);
        }else{
            $exams = $examRepository->getAll($current_school_session_id, $semester_id, $class_id, $section_id);
        } 

        $assignedTeacherRepository = new AssignedTeacherRepository();
        $teacherCourses = $assignedTeacherRepository->getTeacherCourses($current_school_session_id, $teacher_id, $semester_id);

        //dd($exams);

        $data = [
            'current_school_session_id' => $current_school_session_id,
            'semesters'                 => $semesters,
            'classes'                   => $school_classes,
            'exams'                     => $exams,
            'teacher_courses'           => $teacherCourses,
        ];

        return view('exams.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $current_school_session_id = $this->getSchoolCurrentSession();

        $semesters = $this->semesterRepository->getAll($current_school_session_id);

        if(auth()->user()->role == "teacher") {
            $teacher_id = auth()->user()->id;
            $assigned_classes = $this->schoolClassRepository->getAllBySessionAndTeacher($current_school_session_id, $teacher_id);

            $school_classes = [];
            $i = 0;

            foreach($assigned_classes as $assigned_class) {
                $school_classes[$i]['id']           = $assigned_class->id;
                $school_classes[$i]['class_id']   = $assigned_class->schoolClass->id;
                $school_classes[$i]['class_name']   = $assigned_class->schoolClass->class_name;
                $school_classes[$i]['section_name'] = $assigned_class->section->section_name;
                $school_classes[$i]['section_id']   = $assigned_class->section->id;
                $school_classes[$i]['course_name']  = $assigned_class->course->course_name;
                $school_classes[$i]['course_id']    = $assigned_class->course->id;
                $i++;
            }
        } else {
            $school_classes = $this->schoolClassRepository->getAllBySession($current_school_session_id);
        }

        $examRepository = new ExamRepository();
        $teacher_id = (auth()->user()->role == "teacher")?auth()->user()->id : 0;
        $exams = $examRepository->getAllByCourse($current_school_session_id, $teacher_id);
       
        $data = [
            'current_school_session_id' => $current_school_session_id,
            'semesters'                 => $semesters,
            'classes'                   => $school_classes,
            'exams'                     => $exams,
        ];

        return view('exams.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ExamStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamStoreRequest $request)
    {
        try {
             $current_school_session_id = $this->getSchoolCurrentSession();

            $examRepository = new ExamRepository();
            $examRepository->create($request->validated());

            $id = Exam::all()->last()->id;

            $examRuleRepository = new ExamRuleRepository();
            $data = [
                'marks_distribution_note'  => $request->exam_name,
                'pass_marks' => $request->pass_marks,
                'total_marks' => $request->total_marks,
                'session_id' => $current_school_session_id,
                'exam_id' => $id
            ];

            $examRuleRepository->create($data);

            return back()->with('status', 'Exémen creado con éxito!');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();

        return back()->with('success','Se eliminó con éxito!');
    }

}
