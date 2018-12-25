<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
	protected $fillable = ['name', 'fieldtype_id'];

    public function type()
    {
        return $this->hasOne(Fieldtype::class, 'id', 'fieldtype_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'fields_categories')->withTimestamps();
    }
    
    public function contents()
    {
        return $this->hasMany(Fieldcontent::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

}
