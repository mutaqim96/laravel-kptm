<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function changeLocale($locale){

        app()->setLocale($locale);

    }
}
