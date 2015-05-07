<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 data-toggle="collapse" class="text-center panel-title" href="#filters" aria-expanded="true" aria-controls="collapseOne">
                    <a class="filters-title">
                        @lang('messages.filters/title')
                    </a>
                </h3>
            </div>
            <div class="panel-collapse collapse" id="filters">
                <div class="panel-body">
                    {{ Form::open(array('route' => 'filter_path')) }}
                    <div class="row">
                        <div class="col-sm-6">
                            <div class = "form-group register-input">
                                {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.filters/name')] ) }}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class = "form-group register-input">
                                {{ Form::text('type', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.filters/type')] ) }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class = "form-group register-input">
                                {{ Form::label('startDate', Lang::get('messages.filters/startDate'), ['class' => 'filters-label']) }}
                                {{ Form::text('startDate', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'placeholder' => Lang::get('messages.filters/date')] ) }}
                            </div>
                            <div class = "form-group register-input">
                                {{ Form::text('startTime', null, ['class' => 'form-control timepicker', 'autocomplete' => 'off', 'placeholder' => Lang::get('messages.filters/time')] ) }}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class = "form-group register-input">
                                {{ Form::label('endDate', Lang::get('messages.filters/endDate'), ['class' => 'filters-label']) }}
                                {{ Form::text('endDate', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'placeholder' => Lang::get('messages.filters/date')] ) }}
                            </div>
                            <div class = "form-group register-input">
                                {{ Form::text('endTime', null, ['class' => 'form-control timepicker', 'autocomplete' => 'off', 'placeholder' => Lang::get('messages.filters/time')] ) }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class = "form-group register-input">
                                {{ Form::select('city', array(null => Lang::get('messages.filters/cityempty')) + $cities, null, ['class' => 'form-control'] ) }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <div class = "text-center form-group">
                                {{ Form::submit(Lang::get('messages.filters/submit'), ['class' => 'btn btn-default filters-btn form-control']) }}
                            </div>
                        </div>
                    </div>

                {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>