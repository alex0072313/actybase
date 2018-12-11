<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    public function type()
    {
        return $this->belongsTo(Fieldtype::class);
    }
}
