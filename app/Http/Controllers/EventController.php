<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Exam;
use Illuminate\Http\Request;
use App\Traits\SchoolSession;
use App\Interfaces\SchoolSessionInterface;

class EventController extends Controller
{
    use SchoolSession;
    protected $schoolSessionRepository;

    public function __construct(SchoolSessionInterface $schoolSessionRepository) {
        $this->schoolSessionRepository = $schoolSessionRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $current_school_session_id = $this->getSchoolCurrentSession();

            $dataEvento = Event::whereDate('start', '>=', $request->start)
                            ->whereDate('end',   '<=', $request->end)
                            ->where('session_id', $current_school_session_id)
                            ->get(['id', 'title', 'start', 'end']);
            $dataEvento->map(function($evento) {
                $evento->color ='blue';
                $evento->description = '* Notificaciones *';
            });
            $data = $dataEvento;
                        

            // ver para los padres como pasarle el id de hijo
            if(auth()->user()->role == "student"){
                $class_id = Auth()->user()->promotion->class_id ?? 0;
                $section_id = Auth()->user()->promotion->section_id ?? 0;

                $dataExamen = Exam::whereDate('start_date', '>=', $request->start)
                                ->whereDate('end_date',   '<=', $request->end)
                                ->where('session_id', $current_school_session_id)
                                ->where('class_id', $class_id)
                                ->where('section_id', $section_id)
                                ->get(['id', 'exam_name as title', 'start_date as start', 'end_date as end']);
                $dataExamen->map(function($examen) {
                    $examen->color ='red';
                    $examen->description = '* Examen *';
                });
                $data = $dataEvento->concat($dataExamen);
            }
            
            $asignacionesArr  = array(); 
            $i = 0;
            if(auth()->user()->role == "teacher"){
                foreach(Auth()->user()->asignaciones as $asignacion)
                {
                    $asignacionesArr[$i] = $asignacion->course_id ?? 0;
                    $i++;
                }

                $dataExamen = Exam::
                                whereDate('start_date', '>=', $request->start)
                                ->whereDate('end_date',   '<=', $request->end)
                                ->where('session_id', $current_school_session_id)
                                ->whereIn('course_id', $asignacionesArr)
                                ->get(['id', 'exam_name as title', 'start_date as start', 'end_date as end']);
                $dataExamen->map(function($examen) {
                    $examen->color ='red';
                    $examen->description = '* Mis Exámenes *';
                });
                $data = $dataEvento->concat($dataExamen);                
            }

            return response()->json($data);
        }
        return view('events.index');
    }

    public function calendarEvents(Request $request)
    {
        $current_school_session_id = $this->getSchoolCurrentSession();
        $event = null;
        switch ($request->type) {
            case 'create':
                $event = Event::create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                    'session_id' => $current_school_session_id
                ]);
                break;
  
            case 'edit':
                $event = Event::find($request->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);
                break;
  
            case 'delete':
                $event = Event::find($request->id)->delete();
                break;
             
            default:
                break;
        }
        dd($event);
        return response()->json($event);
    }
}
