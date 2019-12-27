@php
    
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
    <!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.10.1/css/mdb.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
            <div class="jumbotron card card-image" style="background-image: url(https://mdbootstrap.com/img/Photos/Others/gradient1.jpg);">
                <div class="text-white text-center py-5 px-4">
                        <h3>Profile {{$user->name}}</h3>
                        @include('errors.error')
                        <div class="col-md-6 m-auto" style="display: block", >
                            <form action="{{url('/profile')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile01"
                                        aria-describedby="inputGroupFileAddon01" name="image">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </form>
                        </div>
                </div>
              </div>
        
    </div>
    @if ($user->image != '')
        <img src="{{ url('./image/user/120/'. $user->image) }}" alt="{{$user->image}}">
        <hr>
        <img src="{{ url('./image/user/150/'. $user->image) }}" alt="{{$user->image}}">
        <hr>
        <img src="{{ url('./image/user/500/'. $user->image) }}" alt="{{$user->image}}">
    @endif

    <!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.10.1/js/mdb.min.js"></script>
</body>
</html>

