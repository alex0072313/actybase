<?php

namespace App\Policies;

use App\Owner;
use App\User;
use App\Image;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImagePolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Image $image)
    {
        if($user->hasRole('megaroot')){
            return true;
        }elseif($user->hasRole('boss')){
            if($image->owner->company()->find($user->company->id)->count()){
                return true;
            }
        }elseif($user->hasRole('manager')){
            if($image->owner->user->id == $user->id){
                return true;
            }
        }

        return false;
    }

}
