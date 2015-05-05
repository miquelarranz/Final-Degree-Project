@extends('layouts.auth')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center white-color title-margin">@lang('messages.profile/title')</h1>

            @include('layouts.partials.errors')

            {{ Form::open(array('route' => 'profile_modify_path')) }}
                <div class="row">
                    <div class="col-md-6">
                        <!-- Name Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('name', Lang::get('messages.register/name')) }}
                            {{ Form::text('name', $currentUser->relatedPerson->thing->name, ['class' => 'form-control'] ) }}
                        </div>

                        <!-- LastName Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('lastName', Lang::get('messages.register/lastName')) }}
                            {{ Form::text('lastName', $currentUser->relatedPerson->familyName, ['class' => 'form-control'] ) }}
                        </div>

                        <!-- Gender Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('gender', Lang::get('messages.register/gender')) }}
                            {{ Form::select('gender', array(null => Lang::get('messages.register/genderempty'), 'Male' => Lang::get('messages.register/male'), 'Female' => Lang::get('messages.register/female')), $currentUser->relatedPerson->gender, ['class' => 'form-control'] ) }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Nationality Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('nationality', Lang::get('messages.register/nationality')) }}
                            {{ Form::select('nationality', array(null => Lang::get('messages.register/nationalityempty')) + $countryNames, $currentUser->relatedPerson->nationality, ['class' => 'form-control'] ) }}
                        </div>

                        <!-- BirthDate Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('birthDate', Lang::get('messages.register/birthDate')) }}
                            {{ Form::input('date', 'birthDate', $currentUser->relatedPerson->birthDate, ['class' => 'form-control'] ) }}
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <!-- Password Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('password', Lang::get('messages.profile/password')) }}
                            {{ Form::password('password', ['class' => 'form-control'] ) }}
                        </div>

                        <!-- Password Confirmation Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('password_confirmation', Lang::get('messages.profile/passwordConfirmation')) }}
                            {{ Form::password('password_confirmation', ['class' => 'form-control'] ) }}
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class = "text-center form-group">
                            {{ Form::submit(Lang::get('messages.profile/button'), ['class' => 'btn btn-default form-control']) }}
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection


