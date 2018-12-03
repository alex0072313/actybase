<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Carbon;

class Company extends Model
{

    protected $guarded = ['id'];

    protected $hidden = ['logo'];

    public function users(){
        return $this->hasMany('App\User');
    }

    public function owners()
    {
        return $this->hasMany(Owner::class);
    }

    public function managers(){
        $filtered = $this->users->filter(function ($user) {
           return $user->hasRole(config('role.names.manager.name'));
        });

       return $filtered->all();

    }

    public function boss(){
        $filtered = $this->users->filter(function ($user) {
            return $user->hasRole(config('role.names.boss.name'));
        });

        return $filtered[0];
    }

    public function delete()
    {
        $this->boss()->delete();
        return parent::delete();
    }

    public function is_bestbefore()
    {
        return Carbon::parse($this->bestbefore) > Carbon::now();
    }

    public function categoryGroup(){
        $owners = [];
        foreach (Owner::all() as $owner){
            $owners[$owner->category->name][] = $owner;
        }

        return $owners;
    }

    public function scopeOwnersByCat($query)
    {
        $owners = [];
        foreach ($this->hasMany(Owner::class)->get() as $owner){
            $owners[$owner->category->name][] = $owner;
        }

        return $owners;
    }

}
