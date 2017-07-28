@extends('layouts.main')

@section('body-class', 'body-band')
@section('navigation')
    @include('layouts._nav')
@endsection

@section('content')

    <header class="header band-header">

        <div
        @if($band->image)
            class="header-background header-background--has-image" style="background-image: url({{ $band->image }});"
        @else
            class="header-background"
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
                        <div class="album-grid">
                            @foreach($band->albums as $album)
                                @include('partials._album-grid-item')
                            @endforeach
                        </div>
<!--
                    <div class="table-responsive">
                        <table class="table album-table">

                        @foreach($band->albums as $album)
                        <tr class="album-row album-row--is-{{ $album->typeSlug }}">
                            <td>
                                <div><a href="{{ $album->permalink }}">{{ $album->title }}</a></div>
                                <div>{{ $album->published_at->format('Y') }} &middot; {{ $album->type }}</div>
                                <div>{{ $album->label }}</div>
                            </td>
                            <td>
                        @if($album->review_count)
                        <div class="review-wrapper">
                            <span class="review-score review-score-{{ round($album->median_score, -1) }}">{{ $album->median_score }}%</span><br>
                            <span class="review-count">{{ $album->review_count }} {{ str_plural('review', $album->review_count) }}</span>
                        </div>
                        @endif
                            </td>
                        </tr>
                        @endforeach
                        </table>
                    </div>
-->
                    </section>
                </div>

<!--
                <div class="col-md-3">
                    <div class="section-title-wrapper">
                        <h3 class="section-title">Latest reviews</h3>
                    </div>

                    <div class="section-title-wrapper">
                        <h3 class="section-title">Similar artists</h3>
                    </div>
                </div>
-->
            </div>
        </div>
    </section>

@endsection