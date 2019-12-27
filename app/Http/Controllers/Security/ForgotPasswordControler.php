<?php

namespace App\Http\Controllers\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Sentinel;
use Reminder;
use Mail;
use Validator;

class ForgotPasswordControler extends Controller
{
    public function forgotPasswordForm()
    {
        return view('security.forgotPassword');
    }

    public function forgotPassword(Request $request)
    {
        $user = User::whereEmail($request->email)->first();

        if ($user == null) {
            return back()->with(['error' => 'Email này chưa đăng ký tài khoản']);
        }

        $user = Sentinel::findById($user->id);
        $reminder = Reminder::exists($user) ? : Reminder::create($user);
        $this->sendMail($user, $reminder->code);

        return back()->with(['success' => 'Link đặt lại mật khẩu đã được gửi tới email của bạn :D']);
    }

    public function sendMail($user, $code)
    {
        Mail::send(
            'email.forgotPassword',
            ['user' => $user, 'code' => $code],
            function ($message) use ($user) {
                $message->to($user->email);
                $message->subject("$user->name, đặt lại mật khẩu của bạn.");
            }
        );
    }

    public function reset($email, $code)
    {
        $user = User::whereEmail($email)->first();

        if ($user == null) {
            return back()->with(['error' => 'Email này chưa đăng ký tài khoản']);
        }

        $user = Sentinel::findById($user->id);
        $reminder = Reminder::exists($user);

        if ($reminder) {
            if ($code == $reminder->code) {
                return view('security.resetPasswordForm')->with(['user' => $user, 'code' => $code]);
            } else {
                return redirect('/');
            }
            
        } else {
            echo "Time expired";
        }
    }

    public function resetPassword(Request $request, $email, $code)
    {
        $this->validate($request, [
            'password' =>'required|min:7|max:12|confirmed',
            'password_confirmation' =>'required|min:7|max:12',
        ]);
        
        $user = User::whereEmail($email)->first();

        if ($user == null) {
            return back()->with(['error' => 'Email này chưa đăng ký tài khoản']);
        }

        $user = Sentinel::findById($user->id);
        $reminder = Reminder::exists($user);

        if ($reminder) {
            if ($code == $reminder->code) {
                Reminder::complete($user, $code, $request->password);
                return redirect('/login')->with(['success' => 'Mật khẩu đã được đặt lại. Vui lòng đăng nhập bằng mật khẩu mới']);
            } else {
                return redirect('/');
            }
            
        } else {
            echo "Time expired";
        }
    }

}
