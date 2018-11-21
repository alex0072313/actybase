<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Company extends Model
{

    protected $guarded = ['id'];

    public function users(){
        return $this->hasMany('App\User');
    }

    public function managers(){
        $filtered = $this->users->filter(function ($user) {
           return $user->hasRole(config('role.names.manager.name'));
        });

       return $filtered->all();

    }

}
