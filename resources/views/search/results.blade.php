@extends('layouts.main')

@section('navigation')
    @include('layouts._nav')
@endsection

@section('content')

   <header class="header">
       <div class="header-background"></div>
        <div class="container">
            <div class="flexy">
                <div class="header-content">
                    <div class="header-title-wrapper">
                        <h1 class="header-title">Search results for {{ request()->input('q') }}</h1>
                    </div>
                </div>
            </div>
        </div>
   </header>

    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <h2>Bands</h2>
                <ul>
                @forelse($bands as $band)
                    <li><a href="{{ $band->permalink }}">{{ $band->name }}</a> ({{ $band->country }})</h3>
                @empty
                    <li>No bands found matching your query</li>
                @endforelse
                </ul>
                <hr>

                <h2>Albums</h2>
                <ul>
                @forelse($albums as $album)
                    <li><a href="{{ $album->permalink }}">{{ $album->title }}</a></li>
                @empty
                    No albums found matching your query
                @endforelse
                </ul>
                <hr>
            </div>
        </div>
    </div>

@endsection