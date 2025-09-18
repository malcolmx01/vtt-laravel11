<?php

namespace App\Models\Vtt;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    /**
     * Guard properties
     *
     * @var array
     **/
    protected $guarded = ['id'];

    protected $appends = [
        'time'
    ];


    /**
     * Format updated_at
     *
     * @return string
     */
    public function getTimeAttribute()
    {
        return (Carbon::parse($this->updated_at))->diffForHumans();
    }

    public function attachable()
    {
        return $this->morphTo();
    }

}
