@extends('layouts.main')

@inject('albumHelper', 'App\Helpers\Album')

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
                <h2 class="section-title">Trending albums</h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="grid album-grid-wrapper">
                    @foreach($trendingAlbums as $album)
                    <div class="album-grid">
                        <a href="{{ $album->permalink }}">
                            <img class="album-grid-image" src="{{ $album->image }}">
                        </a>
                        <h3 class="album-grid-title"><a href="{{ $album->permalink }}">{{ $album->title }}</a></h3>
                        <h4 class="album-grid-subtitle">{!! $albumHelper->bandLinks($album) !!}</h4>
                    </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
