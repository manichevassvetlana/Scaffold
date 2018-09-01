<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public static function store($image)
    {
        $path = $image->store('public/images');
        return $path;
    }

    public static function remove($path)
    {
        Storage::delete($path);
    }
}
