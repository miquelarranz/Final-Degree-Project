@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @foreach ($sources as $source)
                <p>{{ $source->id }} - {{ $source->url }}</p>
                <div class = "text-center form-group">
                    <a href="{{ URL::route('source_edit_path', array('id' => $source->id)) }}" class="btn btn-default form-control">@lang('messages.source/edit')</a>
                </div>
                <div class = "text-center form-group">
                    <a href="{{ URL::route('source_destroy_path', array('id' => $source->id)) }}" class="btn btn-default form-control">@lang('messages.source/destroy')</a>
                </div>
                <hr>
            @endforeach

            <div class = "text-center form-group">
                <a href="{{ URL::route('source_new_path') }}" class="btn btn-default form-control">@lang('messages.source/create')</a>
            </div>
        </div>
    </div>

@endsection


