<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sons extends Model
{
    use HasFactory;

    protected $fillable = [
        'padre_id',
        'hijo_id',
    ];

    /**
     */
    public function padre()
    {
        return $this->belongsTo(User::class, 'padre_id');
    }

    /**
     */
    public function alummno() {
        return $this->belongsTo(User::class, 'hijo_id');
    }

}
