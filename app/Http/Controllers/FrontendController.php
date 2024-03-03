<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class FrontendController extends BaseController
{
    public function index(){
        return redirect()->route('login');
    }
}
