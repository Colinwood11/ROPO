<!DOCTYPE html>
<html>
@include('admin.include.header')

<body>
	<!-- MOBI Nav -->
	@include('admin.include.mobinavbar')
	<!-- sidebar -->
	@include('admin.include.sidebar')
	<!-- main -->
	<div class="uk-container uk-container-expand uk-background-muted main">
		<div class="uk-section uk-section-xsmall uk-padding-remove-top">
			@include('admin.include.navbar')
			@yield('content')
		</div>
	</div>

	@include('admin.include.mobsidebar')



</body>
@include('admin.include.footer')
</html>