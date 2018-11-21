<?php

namespace App\Repositories;

use Image;
use Storage;

abstract class CompanyRepository extends Repository
{

    public static function createThumb($imgfile, $company){
        $img = Image::make($imgfile);

        //origin
        Storage::disk('public')->put('company_imgs/'.$company->id.'/src.jpg', (string) $img->encode());

        $img->fit(114, 114, function ($constraint) {
            $constraint->upsize();
        });
        Storage::disk('public')->put('company_imgs/'.$company->id.'/thumb_m.jpg', (string) $img->encode());

        $img->fit(50, 50, function ($constraint) {
            $constraint->upsize();
        });
        Storage::disk('public')->put('company_imgs/'.$company->id.'/thumb_s.jpg', (string) $img->encode());

        $img->fit(36, 36, function ($constraint) {
            $constraint->upsize();
        });
        Storage::disk('public')->put('company_imgs/'.$company->id.'/thumb_xs.jpg', (string) $img->encode());

    }

}