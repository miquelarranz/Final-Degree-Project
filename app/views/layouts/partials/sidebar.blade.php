<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand sidebar-logo">
            Logo
        </li>
        <li>
            <a href="{{ URL::route('profile_path') }}"><span class="sidebar-icons glyphicon glyphicon-user" aria-hidden="true"></span>@lang('messages.sidebar/profile')</a>
        </li>
        <li>
            <a href="#"><span class="sidebar-icons glyphicon glyphicon-search" aria-hidden="true"></span>@lang('messages.sidebar/search')</a>
        </li>
        <li>
            <a href="#"><span class="sidebar-icons glyphicon glyphicon-star" aria-hidden="true"></span>@lang('messages.sidebar/favorite')</a>
        </li>
        <li class="sidebar-language-container">
            <a class="sidebar-language-content">
                {{ Form::open(array('route' => 'language_path', 'id' => 'language-form', 'class' => 'inline-form')) }}
                    {{ Form::label('language', Lang::get('messages.sidebar/language'), ['class' => 'sidebar-language-label']) }}
                    {{ Form::select('language', array('es' => 'ES', 'cat' => 'CAT', 'en' => 'EN'), Session::get('language'), ['class' => 'form-control sidebar-language-select', 'required' => 'required', 'onchange'=>'submit()']) }}
                {{ Form::close() }}
            </a>
        </li>
    </ul>
</div>

