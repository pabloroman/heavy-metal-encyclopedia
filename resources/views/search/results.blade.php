@extends('layouts.main')

@section('navigation')
    @include('layouts._nav')
@endsection

@section('content')

   <header class="header">
       <div class="header-background"></div>
            <div class="container">
                <div class="header-container">
                    <div class="header-content">
                        <div class="header-title-wrapper">
                            <h1 class="header-title">Search results for {{ request()->input('q') }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </header>

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <div class="section-title-wrapper">
                        <h2 class="section-title">Bands</h2>
                    </div>

                    <section class="section">
                    <ul>
                    @forelse($bands as $band)
                        <li><a href="{{ $band->permalink }}">{{ $band->name }}</a> ({{ $band->country }})</li>
                    @empty
                        <li>No bands found matching your query</li>
                    @endforelse
                    </ul>
                    <hr>
                    </section>

                    <div class="section-title-wrapper">
                        <h2 class="section-title">Albums</h2>
                    </div>

                    <section class="section">
                        @if($albums->count())
                        <div class="album-grid">
                            @foreach($albums as $album)
                                @include('partials._album-grid-item', ['hasBands' => true])
                            @endforeach
                        </div>
                        @else
                            No albums found matching your query
                        @endif
                    </div>
                    <hr>
                    </section>


                </div>
            </div>
        </div>
    </section>

@endsection