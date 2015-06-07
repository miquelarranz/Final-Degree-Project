@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center white-color title-margin">@lang('messages.sources/create')</h1>

            @include('layouts.partials.errors')

            {{ Form::open(array('route' => 'source_new_path', 'files' => true)) }}
                <div class="row">
                    <div class="col-md-6">
                        <!-- Url Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('url', Lang::get('messages.source/url')) }}
                            {{ Form::text('url', null, ['class' => 'form-control'] ) }}
                        </div>

                        <!-- Description Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('description', Lang::get('messages.source/description')) }}
                            {{ Form::text('description', null, ['class' => 'form-control'] ) }}
                        </div>

                        <!-- Extension Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('extension', Lang::get('messages.source/extension')) }}
                            {{ Form::select('extension', array('JSON' => 'JSON', 'XML' => 'XML'), 'JSON', ['class' => 'form-control'] ) }}
                        </div>

                        <!-- ConfigurationFilePath Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('configurationFile', Lang::get('messages.source/configurationFile')) }}
                            {{ Form::file('configurationFile', null, ['class' => 'form-control'] ) }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- City Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('city', Lang::get('messages.source/city')) }}
                            {{ Form::select('city', $cities, null, ['class' => 'form-control'] ) }}
                        </div>

                        <div class = "form-group register-input">
                            {{ Form::label('new_city', Lang::get('messages.source/newCity')) }}
                            {{ Form::text('new_city', null, ['class' => 'form-control']) }}
                        </div>

                        <!-- UpdateInterval Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('updateInterval', Lang::get('messages.source/interval')) }}
                            {{ Form::selectRange('updateInterval', 1, 365, 1, ['class' => 'form-control'] ) }}
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class = "text-center form-group">
                            {{ Form::submit(Lang::get('messages.sources/create'), ['class' => 'btn btn-default register-btn form-control']) }}
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection


