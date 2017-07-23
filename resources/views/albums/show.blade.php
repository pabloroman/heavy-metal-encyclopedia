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
                        <h1 class="header-title"><a href="{{ $album->permalink }}">{{ $album->title }}</a></h1>
                        @if($album->review_count)
                        <span class="label header-label">{{ $album->median_score }}% ({{ $album->review_count }} {{ str_plural('review', $album->review_count) }})</span>
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
                                <p>{{ $album->published_at->format('F jS, Y') }}</p>
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
                @foreach($album->reviews->sortByDesc('published_at') as $review)
                    <div class="review">
                    <h4 class="review-title">{{ $review->title }} - {{ $review->score }}%</h4>
                    <h5 class="review-author">By <a href="https://www.metal-archives.com/users/{{ $review->author }}" target="_blank">{{ $review->author }}</a> on {{ $review->published_at->format('F jS, Y') }}</h5>
                    <div class="review-content">{!! $parser->nl2p($review->body) !!}</div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>

@endsection