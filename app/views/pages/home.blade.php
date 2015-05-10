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
            {{ Form::open(array('route' => 'filter_path')) }}
                <div class="row">
                    <div class = "form-group col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3">
                        {{ Form::select('city', array(null => Lang::get('messages.filters/cityempty')) + $cities, null, ['class' => 'form-control', 'required' => 'required']) }}
                    </div>
                </div>
                <div class="row">
                    <div class = "col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3">
                        <h4 class="home-title-search text-center">@lang('messages.home/searchtext')</h4>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="home-search glyphicon glyphicon-search" aria-hidden="true"></span>
                            </span>
                            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.filters/name')] ) }}
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default home-button" type="button">@lang("messages.home/search")</button>
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
                {{ link_to_route('home', Lang::get("messages.home/guide")) }}
            </p>
        </div>
    </div>
@endsection


