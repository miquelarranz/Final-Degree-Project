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
                                <div style="margin-top: 20px;" class="row">
                                    <div class="col-sm-6">
                                        <div class = "form-group register-input">
                                            {{ Form::label('startDate', Lang::get('messages.filters/startDate'), ['class' => 'filters-label']) }}
                                            {{ Form::text('startDate', $startDate, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'placeholder' => Lang::get('messages.filters/date')] ) }}
                                        </div>
                                        <div class = "form-group register-input">
                                            {{ Form::text('startTime', $startTime, ['class' => 'form-control timepicker', 'autocomplete' => 'off', 'placeholder' => Lang::get('messages.filters/time')] ) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class = "form-group register-input">
                                            {{ Form::label('endDate', Lang::get('messages.filters/endDate'), ['class' => 'filters-label']) }}
                                            {{ Form::text('endDate', $endDate, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'placeholder' => Lang::get('messages.filters/date')] ) }}
                                        </div>
                                        <div class = "form-group register-input">
                                            {{ Form::text('endTime', $endTime, ['class' => 'form-control timepicker', 'autocomplete' => 'off', 'placeholder' => Lang::get('messages.filters/time')] ) }}
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="google-add-button btn btn-default" type="button">@lang("messages.google/add")</button>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


