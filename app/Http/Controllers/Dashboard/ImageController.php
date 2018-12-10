<?php

namespace App\Http\Controllers\Dashboard;

use App\Image;
use Illuminate\Http\Request;
use Auth;

class ImageController extends DashboardController
{
    public function destroy(Image $image){

        $json = [];

        if(Auth::user()->can('delete', $image)){
            if($image->delete()){
                $json['success'] = 'Изображение было успешно удалено!';
            }
        }else{
            $json['error'] = 'У Вас нет разрешения на удаление изображений в данном обьекте!';
        }

        return response()->json($json);
    }
}
