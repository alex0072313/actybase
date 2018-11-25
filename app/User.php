<?php

namespace App;

use App\Notifications\MailResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Storage;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','lastname', 'company_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        //$this->notify(MailResetPasswordNotification::toMail($token));
        $this->notify(new \App\Notifications\MailResetPasswordNotification($token));
    }

    public function company(){
        return $this->hasOne('App\Company', 'id', 'company_id');
    }

    public function roleName(){
        return config('role.names.'.$this->roles()->get()->first()->name.'.dolg');
    }

    public function delete()
    {
        Storage::disk('public')->deleteDirectory('user_imgs/'.$this->id);
        return parent::delete(); // TODO: Change the autogenerated stub
    }

}
