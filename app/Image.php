<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['name', 'alt', 'title'];

    public function owner()
    {
        return $this->hasOne(Owner::class);
    }
}
