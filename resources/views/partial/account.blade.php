{{ Form::open(array('url' => '/account', 'class' => 'sky-form')) }}
<dl class="dl-horizontal">
    <dt>Username</dt>
    <dd>
        <section>
            <label class="input {!! $errors->first('username', "state-error") !!}">
                <i class="icon-append fa fa-user"></i>
                {!! Form::text('username', $user->username, array('class'=>'form-control')) !!}
                <b class="tooltip tooltip-bottom-right">Needed to enter the website</b>
            </label>
            @if ($errors->has('username'))
                <em class="invalid">{!! $errors->first('username', ':message') !!}</em>
            @endif
        </section>
    </dd>
    <dt>Email address</dt>
    <dd>
        <section>
            <label class="input {!! $errors->first('email', "state-error") !!}">
                <i class="icon-append fa fa-envelope"></i>
                {!! Form::text('email', $user->email, array('class'=>'form-control')) !!}
                <b class="tooltip tooltip-bottom-right">Needed to verify your account</b>
            </label>
            @if ($errors->has('email'))
                <em class="invalid">{!! $errors->first('email', ':message') !!}</em>
            @endif
        </section>
    </dd>
    <dt>Enter your password</dt>
    <dd>
        <section>
            <label class="input {!! $errors->first('password', "state-error") !!}">
                <i class="icon-append fa fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Password">
                <b class="tooltip tooltip-bottom-right">Don't forget your password</b>
            </label>
            @if ($errors->has('password'))
                <em class="invalid">{!! $errors->first('password', ':message') !!}</em>
            @endif
        </section>
    </dd>
    <dt>Confirm Password</dt>
    <dd>
        <section>
            <label class="input">
                <i class="icon-append fa fa-lock"></i>
                <input type="password" name="password_confirmation" placeholder="Confirm password">
                <b class="tooltip tooltip-bottom-right">Don't forget your password</b>
            </label>
        </section>
    </dd>
</dl>
<button class="btn-u" type="submit">Save Changes</button>
{{ Form::close() }}