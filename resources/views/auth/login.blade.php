@extends('layout.admin')

@section('content')
    <div class="loginColumns animated fadeInDown">
        <h2 class="font-bold text-center">Welcome to Wevo Cloud</h2>
        <div class="row">
            <div class="col-md-6 m-t">
                <img src="{{ asset('img/wevo-logo.png') }}" class="logo">
            </div>
            <div class="col-md-6">
                <div class="ibox-content">
                    <form class="m-t" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} m-b-lg">
                            <input id="email" type="email" class="form-control input-lg" name="email" value="{{ old('email') }}" placeholder="Email" autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input id="password" type="password" class="form-control input-lg" name="password" placeholder="Password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary block full-width m-b btn-lg">
                                Login
                            </button>

                            {{--<a class="btn btn-link" href="{{ url('/admin/password/reset') }}">--}}
                            {{--Forgot Your Password?--}}
                            {{--</a>--}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@stop
