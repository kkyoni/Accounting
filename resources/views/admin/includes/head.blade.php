<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<title>{{Settings::get('application_title')}}  - @yield('title')</title>
	<link href="{{ asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css" type="text/css" media="all">
	<link href="{{ asset('assets/admin/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
	<link href="{{ asset('assets/admin/css/plugins/morris/morris-0.4.3.min.css')}}" rel="stylesheet">
	<link href="{{ asset('assets/admin/css/animate.css')}}" rel="stylesheet">
	<link href="{{ asset('assets/admin/css/custom.css')}}" rel="stylesheet">
	<link href="{{ asset('assets/admin/css/style.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
	<link href="{{ asset('assets/admin/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
	<link href="{{ asset('assets/admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">
	<link href="{{ asset('assets/admin/css/plugins/daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet">
	<link href="{{ asset('assets/admin/css/plugins/iCheck/custom.css')}}" rel="stylesheet">

	<link href="{{ asset('assets/admin/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css.map">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js">

	<link href="{{ asset('assets/admin/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet">

	<link href="{{ asset('assets/admin/css/plugins/dualListbox/bootstrap-duallistbox.min.css')}}" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.css" rel="stylesheet"/>
	<link rel="icon" href="{{ url(\Settings::get('favicon_logo')) }}" type="{{ url(\Settings::get('favicon_logo')) }}" sizes="16x16">

	<link href="https://demos.codexworld.com/multi-select-dropdown-list-with-checkbox-jquery/multiselect/jquery.multiselect.css" rel="stylesheet"/>

	<link href="{{ asset('css/star-rating.css')}}" rel="stylesheet">
	<style>
		table tfoot{display: none;}
		table.dataTable {clear: both; margin-top: 6px !important; margin-bottom: 6px !important; max-width: none !important; border-collapse: separate !important; width: 100% !important;}
		.op-btn{margin-right:22px;}
		.help-block {display: inline-block; margin-top: 5px; margin-bottom: 0px; margin-left: 5px;}
		.form-group {margin-bottom: 10px;}
		.form-control {font-size: 14px; font-weight: 500;}
		#hidden{display: none !important;}
	    #imagePreview{width: 100%; height: 100%; text-align: center; margin:0 auto;position: relative;}
	    #hidden{display: none !important;}
	    #imagePreview img {height: 150px; width: 150px; border: 3px solid rgba(0,0,0,0.4);
        padding: 3px;}
		#imagePreview i{position: absolute; right: -18px; background: rgba(0,0,0,0.5); padding: 5px; border-radius: 50%; width: 30px; height: 30px; color: #fff; font-size: 18px;}
		.title-color{background-color: #5A8DEE;}
	</style>
	@yield('styles')
</head>
