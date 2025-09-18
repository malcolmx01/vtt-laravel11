<?php

namespace App\Models\Vtt;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopUp extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    //Table Name
    protected $table = 'top_ups';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    protected $fillable = [
        'top_up_datetime',
        'top_up_liters',
        'amount',
        'beginning_gauge',
        'ending_gauge',
        'fuel_depot_id',
        'fuel_depot_name',
        'fuel_depot_location',
        'person_in_charge_id',
        'person_in_charge_name',
        'person_in_charge_designation_id',
        'person_in_charge_designation',
        'person_in_charge_office_id',
        'person_in_charge_office',
        'employee_no',
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
            : static::query()->where('top_up_datetime', 'like', '%'.$search.'%')
                ->orWhere('top_up_liters', 'like', '%'.$search.'%')
                ->orWhere('amount', 'like', '%'.$search.'%')
                ->orWhere('beginning_gauge', 'like', '%'.$search.'%')
                ->orWhere('ending_gauge', 'like', '%'.$search.'%')
                ->orWhere('fuel_depot_name', 'like', '%'.$search.'%')
                ->orWhere('fuel_depot_location', 'like', '%'.$search.'%')
                ->orWhere('employee_no', 'like', '%'.$search.'%')
                ->orWhere('person_in_charge_name', 'like', '%'.$search.'%')
                ->orWhere('person_in_charge_designation', 'like', '%'.$search.'%')
                ->orWhere('person_in_charge_office', 'like', '%'.$search.'%');
    }

    public function fuelDepot(){
        return $this->hasOne('App\Models\Vtt\FuelDepot', 'id', 'fuel_depot_id');
    }

    public function docstatus(){
        return $this->hasOne('App\Models\Vtt\DocStatus', 'id', 'status');
    }
}
