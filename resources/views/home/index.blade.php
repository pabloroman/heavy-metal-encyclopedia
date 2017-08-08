@extends('layouts.main')

@section('body-class', 'body-homepage')

@section('navigation')

<div class="homepage">

    <section class="hero">

        @include('layouts._nav', ['position' => 'home'])

        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="text-center">
                        <h1 class="hero__tagline">Heavy Metal Encylopedia</h1>
                        <p class="hero__description lead">There are currently {{ number_format($bandCount) }} bands, {{ number_format($albumCount) }} albums and {{ number_format($reviewCount) }} reviews in {{ config('app.name') }}.</p>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="section">
        <div class="container">
            <div class="section-title-wrapper">
                <h2 class="section-title">Featured playlists</h2>
            </div>

            @foreach($playlists as $playlist)
            <div class="section-title-wrapper">
                <h3 class="section-title">{{ $playlist->title }}</h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="album-grid">
                    @foreach($playlist->albums as $album)
                        @include('partials._album-grid-item', ['hasBands' => true])
                    @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>

@endsection
