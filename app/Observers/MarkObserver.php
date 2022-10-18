<?php

namespace App\Observers;

use App\Models\Mark;
use App\Models\User;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\Notification;

class MarkObserver
{
    /**
     * Handle the Mark "created" event.
     *
     * @param  \App\Models\Mark  $mark
     * @return void
     */
    public function created(Mark $mark)
    {

        if($mark->marks > 0) {

            $destinatarios = User::
                 whereNull('deleted_at')
                ->where('id', $mark->student_id)
                ->first();

            $noticia = 'Tenemos buenas noticias para ti '.$destinatarios->first_name.'!!, el examen de '.$mark->course->course_name.' ha sido calificado.';
            $noticia .= ' La nota obtenida fué: '.$mark->marks;
            $escuela = auth()->user()->escuela->name;

            $mailData = [
                'body' => $noticia,
                //'text' => $texto,
                'url'  => url('/'),
                'thankyou' => 'Gracias, '.auth()->user()->first_name.' '.auth()->user()->last_name.'.',
                'escuela' => $escuela
            ];

            $respuesta = Notification::send($destinatarios,new InvoicePaid($mailData));
        
        }
    }

    /**
     * Handle the Mark "updated" event.
     *
     * @param  \App\Models\Mark  $mark
     * @return void
     */
    public function updated(Mark $mark)
    {
        //
    }

    /**
     * Handle the Mark "deleted" event.
     *
     * @param  \App\Models\Mark  $mark
     * @return void
     */
    public function deleted(Mark $mark)
    {
        //
    }

    /**
     * Handle the Mark "restored" event.
     *
     * @param  \App\Models\Mark  $mark
     * @return void
     */
    public function restored(Mark $mark)
    {
        //
    }

    /**
     * Handle the Mark "force deleted" event.
     *
     * @param  \App\Models\Mark  $mark
     * @return void
     */
    public function forceDeleted(Mark $mark)
    {
        //
    }
}
