@extends('layouts.auth')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.partials.errors')

            <h1 class="text-center white-color title-margin">@lang('messages.profile/title')</h1>

            <div class="profile-container">
                <div class="row text-centered">
                    <div class="col-xs-6">
                        @lang('messages.profile/name')
                    </div>
                    <div class="col-xs-6">
                        {{ $currentUser->relatedPerson->thing->name }} {{ $currentUser->relatedPerson->familyName }}
                    </div>
                </div>

                <div class="row text-centered">
                    <div class="col-xs-6">
                        @lang('messages.profile/email')
                    </div>
                    <div class="col-xs-6">
                        {{ Str::limit($currentUser->email, 15) }}
                    </div>
                </div>
                <div class="row text-centered">
                    <div class="col-xs-6">
                        @lang('messages.profile/birthDate')
                    </div>
                    <div class="col-xs-6">
                        {{ $currentUser->relatedPerson->birthDate }}
                    </div>
                </div>
                <div class="row text-centered">
                    <div class="col-xs-6">
                        @lang('messages.profile/gender')
                    </div>
                    <div class="col-xs-6">
                        {{ $currentUser->relatedPerson->gender }}
                    </div>
                </div>
                <div class="row text-centered">
                    <div class="col-xs-6">
                        @lang('messages.profile/nationality')
                    </div>
                    <div class="col-xs-6">
                        {{ Str::limit($currentUser->relatedPerson->countryNationality->administrativeArea->place->thing->name, 15) }}
                    </div>
                </div>
            </div>
            <div class="row text-center profile-modify-button">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class = "text-center form-group">
                        <a href="{{ URL::route('profile_modify_path') }}" class="btn btn-default form-control">@lang('messages.profile/button')</a>
                    </div>
                </div>
            </div>

            <div class="row text-center profile-delete-button">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class = "text-center form-group">
                        <a href="{{ URL::route('profile_delete_path') }}" class="btn btn-danger form-control">@lang('messages.profile/delete')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


