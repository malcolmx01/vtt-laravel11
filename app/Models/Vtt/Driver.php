<?php

namespace App\Models\Vtt;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    //Table Name
    protected $table = 'drivers';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    protected $fillable = [
        'employee_no',
        'driver_name',
        'sex',
        'driver_license_no',
        'birthday',
        'department',
    ];
}
