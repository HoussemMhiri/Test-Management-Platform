<?php

namespace App\Http\Controllers\Aceess_code;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccessCodeController extends Controller
{
    public function index()
    {
        return view('access_code.index');
    }
}
