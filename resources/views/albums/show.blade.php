@extends('layouts.main')

@section('navigation')
    @include('layouts._nav')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $album->title }}</h1>
                <h2>{{ implode('/', $album->bands->pluck('name')->toArray()) }}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <p>{{ $album->type }}</p>
                <p>{{ $album->label }}</p>
                <p>{{ $album->published_at->format('F d Y') }}</p>
            </div>

            <div class="col-md-8">
                <img src="{{ $album->image }}" width="400" height="400">
            </div>
        </div>
    </div>

@endsection