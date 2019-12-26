<?php

namespace App\Http\Controllers\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;
use Activation;
use App\User;
use Mail;
use App\Models\Roles\RoleModel;

class RegisterControler extends Controller
{
    public function register()
    {
        $data['roles'] = RoleModel::get();
        return view('security.register')->with('data', $data);
    }

    public function registerUser(Request $request)
    {
        $data = $request->all();
        $roleID = $data['role'];

        $user = Sentinel::register($request->all());
        

        $role = Sentinel::findRoleByID($roleID);
        $role->users()->attach($user);

        $activate = Activation::create($user);
        $this->sendActivationEmail($user, $activate->code);

        return redirect('/');
    }

    public function sendActivationEmail($user, $code)
    {
        Mail::send(
            'email.activation',
            ['user' => $user, 'code' => $code],
            function ($message) use ($user) {
                $message->to($user->email);
                $message->subject("Hello $user->name", "Activate your account.");
            }
        );
    }
}
