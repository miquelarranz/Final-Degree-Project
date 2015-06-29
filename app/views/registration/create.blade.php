@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center white-color title-margin">@lang('messages.register/register')</h1>

            @include('layouts.partials.errors')

            {{ Form::open(array('route' => 'register_path')) }}
                <div class="row">
                    <div class="col-md-6">
                        <!-- Name Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('name', Lang::get('messages.register/name')) }}
                            {{ Form::text('name', null, ['class' => 'form-control'] ) }}
                        </div>

                        <!-- LastName Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('lastName', Lang::get('messages.register/lastName')) }}
                            {{ Form::text('lastName', null, ['class' => 'form-control'] ) }}
                        </div>

                        <!-- Gender Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('gender', Lang::get('messages.register/gender')) }}
                            {{ Form::select('gender', array(null => Lang::get('messages.register/genderempty'), 'Male' => Lang::get('messages.register/male'), 'Female' => Lang::get('messages.register/female')), null, ['class' => 'form-control'] ) }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Nationality Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('nationality', Lang::get('messages.register/nationality')) }}
                            {{ Form::select('nationality', array(null => Lang::get('messages.register/nationalityempty')) + $countryNames, null, ['class' => 'form-control'] ) }}
                        </div>

                        <!-- BirthDate Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('birthDate', Lang::get('messages.register/birthDate')) }}
                            {{ Form::input('date', 'birthDate', null, ['class' => 'form-control'] ) }}
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <!-- Password Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('password', Lang::get('messages.register/password')) }}
                            {{ Form::password('password', ['class' => 'form-control'] ) }}
                        </div>

                        <!-- Password Confirmation Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('password_confirmation', Lang::get('messages.register/passwordConfirmation')) }}
                            {{ Form::password('password_confirmation', ['class' => 'form-control'] ) }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Email Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('email', Lang::get('messages.register/email')) }}
                            {{ Form::email('email', null, ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>

                <p style="color: white; font-size:11px; text-align: justify; padding: 10px;">{{ Lang::get('messages.register/lopd') }}</p>

                <hr>

                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class = "text-center form-group">
                            {{ Form::submit(Lang::get('messages.register/submit'), ['class' => 'btn btn-default register-btn form-control']) }}
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection


