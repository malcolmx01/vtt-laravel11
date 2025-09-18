<?php

namespace App\Models\Vtt;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    //Table Name
    protected $table = 'profiles';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    public function user(){
        return $this->belongsTo('App\Models\Vtt\User');
    }
}
