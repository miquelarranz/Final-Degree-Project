@extends(Auth::user() ? 'layouts.auth' : 'layouts.default')

@section('content')
    <div class="row">
        <div class=" col-md-12">
            @include('layouts.partials.errors')
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            <h4>@lang("messages.google/title")</h4>
                        </div>
                        <div class="panel-body text-center">
                            {{ Form::open(array('route' => 'add_event_path')) }}
                                {{ Form::select('calendar', $calendars, null, ['class' => 'form-control', 'required' => 'required'] ) }}

                                <button type="submit" class="google-add-button btn btn-default" type="button">@lang("messages.google/add")</button>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


