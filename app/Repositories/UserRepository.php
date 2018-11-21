<?php

namespace App\Repositories;

use Image;
use Storage;

abstract class UserRepository extends Repository
{

    public static function createThumb($imgfile, $user){
        $img = Image::make($imgfile);

        //origin
        Storage::disk('public')->put('user_imgs/'.$user->id.'/src.jpg', (string) $img->encode());

        $img->fit(114, 114, function ($constraint) {
            $constraint->upsize();
        });
        Storage::disk('public')->put('user_imgs/'.$user->id.'/thumb_m.jpg', (string) $img->encode());

        $img->fit(50, 50, function ($constraint) {
            $constraint->upsize();
        });
        Storage::disk('public')->put('user_imgs/'.$user->id.'/thumb_s.jpg', (string) $img->encode());

        $img->fit(36, 36, function ($constraint) {
            $constraint->upsize();
        });
        Storage::disk('public')->put('user_imgs/'.$user->id.'/thumb_xs.jpg', (string) $img->encode());

    }

}