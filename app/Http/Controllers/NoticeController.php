<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\SchoolSession;
use App\Repositories\NoticeRepository;
use App\Http\Requests\NoticeStoreRequest;
use App\Interfaces\SchoolSessionInterface;
use Illuminate\Support\Facades\DB;
//use Illuminate\Notifications\Notification;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\Notification;


class NoticeController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $student_id = $request->student_id;
        $current_school_session_id = $this->getSchoolCurrentSession();

        
        $data = [
            'student_id'  => $student_id,
        ];

        return view('notices.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NoticeStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoticeStoreRequest $request)
    {
        try {

        $roles_array = array();
        if(isset($request->directivos_notify)){$roles_array[]='directivo';}
        if(isset($request->admin_notify)){$roles_array[]='administrativo';}
        if(isset($request->preceptores_notify)){$roles_array[]='preceptor';}
        if(isset($request->docentes_notify)){$roles_array[]='teacher';}
        if(isset($request->alumnos_notify)){$roles_array[]='student';} 
        if(isset($request->padres_notify)){$roles_array[]='padre';}  

        if (count($roles_array) == 0 && !isset($request->student_notify) && !isset($request->tutor_notify)){
            return back()->withError('Debe seleccionar un destinatario para comunicar el aviso');
        }

        $current_school_session_id = $this->getSchoolCurrentSession();
        $noticia = $request['notice'];    
        $escuela = auth()->user()->escuela->name;

        $mailData = [
            'body' => $noticia,
            'text' => '',
            'url'  => url('/'),
            'thankyou' => 'Gracias, '.auth()->user()->first_name.' '.auth()->user()->last_name.'.',
            'escuela' => $escuela
        ];

        if(isset($request->student_id)){
            $alumnoColection = User::
                      where('id',$request->student_id)
                    ->whereNull('deleted_at')
                    ->where('school_id', auth()->user()->school_id)
                    ->first();

            if(isset($request->student_notify)){
                //Notification::send($alumnoColection,new InvoicePaid($mailData));

                $aviso_array['notice'] = $noticia;
                $aviso_array['session_id'] = $current_school_session_id;
                $aviso_array['user_id'] = $alumnoColection->id;
                $aviso_array['created_at'] = now();
                $aviso_array['updated_at'] = now(); 
                DB::table('notices')->insert($aviso_array);           
            } 

            if(isset($request->tutor_notify)){
                $tutorColection = User::
                      where('document',$alumnoColection->father_document)
                    ->whereNull('deleted_at')
                    ->where('school_id', auth()->user()->school_id)
                    ->first(); 

                Notification::send($tutorColection,new InvoicePaid($mailData));

                $aviso_array['notice'] = $noticia;
                $aviso_array['session_id'] = $current_school_session_id;
                $aviso_array['user_id'] = $tutorColection->id;
                $aviso_array['created_at'] = now();
                $aviso_array['updated_at'] = now(); 
                DB::table('notices')->insert($aviso_array); 
            }
        }

        if (count($roles_array) > 0){            
            $destinatarios = User::
            whereIn('role', $roles_array)
            ->whereNull('deleted_at')
            ->where('school_id', auth()->user()->school_id)
            ->get();
            // manda mail a los grupos
            Notification::send($destinatarios,new InvoicePaid($mailData));

            $i = 0;
            $aviso_array = array();
            foreach($destinatarios as $item) {
                $aviso_array[$i]['notice'] = $noticia;
                $aviso_array[$i]['session_id'] = $current_school_session_id;
                $aviso_array[$i]['user_id'] = $item->id;
                $aviso_array[$i]['created_at'] = now();
                $aviso_array[$i]['updated_at'] = now();
                $i++;
            };
            //crea los avisos en la plataforma
            DB::table('notices')->insert($aviso_array);            
        }    


        return back()->with('status', 'Aviso creado con éxito!');

        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notice $notice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notice $notice)
    {
        //
    }
}
