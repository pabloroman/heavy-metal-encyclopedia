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
            <div class="flexy">
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
                        <span class="label header-label-{{ str_slug($band->status) }} header-label">{{ $band->status }}</span>
                    </div>

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
        </div>
    </header>

    <div class="container">

        <div class="row">

            <div class="col-md-12">
                <div class="section-title-wrapper">
                <h2 class="section-title">{{ $band->name }} discography</h2>
                </div>

                <div class="table-responsive">
                    <table class="table album-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Year</th>
                                <th>Label</th>
                                <th>Rating</th>
                            </tr>
                        </thead>
                    @foreach($band->albums as $album)
                    <tr class="album-row album-row--is-{{ str_slug($album->type) }}">
                        <td><a href="{{ $album->permalink }}">{{ $album->title }}</a></td>
                        <td>{{ $album->type }}</td>
                        <td>{{ $album->published_at->format('Y') }}</td>
                        <td>{{ $album->label }}</td>
                        <td>@if($album->review_count) {{ $album->median_score }}% ({{ $album->review_count }} {{ str_plural('review', $album->review_count) }})@endif</td>
                    </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection