<?php

namespace App\Http\Controllers\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;
use Validator;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;

class LoginControler extends Controller
{
    public function login()
    {
        if (Sentinel::check()) {
            return redirect('/');
        }
        return view('security.login');
    }

    public function postLogin(Request $request)
    {
        //Sentinel::disableCheckpoints();
        $errorMsgs = [
            'email.required' => 'Vui lòng nhập email :D',
            'email.email' => 'Email không đúng định dạng :D',
            'password.required' => 'Vui lòng nhập mật khẩu :D',
        ];
        $validator =  Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], $errorMsgs);

        if ($validator->fails()) {
            $returnData = array(
                'status' => 'error',
                'message' => 'Kiểm tra lại các trường',
                'errors' => $validator->errors()->all(),
            );
            // return response()->json($returnData, 500);
            return back()->with(['error' => $validator->errors()->all()]);
        }

        if ($request->remember == 'on') {
            try {
                $user = Sentinel::authenticateAndRemember($request->all());
            } catch (ThrottlingException $e) {
                $delay = $e->getDelay();
                $returnData = array(
                    'status' => 'error',
                    'message' => 'Kiểm tra lại',
                    'errors' => ["You are banner $delay seconds."]
                ); 
                // return response()->json($returnData, 500);
                return back()->with(['error' => "You are banner $delay seconds."]);
            } catch (NotActivatedException $e) {
                $returnData = array(
                    'status' => 'error',
                    'message' => 'Kiểm tra lại',
                    'errors' => ["Tài khoản của bạn chưa được kích hoạt. Vui lòng vào gmail để kích hoạt tài khoản của bạn"]
                ); 
                // return response()->json($returnData, 500);
                return back()->with(['error' => "Tài khoản của bạn chưa được kích hoạt. Vui lòng vào gmail để kích hoạt tài khoản của bạn"]);
            }
        } else {
            try {
                $user = Sentinel::authenticate($request->all());
            } catch (ThrottlingException $e) {
                $delay = $e->getDelay();
                $returnData = array(
                    'status' => 'error',
                    'message' => 'Kiểm tra lại',
                    'errors' => ["You are banner $delay seconds."]
                ); 
                // return response()->json($returnData, 500);
                return back()->with(['error' => "You are banner $delay seconds."]);
            } catch (NotActivatedException $e) {
                $returnData = array(
                    'status' => 'error',
                    'message' => 'Kiểm tra lại',
                    'errors' => ["Tài khoản của bạn chưa được kích hoạt. Vui lòng vào gmail để kích hoạt tài khoản của bạn"]
                ); 
                // return response()->json($returnData, 500);
                return back()->with(['error' => "Tài khoản của bạn chưa được kích hoạt. Vui lòng vào gmail để kích hoạt tài khoản của bạn"]);
            }
        }

        if (Sentinel::check()) {
            return redirect('/');
        } else {
            $returnData = array(
                'status' => 'error',
                'message' => 'Kiểm tra lại',
                'errors' => ["Tài khoản hoặc mật khẩu không chính xác!"]
            ); 
            // return response()->json($returnData, 500);
            return back()->with(['error' => "Tài khoản hoặc mật khẩu không chính xác!"]);
        }
    }

    public function logout()
    {
        Sentinel::logout();
        return redirect('/login');
    }
}
