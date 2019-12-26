<h3>Hello {{$user->name}}</h3>
<p>
    Please click the activation button to activate your accout!
    <a href="{{url('/activate/'. $user->email. '/' . $code)}}">Activate account</a>
</p>