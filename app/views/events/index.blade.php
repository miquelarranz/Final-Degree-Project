@extends('layouts.auth')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.partials.errors')

            @include('events.partials.filters')

            <h1 class="text-center white-color title-margin">Events list</h1>

        </div>
    </div>

@endsection


