<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;
use Validator;
use Image;
class UserController extends Controller
{
    public function profile()
    {
        if (Sentinel::check()) {
            $user = Sentinel::getUser();
            return view('user.profile')->with('user', $user);
        } else {
            return 'Bạn chưa đăng nhập. Vui lòng đăng nhập trước khi truy cập chức năng này!';
        }
    }

    public function profileImage(Request $request)
    {
        if (Sentinel::check()) {
            $postData = $request->only('image');
            // dd($postData);
            if ($postData == null) {
                return back()->with(['error' => 'Vui lòng chọn ảnh trước!']);
            }
            $file = $postData['image'];

            // Build the input for validation
            $fileArray = array('image' => $file);

            // Tell the validator that this file should be an image
            $rules = array(
                'image' => 'image|required|max:10000' // max 10000kb
            );
            // mimes:jpeg,jpg,png,gif|required|max:10000
            // Now pass the input and rules into the validator
            $validator = Validator::make($fileArray, $rules);

            if ($validator->fails()){
                return back()->with(['errors' => $validator->errors()->all()]);
            } else {
                $imagePath120 = public_path('/image/user/120/');
                $imagePath150 = public_path('/image/user/150/');
                $imagePath500 = public_path('/image/user/500/');

                $fileExtension = '.jpg';
                Image::configure(array('driver' => 'gd'));
                $imageName = sha1(time()). $fileExtension;
                // 120 x 120
                $savePath = $imagePath120 . $imageName;
                $img = Image::make($request->image)
                        ->resize(120, 120)
                        ->save($savePath);
                $img->save();

                // 150 x 150
                $savePath = $imagePath150 . $imageName;
                $img = Image::make($request->image)
                        ->resize(150, 150)
                        ->save($savePath);
                $img->save();

                  // 500 x 500
                $savePath = $imagePath500 . $imageName;
                $img = Image::make($request->image)
                        ->resize(500, 500)
                        ->save($savePath);
                $img->save();

                $user = Sentinel::getUser();
                $user->image = $imageName;
                $user->save();
                return back()->with(['success' => 'Upload ảnh thành công!']);
            }
            
        } else {
            return 'Bạn chưa đăng nhập. Vui lòng đăng nhập trước khi truy cập chức năng này!';
        }
    }
}
