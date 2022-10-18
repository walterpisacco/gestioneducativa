<?php

namespace App\Models;

use App\Models\Mark;
use App\Models\Attendance;
use App\Models\StudentParentInfo;
use App\Models\StudentAcademicInfo;
use App\Models\Notice;
use App\Models\Sons;
use App\Models\AssignedTeacher;
use App\Models\Course;
use App\Models\Promotion;
use App\Models\TypeNationality;
use App\Models\School;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
//use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasRoles, HasFactory, Notifiable;

    use HasApiTokens;
    use HasFactory;
    //use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school_id',
        'document',
        'first_name',
        'last_name',
        'email',
        'password',
        'gender',
        'nationality',
        'phone',
        'address',
        'address2',
        'city',
        'zip',
        'photo',
        'birthday',
        'religion',
        'blood_type',
        'role',
        'father_document',
        'social_id',
        'social_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',        
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

/*
    protected $appends = [
        'profile_photo_url',
    ];    
*/

    /**
     * Get promocion.
     */
    public function promotion()
    {
        return $this->hasOne(Promotion::class, 'student_id', 'id');
    }  

    /**
     * Get promocion.
     */
    public function asignaciones()
    {
        return $this->hasMany(AssignedTeacher::class, 'teacher_id', 'id');
    }      

    /**
     * Get the parent_info.
     */
    public function parent_info()
    {
        return $this->hasOne(StudentParentInfo::class, 'student_id', 'id');
    }

    /**
     * Get the academic_info.
     */
    public function academic_info()
    {
        return $this->hasOne(StudentAcademicInfo::class, 'student_id', 'id');
    }

    /**
     * Get the marks.
     */
    public function marks()
    {
        return $this->hasMany(Mark::class, 'student_id', 'id');
    }

    /**
     * Get the marks.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id', 'id');
    }


    public function noticia()
    {
        return $this->hasMany(Notice::class,'user_id','id');
    }


    public function alumnos()
    {
            return $this->hasManyThrough('App\Models\User', 'App\Models\Sons');
    }

    public function cursos()
    {
            return $this->hasManyThrough('App\Models\AssignedTeacher', 'App\Models\Course');
    }

    /**
     * Get the academic_info.
     */
    public function nacionalidad()
    {
        return $this->hasOne(TypeNationality::class, 'id', 'nationality');
    }

    /**
     * Get the academic_info.
     */
    public function escuela()
    {
        return $this->hasOne(School::class, 'id', 'school_id');
    }    

}
