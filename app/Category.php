<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = ['name', 'parent_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return Category::where('id', $this->parent_id)->first();
    }

    public function childs()
    {
        return Category::where('parent_id', $this->id)->get();
    }
}
