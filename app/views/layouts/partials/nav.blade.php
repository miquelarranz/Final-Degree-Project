<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-button navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Logo</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>{{ link_to_route('home', 'Home') }}</li>
                <li>{{ link_to_route('register_path', 'Register') }}</li>
                <li>{{ link_to_route('login_path', 'Login') }}</li>
                <li>
                    <a class="nav-language-container">
                        {{ Form::open() }}
                            {{ Form::select('city', array('ES', 'CAT'), null, ['class' => 'form-control nav-language-select', 'required' => 'required']) }}
                        {{ Form::close() }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>