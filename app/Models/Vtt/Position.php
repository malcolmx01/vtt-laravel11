<?php

namespace App\Models\Vtt;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Position extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

//    use SoftDeletes;

    protected $fillable = [
        'pos_code',
        'pos_name',
        'salary_grade',
        'extra_hazard_premium',
    ];

    //Table Name
    protected $table = 'positions';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
//    public $timestamps = true;

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('pos_code', 'like', '%'.$search.'%')
                ->orWhere('pos_name', 'like', '%'.$search.'%')
                ->orWhere('salary_grade', 'like', '%'.$search.'%')
                ->orWhere('extra_hazard_premium', 'like', '%'.$search.'%');
    }


    public function employees()
    {
        return $this->belongsTo('App\Models\Vtt\Employee', 'position_id', 'id');
    }
}
