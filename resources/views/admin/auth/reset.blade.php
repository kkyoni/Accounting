@extends('admin.layouts.appAuth')
@section('authContent')
<style type="text/css">
.alert{position:absolute; top:-47px; left: 16%;}
html, body {color: #FFF;}
.ibox-content{background: none; background: transparent; border-top: none}
.passwordBox{padding: 0px;}
</style>
<div class="passwordBox animated fadeInDown">
  <div class="row" style="box-shadow: 30px 30px 30px 30px rgb(30 30 30 / 30%);">
    <div class="col-md-12">
      @if(Session::has('message'))
      <div class="row">
        <div class="col-lg-12">
          <div class=" alert alert-{!! Session::get('alert-type') !!}">
          {!! Session::get('message') !!} 
          </div>
        </div>
      </div>
      @endif
      <div class="ibox-content">
        <center>
          <img src="{{ url(\Settings::get('application_logo')) }}" style="height: auto;width: 20%;">
        </center>
        <h2 class="font-bold" style="text-align:center;">Reset password</h2>
        <div class="row">
          <div class="col-lg-12">
            <form class="m-t" role="form" method="POST" action="{{ route('admin.resetPassword_set') }}">
              @csrf
              <div class="form-group">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="form-group">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="password" style="color:#000;">
                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="form-group">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password"  placeholder="Conform password" style="color:#000;">
                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <button type="submit" class="btn btn-primary block full-width m-b" style="background-color: #007bff; border-color: #007bff;">{{ __('Reset Password') }}</button>
            </form>
            <a href="{{route('admin.login')}}" style="color:#FFF">{{ __('Back to login') }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr/>
  <div class="row">
    <div class="col-md-6" style="color:#FFF;">Copyright {{Settings::get('copyright')}}</div>
    <div class="col-md-6 text-right" style="color:#FFF;"><small>© {{ date('Y') }}</small></div>
  </div>
@endsection
@section('authStyles')
@endsection
@section('authScripts')
@endsection