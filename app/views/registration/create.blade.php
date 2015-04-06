@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center white-color title-margin">Register</h1>

            @include('layouts.partials.errors')

            {{ Form::open(array('route' => 'register_path')) }}
                <div class="row">
                    <div class="col-md-6">
                        <!-- Name Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('name', 'Name:') }}
                            {{ Form::text('name', null, ['class' => 'form-control'] ) }}
                        </div>

                        <!-- LastName Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('lastName', 'Last Name:') }}
                            {{ Form::text('lastName', null, ['class' => 'form-control'] ) }}
                        </div>

                        <!-- Gender Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('gender', 'Gender:') }}
                            {{ Form::select('gender', array(null => 'Select a gender', 'Male' => 'Male', 'Female' => 'Female'), null, ['class' => 'form-control'] ) }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Nationality Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('nationality', 'Nationality:') }}
                            {{ Form::select('nationality', array(null => 'Select a country') + $countryNames, null, ['class' => 'form-control'] ) }}
                        </div>

                        <!-- BirthDate Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('birthDate', 'Birth Date:') }}
                            {{ Form::input('date', 'birthDate', null, ['class' => 'form-control'] ) }}
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <!-- Password Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('password', 'Password:') }}
                            {{ Form::password('password', ['class' => 'form-control'] ) }}
                        </div>

                        <!-- Password Confirmation Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('password_confirmation', 'Password Confirmation:') }}
                            {{ Form::password('password_confirmation', ['class' => 'form-control'] ) }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Email Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('email', 'Email:') }}
                            {{ Form::email('email', null, ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>

                <hr>

                {{-- <div class="row">
                    <div class="col-md-6">
                        <!-- StreetAddress Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('streetAddress', 'Address:') }}
                            {{ Form::text('streetAddress', null, ['class' => 'form-control'] ) }}
                        </div>

                        <!-- AddressLocality Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('addressLocality', 'Locality:') }}
                            {{ Form::text('addressLocality', null, ['class' => 'form-control'] ) }}
                        </div>

                        <!-- AddressRegion Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('addressRegion', 'Region:') }}
                            {{ Form::text('addressRegion', null, ['class' => 'form-control'] ) }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- PostalCode Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('postalCode', 'Postal Code:') }}
                            {{ Form::text('postalCode', null, ['class' => 'form-control'] ) }}
                        </div>

                        <!-- Country Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('country', 'Country:') }}
                            {{ Form::text('country', null, ['class' => 'form-control'] ) }}
                        </div>
                    </div>
                </div>

                <hr> --}}

                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class = "text-center form-group">
                            {{ Form::submit('Sign Up', ['class' => 'btn btn-default register-btn form-control']) }}
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection


