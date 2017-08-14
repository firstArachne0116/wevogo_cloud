<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" href="/favicon.png">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	@yield('meta-common')
	@yield('meta-custom')
	<title>
		{{ config('app.name', 'Sports League Admin') }}: Admin
	</title>

@yield('head-scripts')

{{--{!! Html::style('/assets/metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css') !!}--}}

@section('styles')
	{!! Html::style('http://fonts.googleapis.com/css?family=Quicksand:400,300,500,700&amp;subset=cyrillic,latin') !!}

	{!! Html::style('backend/css/bootstrap.min.css') !!}
	{!! Html::style('backend/font-awesome/css/font-awesome.css?'.time()) !!}

	{!! Html::style('backend/css/plugins/chosen/bootstrap-chosen.css?'.time()) !!}

	{!! Html::style('backend/css/animate.css?'.time()) !!}
	{!! Html::style('backend/css/style.css?'.time()) !!}

	{!! Html::style('backend/css/custom.css?'.time()) !!}

	@yield('custom-styles')
@show


<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	{!! Html::style('//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js') !!}
	{!! Html::style('//oss.maxcdn.com/respond/1.4.2/respond.min.js') !!}
	<![endif]-->
</head>
<body class="{{ isset($controller) && ($controller == 'LoginController') ? 'gray-bg' : '' }}">
<div id="wrapper">
	@if (Auth::check())
	@section('left-menu')
		<nav class="navbar-default navbar-static-side" role="navigation">
			<div class="sidebar-collapse">
				<ul class="nav metismenu" id="side-menu">
					<li class="nav-header">
						<div class="dropdown profile-element text-center">
							<span>
                        		<img alt="image" class="img-circle" src="{{ asset('img/default-profile.jpg') }}" style="width: 100px;"/>
                         	</span>
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        		<span class="clear">
									<span class="block m-t-xs">
										<strong class="font-bold">{{ Auth::user()->name }}</strong>
                         			</span>
									{{--<span class="text-muted text-xs block">Admin User<b class="caret"></b></span>--}}
								</span>
							</a>
							<ul class="dropdown-menu animated fadeInRight m-t-xs">
								<li><a href="javascript:void(0)">Profile</a></li>
								<li class="divider"></li>
								<li><a href="javascript:void(0)">Logout</a></li>
							</ul>
						</div>
						<div class="logo-element">
							SL
						</div>
					</li>
					<li class="{{active_class($controller, 'DashboardController')}}">
						<a href="{!! URL::route('dashboard.index') !!}"><i class="fa fa-th-large"></i>
							<span class="nav-label">Dashboard</span></a>
					</li>
					<li class="{{active_class($controller, 'WevoUsersController')}}">
						<a href="{!! URL::route('wevo-users.index') !!}"><i class="fa fa-life-bouy"></i>
							<span class="nav-label">Wevo Users</span></a>
					</li>
				</ul>

			</div>
		</nav>
	@show
	@endif
	<div id="{{ isset($controller) && ($controller == 'LoginController') ? '' : 'page-wrapper' }}" class="gray-bg">
		@if (Auth::check())
		@include('partial/admin_topbar')
		@endif
		@yield('content')
	</div>
	@yield('footer')
</div>
@section('scripts')
	<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
		{{ csrf_field() }}
	</form>
	{!! Html::script('backend/js/jquery-2.1.1.js') !!}
	{!! Html::script('backend/js/bootstrap.min.js') !!}
	{!! Html::script('backend/js/plugins/metisMenu/jquery.metisMenu.js') !!}
	{!! Html::script('backend/js/plugins/slimscroll/jquery.slimscroll.min.js') !!}

	{!! Html::script('backend/js/plugins/chosen/chosen.jquery.js') !!}

	<!-- Custom and plugin javascript -->
	{!! Html::script('backend/js/inspinia.js?'.time()) !!}
	{!! Html::script('backend/js/plugins/pace/pace.min.js') !!}
	{{--{!! Html::script('backend/js/league-admin.js?'.time()) !!}
	<script>
		LeagueAdmin.init();
	</script>--}}
@show
@yield('custom-scripts')
</body>
</html>