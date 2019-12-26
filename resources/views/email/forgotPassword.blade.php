<h3>Hello {{$user->name}}</h3>
<p>
    Please click the Reset Password button to reset password  your accout!
    <a href="{{url('/reset_password/'. $user->email. '/' . $code)}}">Reset Password</a>
</p>