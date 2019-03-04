<div class="header-v6 header-classic-white header-sticky">
    <!-- Navbar -->
    <div class="navbar mega-menu" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="menu-container">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Navbar Brand -->
                <div class="navbar-brand">
                    <a href="{!! URL::to('/') !!} ">
                        <img class="shrink-logo" src="img/old-logo.jpg" alt="Logo">
                    </a>
                </div>
                <!-- ENd Navbar Brand -->
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-responsive-collapse">
                <div class="menu-container">
                    <ul class="nav navbar-nav">
                        <li class="{{ active_class(getActionName(Route::getCurrentRoute()->getActionName()), 'player') }}">
                            <a href="{{ URL::route('page.player') }}">
                                Show Players
                            </a>
                        </li>
                        <li class="{{ active_class(getActionName(Route::getCurrentRoute()->getActionName()), 'seasonLeader') }}">
                            <a href="{{ URL::route('page.season.leader') }}">
                                Season Leader
                            </a>
                        </li>
                        <!-- Home -->
                        @if (Auth::check())
                            @if (Auth::user()->is_admin)
                                <li>
                                    <a href="{!! URL::route('admin.index') !!}">
                                        Go to Admin
                                    </a>
                                </li>
                            @endif

                            <li class="{{ active_class(getControllerName(Route::getCurrentRoute()->getActionName()), 'SeasonController') }}">
                                <a href="{!! URL::route('season.create') !!}">
                                    Register Season
                                </a>
                            </li>
                            <li class="{{ active_class(getControllerName(Route::getCurrentRoute()->getActionName()), 'ProfileController,AccountController') }}">
                                <a href="{!! URL::route('profile.index') !!}">
                                    Profile
                                </a>
                            </li>
                            @if (Auth::user()->isCaptain())
                                <li class="{{ active_class(getControllerName(Route::getCurrentRoute()->getActionName()), 'PlayerController') }}">
                                    <a href="{!! URL::route('players.index') !!}">
                                        Rank Players
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{!! URL::to('/logout') !!}" onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">
                                    Sign-out
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{!! URL::to('/login') !!}"  id="sign_in">
                                    Sign In
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="{!! URL::to('/register') !!}">
                                    Sign Up
                                </a>
                            </li>
                        @endif
                    <!-- End Home -->
                    </ul>
                </div>
            </div><!--/navbar-collapse-->
        </div>
    </div>
    <!-- End Navbar -->
</div>
<!--=== End Header v6 ===-->