<?php

namespace App\Models\Vtt;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
//    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public $sortable = [
        'id', 'name', 'email', 'created_at', 'updated_at', 'account_image'
    ];


    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function items()
    {
        return $this->hasMany('App\Models\Vtt\Item');
    }

    public function prices()
    {
        return $this->hasMany('App\Models\Vtt\Price');
    }

    public function albums()
    {
        return $this->hasMany('App\Models\Vtt\Album');
    }

    public function photos()
    {
        return $this->hasMany('App\Models\Vtt\Photo');
    }

    public function categories()
    {
        return $this->hasMany('App\Models\Vtt\Category');
    }

    public function profiles()
    {
        return $this->hasMany('App\Models\Vtt\Profile');
    }

    public function charts()
    {
        return $this->hasMany('App\Models\Vtt\Charts');
    }

    public function cdrs()
    {
        return $this->hasMany('App\Models\Vtt\Cdrs_report', 'prepared_by');
    }

    public function isAdmin()
    {
        $admin_emails = config('settings.admin_emails');
        if (in_array($this->email, $admin_emails))
            return true;
        else
            return false;
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    public function userStores()
    {
        return $this->hasMany(UserStores::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'email');
    }
}
