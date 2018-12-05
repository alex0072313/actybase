<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{

    protected $fillable = ['name', 'text', 'user_id', 'category_id', 'company_id', 'parent_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function childs() 
    {
        return $this->hasMany(Owner::class,'parent_id','id');
    }

    public function parent() 
    {
        return $this->belongsTo(Owner::class,'id','parent_id');
    }

    public function images() 
    {
        return $this->hasMany(Image::class);
    }


}
