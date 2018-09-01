<?php

namespace App\Http\Controllers;

use App\Page;
use App\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class PageController extends Controller
{

    public function index($slug)
    {
        try {
            $page = Pages::where('slug', $slug)->first();
            if($page && $page->getRelatedName('status') == 'Published') return view('pages.' . $page->getRelatedName('type'), compact('page'));
            else abort(404);
        } catch (\Exception $e) {
            abort(404);
        }
    }

}