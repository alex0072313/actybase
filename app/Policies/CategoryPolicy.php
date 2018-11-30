<?php

namespace App\Policies;

use App\User;
use App\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function access(User $user, Category $category){
        if($user->hasRole('megaroot')){
            return true;
        }elseif($category->user->hasRole('boss')){
            if($user->company()->find($category->user->company->id)->count()){
                return true;
            }
        }/*elseif($category->user->hasRole('manager')){
            if($category->user->id == $user->id){
                return true;
            }
        }*/

        return false;
    }
}
