@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center white-color title-margin">@lang('messages.source/editTitle')</h1>

            @include('layouts.partials.errors')

            {{ Form::open(array('route' => array('source_edit_path', 'id' => $source->id), 'files' => true, 'method' => 'put')) }}
                <div class="row">
                    <div class="col-md-6">
                        <!-- Url Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('url', Lang::get('messages.source/url')) }}
                            {{ Form::text('url', $source->url, ['class' => 'form-control'] ) }}
                        </div>

                        <!-- Description Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('description', Lang::get('messages.source/description')) }}
                            {{ Form::text('description', $source->description, ['class' => 'form-control'] ) }}
                        </div>

                        <!-- Extension Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('extension', Lang::get('messages.source/extension')) }}
                            {{ Form::select('extension', array('JSON' => 'JSON', 'XML' => 'XML'), $source->extension, ['class' => 'form-control'] ) }}
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
                            {{ Form::select('city', $cities, $source->city, ['class' => 'form-control'] ) }}
                        </div>

                        <div class = "form-group register-input">
                            {{ Form::label('new_city', Lang::get('messages.source/newCity')) }}
                            {{ Form::text('new_city', null, ['class' => 'form-control']) }}
                        </div>

                        <!-- UpdateInterval Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('updateInterval', Lang::get('messages.source/interval')) }}
                            {{ Form::selectRange('updateInterval', 1, 365, $source->updateInterval, ['class' => 'form-control'] ) }}
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class = "text-center form-group">
                            {{ Form::submit(Lang::get('messages.source/editTitle2'), ['class' => 'btn btn-default register-btn form-control']) }}
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection


