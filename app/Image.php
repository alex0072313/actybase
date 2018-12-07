<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;
use Storage;

class Image extends Model
{
    protected $fillable = ['name', 'alt', 'title'];

    public function owner()
    {
        return $this->hasOne(Owner::class);
    }

    public function th_url($th_num = ''){

        $th_dir = Config::get('image.owner.dir_name').'/'.($this->owner_id % 100).'/'.$this->owner_id.'/th'.$th_num.'/';

        $filename_without_ext = pathinfo($this->filename, PATHINFO_FILENAME);

        $th_image = $th_dir . $filename_without_ext . '.' . Config::get('image.owner.th.th'.$th_num.'.ext');

        if(Storage::disk('public')->exists($th_image)){
            return Storage::disk('public')->url($th_image);
        }

        return false;
    }

}
