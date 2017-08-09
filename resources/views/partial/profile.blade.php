{!! Form::open(['url' => route('profile.store'), 'class' => 'sky-form']) !!}
    <section class="row" style="margin-bottom: 20px;">
        <div class="col-md-6">
            <label class="input{{ $errors->has('first_name') ? ' state-error' : '' }}">
                {{ Form::label('First Name') }}
                {{ Form::text('first_name', $player->first_name, ['class' => 'form-control', 'autofocus' => true]) }}
                @if ($errors->has('first_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
                @endif
            </label>
        </div>
        <div class="col-md-6">
            <label class="input{{ $errors->has('last_name') ? ' state-error' : '' }}">
                {{ Form::label('Last Name') }}
                {{ Form::text('last_name', $player->last_name, ['class' => 'form-control']) }}
                @if ($errors->has('last_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                @endif
            </label>
        </div>
    </section>
    <section>
        <div class="input{{ $errors->has('phone_number') ? ' state-error' : '' }}">
            {{ Form::label('Phone Number') }}
            {{ Form::text('phone_number', $player->phone_number, ['class' => 'form-control']) }}

            @if ($errors->has('phone_number'))
                <span class="help-block">
                    <strong>{{ $errors->first('phone_number') }}</strong>
                </span>
            @endif
        </div>
    </section>

    <section class="row" style="margin-bottom: 20px;">
        <div class="col-md-6">
            <div class="input{{ $errors->has('gender_code') ? ' state-error' : '' }}">
                {{ Form::label('Gender') }}
                {{ Form::select('gender_code', ['Male', 'Female', 'Other'], $player->gender_code, ['class' => 'form-control']) }}

                @if ($errors->has('gender_code'))
                    <span class="help-block">
                        <strong>{{ $errors->first('gender_code') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="input{{ $errors->has('height_inches') ? ' state-error' : '' }}">
                {{ Form::label('Height') }}
                {{ Form::text('height_inches', $player->height_inches, ['class' => 'form-control']) }}

                @if ($errors->has('height_inches'))
                    <span class="help-block">
                        <strong>{{ $errors->first('height_inches') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </section>

    <section class="row" style="margin-bottom: 20px;">
        <div class="col-md-6">
            <div class="input{{ $errors->has('experience') ? ' state-error' : '' }}">
                {{ Form::label('Experience') }}
                {{ Form::select('experience', getEnumValues('players', 'experience'), $player->experience, ['class' => 'form-control']) }}

                @if ($errors->has('experience'))
                    <span class="help-block">
                        <strong>{{ $errors->first('experience') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="input{{ $errors->has('preferred_position') ? ' state-error' : '' }}">
                {{ Form::label('Preferred Positions') }}
                {{ Form::select('preferred_position', getEnumValues('players', 'preferred_position'), $player->preferred_position, ['class' => 'form-control']) }}

                @if ($errors->has('preferred_position'))
                    <span class="help-block">
                        <strong>{{ $errors->first('preferred_position') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </section>

    <section class="input{{ $errors->has('vertical_stack') ? ' state-error' : '' }}">
        <label class="label">Do you know what a vertical stack is?</label>
        <div class="inline-group">
            @foreach (radioArray() as $label => $value)
                <label class="radio">
                    {{ Form::radio('vertical_stack', $value, ($player->vertical_stack == $value) ? true: null, ['class' => '']) }}
                    <i class="rounded-x"></i> {{$label}}
                </label>
            @endforeach
        </div>

        @if ($errors->has('vertical_stack'))
            <span class="help-block">
                <strong>{{ $errors->first('vertical_stack') }}</strong>
            </span>
        @endif
    </section>

    <section class="input{{ $errors->has('horizontal_stack') ? ' state-error' : '' }}">
        <label class="label">Do you know what a horizontal stack is? </label>
        <div class="inline-group">
            @foreach (radioArray() as $label => $value)
                <label class="radio">
                    {{ Form::radio('horizontal_stack', $value, ($player->horizontal_stack == $value) ? true : null, ['class' => '']) }}
                    <i class="rounded-x"></i> {{$label}}
                </label>
            @endforeach
        </div>

        @if ($errors->has('horizontal_stack'))
            <span class="help-block">
                <strong>{{ $errors->first('horizontal_stack') }}</strong>
            </span>
        @endif
    </section>

    <section class="input{{ $errors->has('zone') ? ' state-error' : '' }}">
        <label class="label">Do you know what a zone is?  </label>
        <div class="inline-group">
            @foreach (radioArray() as $label => $value)
                <label class="radio">
                    {{ Form::radio('zone', $value, ($player->zone == $value) ? true: null, ['class' => '']) }}
                    <i class="rounded-x"></i> {{$label}}
                </label>
            @endforeach
        </div>

        @if ($errors->has('zone'))
            <span class="help-block">
                <strong>{{ $errors->first('zone') }}</strong>
            </span>
        @endif
    </section>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <button type="submit" class="btn-u btn-u-primary">
                Save Changes
            </button>
        </div>
    </div>
{!! Form::close() !!}