<?php

namespace App\Models\Vtt;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModeOfAcquisition extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'mode_of_acquisitions';

    //
}
