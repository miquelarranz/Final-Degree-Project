@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @foreach ($sources as $source)
                <p> {{ $source->url }} </p>
            @endforeach
        </div>
    </div>

@endsection


