@extends('layouts.main')

@section('title', $album->title . ' - ' . $album->bands->first()->name)
@section('description', $album->title . ' by ' . $album->bands->first()->name . ' reviews and information in Heavy Metal Encyclopedia')
@section('body-class', 'body-album')
@inject('parser', 'App\Helpers\Parser')
@inject('albumHelper', 'App\Helpers\Album')

@section('navigation')
    @include('layouts._nav')
@endsection

@section('content')

    <header class="header album-header
        @if($album->image)
            header--has-image
        @endif
        ">
        <div class="header-background"
        @if($album->image)
            style="background-image: url({{ $album->image }});"
        @endif
        ></div>

        <div class="container">


        <div class="container">
           <div class="header-container">
                @if($album->image)
                <div class="header-avatar">
                    <div class="header-avatar-wrapper">
                        <img src="{{ $album->image }}">
                    </div>
                </div>
                @endif
                <div class="header-content">

                    <h2 class="header-subtitle">
                        {!! $albumHelper->bandLinks($album) !!}
                    </h2>

                    <div class="header-title-wrapper">
                        <h1 class="header-title"><a href="{{ $album->permalink }}">{{ $album->title }}</a></h1>
                        @includeWhen($album->review_count, 'partials._review-score')
                    </div>

                </div>
            </div>
        </div>
    </div>
    </header>

    <div class="header-secondary header--has-image">
        <div class="container">
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
                    <li>
                        <div class="header-metadata-actions">
                        <a target="_blank" class="header-metadata-action header-metadata-action--youtube" href="{{ $album->youtube_search_link }}"><i class="fa fa-youtube-play"></i></a></div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="section-title-wrapper">
                        <h2 class="section-title">{{ $album->title }} reviews</h2>
                    </div>
                    @forelse($album->reviews as $review)
                        <div class="review">
                            <div class="review-score">
                            <span class="review-score-points review-score-{{ round($review->score, -1) }}">{{ $review->score }}%</span>
                            </div>
                            <div class="review-content">
                                <h5 class="review-author"><a href="https://www.metal-archives.com/users/{{ $review->author }}" target="_blank">{{ $review->author }}</a> on {{ $review->published_at->format('F jS, Y') }}</h5>
                                <h4 class="review-title">{{ $review->title }}</h4>
                                <div class="review-body">{!! $parser->nl2p($review->body) !!}</div>
                                <a class="btn btn-default" href="javascript:void(0)" onclick="$(this).siblings('.review-body').toggleClass('review-body--is-open');$(this).addClass('hidden');">Read more</a>
                            </div>
                        </div>
                    @empty
                    <div>There are no reviews yet</div>
                    @endforelse
                </div>

                <div class="col-md-4">
                    @if($album->songs->count())
                    <div class="section-title-wrapper">
                        <h3 class="section-title">{{ $album->title }} track list</h3>
                    </div>
                    <table class="table table-condensed">
                        @foreach($album->songs as $song)
                        <tr><td>{{ $song->order }}</td><td>{{ $song->title }}</td><td>{{ $song->length }}</td></tr>
                        @endforeach
                    </table>
                    @endif

                    @if($album->lineup->count())
                    <div class="section-title-wrapper">
                        <h3 class="section-title">{{ $album->title }} lineup</h3>
                    </div>

                    <table class="table table-condensed">
                        @foreach($album->lineup as $lineup)
                        <tr><td>{{ $lineup->name }}</td><td>{{ $lineup->role }}</td></tr>
                        @endforeach
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection