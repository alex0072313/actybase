<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fieldtype extends Model
{
    public function fields()
    {
        return $this->hasMany(Field::class);
    }
}
