<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand sidebar-logo">
            <img src="/images/logo.png" style="width: 60px; height: 60px; margin: 0 auto;" class="img-responsive"/>
        </li>
        <li>
            <a href="{{ URL::route('profile_path') }}"><span class="sidebar-icons glyphicon glyphicon-user" aria-hidden="true"></span>@lang('messages.sidebar/profile')</a>
        </li>
        <li>
            <a href="{{ URL::route('events_path') }}"><span class="sidebar-icons glyphicon glyphicon-search" aria-hidden="true"></span>@lang('messages.sidebar/search')</a>
        </li>
        <li>
            <a href="{{ URL::route('event_subscriptions_path') }}"><span class="sidebar-icons glyphicon glyphicon-star" aria-hidden="true"></span>@lang('messages.sidebar/favorite')</a>
        </li>
        <li>
            <a href="{{ URL::route('logout_path') }}"><span class="sidebar-icons glyphicon glyphicon-log-out" aria-hidden="true"></span>@lang('messages.home/logout')</a>
        </li>
        <li class="sidebar-language-container">
            <a class="sidebar-language-content">
                {{ Form::open(array('route' => 'language_path', 'id' => 'language-form', 'class' => 'inline-form')) }}
                    {{ Form::label('language', Lang::get('messages.sidebar/language'), ['class' => 'sidebar-language-label']) }}
                    {{ Form::select('language', array('es' => 'ES', 'cat' => 'CAT', 'en' => 'EN'), Session::get('language'), ['class' => 'form-control sidebar-language-select', 'required' => 'required', 'onchange'=>'submit()']) }}
                {{ Form::close() }}
            </a>
            <p class="manual">
                    <a href="{{ URL::route('manual_path') }}"><span class="sidebar-icons glyphicon glyphicon-cloud-download" aria-hidden="true"></span>@lang('messages.home/guide2')</a>
            </p>
        </li>
    </ul>
</div>

