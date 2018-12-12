<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
	protected $fillable = ['name', 'fieldtype_id'];

    public function type()
    {
        return $this->belongsTo(Fieldtype::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'fields_categories')->withTimestamps();
    }

}
