@extends('layouts.main')

@inject('parser', 'App\Helpers\Parser')

@section('navigation')
    @include('layouts._nav')
@endsection

@section('content')

    <header class="header album-header">
        <div
        @if($album->image)
            class="header-background header-background--has-image" style="background-image: url({{ $album->image }});"
        @else
            class="header-background"
        @endif
        ></div>

        <div class="container">
            <div class="flexy">
                @if($album->image)
                <div class="header-avatar">
                    <div class="header-avatar-wrapper">
                        <img src="{{ $album->image }}">
                    </div>
                </div>
                @endif
                <div class="header-content">
                    <div class="header-title-wrapper">
                        <h1 class="header-title"><a href="{{ route('showAlbum', [$album->slug, $album->id]) }}">{{ $album->title }}</a></h1>
                        @if($album->score)
                        <span class="label header-label">{{ $album->score }}</span>
                        @endif
                    </div>

                    <h2 class="header-subtitle">{{ implode('/', $album->bands->pluck('name')->toArray()) }}</h2>

                    <div class="header-metadata">
                        <ul>
                            <li>
                                <h4>Type</h4>
                                <p>{{ $album->type }}</p>
                            </li>
                            <li>
                                <h4>Label</h4>
                                <p>{{ $album->label }}</p>
                            </li>
                            <li>
                                <h4>Release date</h4>
                                <p>{{ $album->published_at->format('F d Y') }}</p>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3>{{ $album->title }} reviews</h3>
                @foreach($album->reviews as $review)
                    <h4>{{ $review->title }}</h4>
                    <h5>By <a href="https://www.metal-archives.com/users/{{ $review->author }}" target="_blank">{{ $review->author }}</a> on {{ $review->published_at->format('F d Y') }}</h5>
                    <div>{!! $parser->nl2p($review->body) !!}</div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>

@endsection