@extends('security.layout.master')
@section('form')
    <section class="sign-in">
        <div class="container">
            <div class="signin-content">
                <div class="signin-form">
                    <h2 class="form-title">Short Url</h2>
                    @include('errors.error')
                    <form action="{{url('/short')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="url"><i class="zmdi zmdi-email"></i></label>
                            <input type="text" name="url" id="url" placeholder="Địa chỉ cần rút gọn :D"/>
                        </div>
                        <div class="form-group form-button">
                            <input type="submit" class="form-submit" value="Short Url"/>
                        </div>
                    </form>
                    <div class="social-login">
                        <span class="social-label">Or login with</span>
                        <ul class="socials">
                            <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                            <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                            <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection