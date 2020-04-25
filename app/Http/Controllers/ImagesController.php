<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImagesController extends Controller
{
    public function profilePicture($name)
    {
        $pathToFile = storage_path('/app/public/images/profile-pictures/' . $name);
        return response()->file($pathToFile);
    }
}
