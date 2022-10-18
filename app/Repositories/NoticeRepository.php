<?php

namespace App\Repositories;

use App\Models\Notice;

class NoticeRepository {
    public function store($aviso) {
        try {

/*
            Notice::create([
                'notice'        => $request['notice'],
                'session_id'    => $request['session_id'],
            ]);
*/
            Notice::create($aviso);
            
        } catch (\Exception $e) {
            throw new \Exception('Error al intentar guardar el aviso. '.$e->getMessage());
        }
    }

    public function getAll($session_id,$user_id) {
        return Notice::where('session_id', $session_id,'and')
                    ->where('user_id',$user_id)
                    ->orderBy('id', 'desc')
                    ->simplePaginate(3);
    }
   
}