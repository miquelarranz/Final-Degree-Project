@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center white-color title-margin">@lang('messages.source/title')</h1>

            @if(count($sources) > 0)
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    @foreach ($sources as $source)
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading{{ $source->id }}">
                                <div class="panel-title" style="display:inline-block; width: 69%">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $source->id }}" aria-expanded="true" aria-controls="collapse{{ $source->id }}">
                                        {{ $source->description }}
                                    </a>
                                </div>
                                <div class="panel-title" style="display:inline-block; width: 30%">
                                    <a href="{{ URL::route('source_destroy_path', array('id' => $source->id)) }}">
                                        <span style="padding-left: 15px" class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                    </a>
                                    <a href="{{ URL::route('source_edit_path', array('id' => $source->id)) }}">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                    </a>
                                </div>
                            </div>
                            <div id="collapse{{ $source->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{ $source->id }}">
                                <div class="panel-body">
                                    <p><b style="padding-right: 10px;">@lang('messages.source/url'):</b> {{ $source->url }}</p>
                                    <p><b style="padding-right: 10px;">@lang('messages.source/city'):</b> {{ utf8_decode($source->relatedCity->name) }}</p>
                                    <p><b style="padding-right: 10px;">@lang('messages.source/extension'):</b> {{ $source->extension }}</p>
                                    <p><b style="padding-right: 10px;">@lang('messages.source/interval'):</b> {{ $source->updateInterval }}</p>
                                    <p><b style="padding-right: 10px;">@lang('messages.source/updateDate'):</b> {{ $source->lastUpdateDate }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="text-center panel-title">
                            @lang('messages.sources/noSourcesTitle')
                        </h3>
                    </div>
                    <div class="text-center panel-body">
                        @lang('messages.sources/noSourcesText')
                    </div>
                </div>
            @endif

            <div class = "text-center form-group">
                <a href="{{ URL::route('source_new_path') }}" class="btn btn-warning form-control">@lang('messages.sources/create')</a>
            </div>
            <div class = "text-center form-group">
                <a href="{{ URL::route('sources_update_path') }}" class="btn btn-info form-control">@lang('messages.sources/update')</a>
            </div>
        </div>
    </div>

@endsection


