<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Category extends Model
{

    protected $fillable = ['name', 'parent_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function owners()
    {
        return $this->belongsToMany(Owner::class);
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class, 'fields_categories')->withTimestamps();
    }

    public function parent()
    {
        return Category::where('id', $this->parent_id)->first();
    }

    public function childs() {
        return $this->hasMany(Category::class,'parent_id','id');
    }

    public function isDefault(){
        return $this->user->hasRole('megaroot');
    }

    public static function allToAccess($with_child = false){
        $results = [];
        if (auth()->user()->hasRole('megaroot')){
            if(!$with_child){
                $results = Category::where('parent_id', '=', null)
                    ->get();
            }else{
                $results = Category::all();
            }
        }else{
            if(!$with_child) {
                $results = User::getAdmin()
                    ->categories()
                    ->where('parent_id', '=', null)
                    ->get()
                    ->merge(
                        auth()
                            ->user()
                            ->company
                            ->categories()
                            ->where('parent_id', '=', null)
                            ->get()
                    );
            }else{
                $results = User::getAdmin()
                    ->categories
                    ->merge(
                        auth()
                            ->user()
                            ->company
                            ->categories
                    );
            }
        }

        return $results;
    }

    public function delete()
    {
        Category::where('parent_id', $this->id)->delete();

        return parent::delete(); // TODO: Change the autogenerated stub
    }

}
