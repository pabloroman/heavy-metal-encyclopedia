<nav class="navbar navbar-{{ $position or 'default' }}">
    <div class="container">
        <div class="flexy">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
        </div>

        <form class="navbar-form navbar-right" action="{{ route('search') }}" method="get">
            <div class="form-group">
                <input class="form-control" placeholder="Search" type="text" name="q">
            </div>
        </form>
        </div>
    </div>
</nav>