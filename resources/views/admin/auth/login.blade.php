@extends('admin.layouts.appAuth')
@section('authContent')
<style type="text/css">
.alert{position:absolute; top:80px; left: 16%;}
html, body {color: #FFF;}
.ibox-content{background: none; background: transparent; border-top: none}
</style>
@if(Session::has('message'))
<div class="row">
	<div class="col-md-12">
		<div class="alert alert-{!! Session::get('alert-type') !!}">
			{!! Session::get('message') !!}
		</div>
	</div>
</div>
@endif
<div class="row" style="box-shadow: 30px 30px 30px 30px rgb(30 30 30 / 30%);">
	<div class="col-md-6">
		<h2 class="font-bold">Welcome to {{Settings::get('application_title')}}</h2>
		<p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.</p>
		<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
		<p>When an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
		<p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
	</div>
	<div class="col-md-6" style="padding-right:0px">
		<div class="ibox-content">
			<center>
				<img src="{{ url(\Settings::get('application_logo')) }}" style="height: auto;width: 20%;">
			</center>
			<h2 class="font-bold" style="text-align: center;">Admin Login</h2>
			<form class="m-t" role="form" method="POST" action="{{ url('admin/login') }}">
			@csrf
			<div class="form-group">
				<input id="exampleInputEmail_2" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="<?php if(isset($_COOKIE['email_cookie'])){ ?> {{$_COOKIE['email_cookie']}} <?php }  ?>" required autocomplete="email" placeholder="Enter Email" autofocus style="color: #000;">
				@error('email')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
			<div class="form-group">
				<input type="password" class="form-control" value="<?php if(isset($_COOKIE['password_cookie'])){ echo $_COOKIE['password_cookie']; }  ?>" required="" id="exampleInputEmail_3" placeholder="Enter Password" name="password" autocomplete="current-password" style="color: #000;">
				@error('password')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
			<div class="form-group" style="margin-left: 25px;">
				<input class="form-check-input" type="checkbox" id="termscheckd" value="remmeber_me" name="remmeber"   <?php if(isset($_COOKIE['email_cookie'])){ ?> checked <?php }  ?>> &nbsp;
				<label class="form-check-label" for="termscheckd">Remember me</label>
			</div>
			<button type="submit" class="btn btn-primary block full-width m-b" style="background-color: #007bff; border-color: #007bff;">Login</button>
			<a href="{{ route('admin.resetPassword') }}">
				<small style="color: #FFF;">Forgot password?</small>
			</a>
		</form>
	</div>
</div>
</div>
<hr/>
<div class="row">
	<div class="col-md-6">Copyright {{Settings::get('copyright')}}</div>
	<div class="col-md-6 text-right">
		<small>© {{ date('Y') }}</small>
	</div>
</div>
@endsection
@section('authStyles')
@endsection
@section('authScripts')
@endsection