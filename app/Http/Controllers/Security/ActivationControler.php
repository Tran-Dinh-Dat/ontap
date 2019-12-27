<?php

namespace App\Http\Controllers\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;
use Activation;
use App\User;

class ActivationControler extends Controller
{
    public function activate($email, $code)
    {
        $user = User::whereEmail($email)->first();
        $user = Sentinel::findById($user->id);

        if (Activation::complete($user, $code)) {
            return redirect('/login');
        }
    }
}
