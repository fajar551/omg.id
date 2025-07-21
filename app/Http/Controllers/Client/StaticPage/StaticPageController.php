<?php

namespace App\Http\Controllers\Client\StaticPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{

    public function index()
    {
        return view('client.static.landing.index');
    }

    public function termOfService()
    {
        return view('client.static.term-of-service.index');
    }

    public function privacyPolice()
    {
        return view('client.static.privacy-police.index');
    }

    public function feature() 
    {
        return view('client.static.feature.index');
    }

    public function about() 
    {
        return view('client.static.about.index');
    }

    public function help() 
    {
        return view('client.static.help.index');
    }
    
    public function career() 
    {
        return view('client.static.career.index');
    }

}
