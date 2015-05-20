@extends('layouts.auth')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center white-color title-margin">@lang('messages.communicate/title')</h1>

            @include('layouts.partials.errors')

            {{ Form::open(array('route' => array('communicate_path', 'id' => $performer->id))) }}
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <!-- From Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('from', Lang::get('messages.communicate/from')) }}
                            {{ Form::text('from', $currentUser->email, ['class' => 'form-control', 'readonly'] ) }}
                        </div>

                        <!-- To Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('to', Lang::get('messages.communicate/to')) }}
                            {{ Form::text('to', $performer->email, ['class' => 'form-control',  'readonly'] ) }}
                        </div>

                        <!-- Subject Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('subject', Lang::get('messages.communicate/subject')) }}
                            {{ Form::text('subject', null, ['class' => 'form-control'] ) }}
                        </div>

                        <!-- Message Form Input -->
                        <div class = "form-group register-input">
                            {{ Form::label('message', Lang::get('messages.communicate/message')) }}
                            {{ Form::textarea('message', null, ['class' => 'form-control'] ) }}
                        </div>


                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class = "text-center form-group">
                            {{ Form::submit(Lang::get('messages.communicate/submit'), ['class' => 'btn btn-default register-btn form-control']) }}
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection


