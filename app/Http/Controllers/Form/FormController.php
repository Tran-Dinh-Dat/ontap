<?php

namespace App\Http\Controllers\Form;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;

class FormController extends Controller
{
    public function view()
    {
        $user = Sentinel::getUser();
        return view('form.xyzForm')->with('user', $user);
    }
}
