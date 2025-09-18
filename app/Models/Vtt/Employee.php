<?php

namespace App\Models\Vtt;

//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

//class Employee extends Authenticatable
class Employee extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    //Table Name
    protected $table = 'employees';

    // Primary Key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar',
        'signature',
        'employee_no',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'title',
        'maiden_name',
        'full_name',
        'birthday',
        'sex',
        'civil_status',
        'email',
        'mobile_nos',
        'tel_nos',
        'appointment_status',
        'employment_status',

        'department_id',
        'department',
        'dept_code',

        'position_id',
        'position',
        'position_code',

        'section',
        'unit',
        'division',
        'status',
        'preview_id',

        'preview_id',
        'last_login',
        'user_id',

        'appointment_status_id',
        'employment_status_id',
        'section_id',
        'unit_id',
        'division_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('employee_no', 'like', '%'.$search.'%')
                ->orWhere('first_name', 'like', '%'.$search.'%')
                ->orWhere('middle_name', 'like', '%'.$search.'%')
                ->orWhere('last_name', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('department', 'like', '%'.$search.'%')
                ->orWhere('position', 'like', '%'.$search.'%');
    }


    public function position()
    {
        return $this->belongsTo('App\Models\Vtt\Position', 'position_id', 'id');
    }

    public function office(){
        return $this->hasOne('App\Models\Vtt\Department', 'id', 'department_id');
    }

}
