<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fieldcontent extends Model
{
    public function owner()
    {
        return $this->hasOne(Owner::class);
    }

    public function field()
    {
        return $this->hasOne(Field::class);
    }

}
