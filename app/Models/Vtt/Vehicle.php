<?php

namespace App\Models\Vtt;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    //Table Name
    protected $table = 'vehicles';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    protected $fillable = [
        'transaction_datetime',
        'origin',
        'departure',
        'starting_ODO',
        'destination',
        'arrival',
        'ending_ODO',
        'total_mileage',
        'purpose_trip_details',
        'authorized_passengers',
        'visited_places',
        'vehicle_plate_no',
        'remarks',
        'status',
        'status_date',
        'setby',
        'setby_name',
        'setby_designation_id',
        'setby_designation',
        'setby_office_id',
        'setby_office',
        'setby_remarks',
    ];


    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('origin', 'like', '%'.$search.'%')
                ->orWhere('departure', 'like', '%'.$search.'%')
                ->orWhere('destination', 'like', '%'.$search.'%')
                ->orWhere('arrival', 'like', '%'.$search.'%')
                ->orWhere('purpose_trip_details', 'like', '%'.$search.'%')
                ->orWhere('authorized_passengers', 'like', '%'.$search.'%')
                ->orWhere('visited_places', 'like', '%'.$search.'%')
                ->orWhere('vehicle_plate_no', 'like', '%'.$search.'%')
                ->orWhere('remarks', 'like', '%'.$search.'%');
    }

    public function docstatus(){
        return $this->hasOne('App\Models\Vtt\DocStatus', 'id', 'status');
    }

    public function ModeOfAcquisition(){
        return $this->hasOne('App\Models\Vtt\ModeOfAcquisition', 'id', 'mode_of_acquisition');
    }
}
