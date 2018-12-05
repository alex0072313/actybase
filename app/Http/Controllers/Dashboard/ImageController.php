<?php

namespace App\Http\Controllers\Dashboard;

use App\Image;
use Illuminate\Http\Request;

class ImageController extends DashboardController
{
    public function save_temp(){

        return response()->json(request('images'));
        
    }
}
