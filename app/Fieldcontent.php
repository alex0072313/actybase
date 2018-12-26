<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fieldcontent extends Model
{

    protected $fillable = ['field_id', 'content', 'data'];

    public function owner()
    {
        return $this->hasOne(Owner::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

}
