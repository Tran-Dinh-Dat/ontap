@extends('security.layout.master')
@section('form')
    <section class="sign-in">
        <div class="container">
            <div class="signin-content">
                <div class="signin-form">
                    <h2 class="form-title">Click the link</h2>
                    
                    <a href="{{url('/short/'. $url->short)}}" target="_blank"><input type="button" class="form-submit" value="{{ $url->short }}"/></a>
                    <div class="form-group form-button">
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection