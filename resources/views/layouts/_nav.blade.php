<nav class="navbar navbar-{{ $position ?? 'default' }}">
    <div class="container">
        <div class="flexy">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url('/') }}">
                <span class="hidden-xs">{{ config('app.name') }}</span>
                <span class="visible-xs-block">HME</span>
            </a>
        </div>

        <form class="navbar-form navbar-right" action="{{ route('search') }}" method="get">
            <div class="form-group has-feedback">
                <i class="fa fa-search form-control-feedback" aria-hidden="true"></i>
                <input class="form-control" placeholder="Search" type="text" name="q">
            </div>
        </form>
        </div>
    </div>
</nav>