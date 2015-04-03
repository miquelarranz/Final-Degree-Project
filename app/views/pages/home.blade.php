@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.partials.errors')
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <img src="/images/skyline-home.jpg" class="home-skyline img-responsive"/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            {{ Form::open() }}
                <div class="row">
                    <div class = "form-group col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3">
                        {{ Form::select('city', array('Barcelona', 'London'), null, ['class' => 'form-control', 'required' => 'required']) }}
                    </div>
                </div>
                <div class="row">
                    <div class = "col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3">
                        <h4 class="home-title-search text-center">Start looking for events right now!</h4>
                        <div class="input-group">
                            {{ Form::text('keyword', null, ['class' => 'form-control', 'required' => 'required']) }}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            </span>
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
    <div class="row">
        <div class = "col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2">
            <p class="text-center home-users-guide-text">
                {{ link_to_route('home', 'Do you need some help? Download the users guide here!') }}
            </p>
        </div>
    </div>
@endsection


