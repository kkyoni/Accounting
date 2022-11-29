<!DOCTYPE html>
<html lang="en">	
@include('admin.includes.headAuth')

<body id="gray-bg">
	<div class="loginColumns animated fadeInDown">
			@yield('authContent')	
	</div>
	<!-- Mainly scripts -->
	@include('admin.includes.scriptsAuth')
</body>
</html>



