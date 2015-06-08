<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-button navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <img src="/images/logo.png" style="width: 40px; height: 40px; margin-top: 5px; margin-left: 15px;" class="img-responsive"/>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>{{ link_to_route('home', Lang::get('messages.home/home')) }}</li>
                @if($currentUser)
                    <li>{{ link_to_route('logout_path', Lang::get('messages.home/logout')) }}</li>
                @else
                    <li>{{ link_to_route('register_path',  Lang::get('messages.home/register')) }}</li>
                    <li>{{ link_to_route('login_path',  Lang::get('messages.home/login')) }}</li>
                @endif
                <li>
                    <a class="nav-language-container">
                        {{ Form::open(array('route' => 'language_path', 'id' => 'language-form')) }}
                            {{ Form::select('language', array('es' => 'ES', 'cat' => 'CAT', 'en' => 'EN'), Session::get('language'), ['class' => 'form-control nav-language-select', 'required' => 'required', 'onchange'=>'submit()']) }}
                        {{ Form::close() }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>