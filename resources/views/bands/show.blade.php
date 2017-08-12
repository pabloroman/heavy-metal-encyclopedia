@extends('layouts.main')

@section('body-class', 'body-band')
@section('navigation')
    @include('layouts._nav')
@endsection

@section('content')

    <header class="header band-header
        @if($band->image)
            header--has-image
        @endif
    ">

        <div class="header-background"
        @if($band->image)
            style="background-image: url({{ $band->image }});"
        @endif
        ></div>

        <div class="container">
            <div class="header-container">
                @if($band->image)
                <div class="header-avatar">
                    <div class="header-avatar-wrapper">
                        <img src="{{ $band->image }}">
                    </div>
                </div>
                @endif
                <div class="header-content">
                    <div class="header-title-wrapper">
                        <h1 class="header-title"><a href="{{ $band->permalink }}">{{ $band->name }}</a></h1>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="header-secondary
        @if($band->image)
            header--has-image
        @endif
    ">
        <div class="container">
            <div class="header-metadata">
                <ul>
                    <li>
                        <h4>Country</h4>
                        <p>{{ $band->country }}</p>
                    </li>
                    <li>
                        <h4>Genre</h4>
                        <p>{{ $band->genre }}</p>
                    </li>
                    <li>
                        <h4>Lyrical themes</h4>
                        <p>{{ $band->lyrical_themes }}</p>
                    </li>
                    <li>
                        <h4>Formed in</h4>
                        <p>{{ $band->founded_at }}</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title-wrapper">
                        <h2 class="section-title">{{ $band->name }} discography</h2>
                    </div>

                    <section class="section">
                        <h3>Full-length albums</h3>
                        <div class="album-grid">
                            @foreach($band->albums->where('type', 'Full-length') as $album)
                                @include('partials._album-grid-item')
                            @endforeach
                        </div>

                        <h3>Other releases</h3>
                        <div class="album-grid">
                            @foreach($band->albums->where('type', '!=', 'Full-length') as $album)
                                @include('partials._album-grid-item')
                            @endforeach
                        </div>

                    </section>
                </div>

            </div>
        </div>
    </section>

@endsection