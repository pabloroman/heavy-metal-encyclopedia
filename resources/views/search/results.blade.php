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
                    <ul>
                    @forelse($bands as $band)
                        <li><a href="{{ $band->permalink }}">{{ $band->name }}</a> ({{ $band->country }})</h3>
                    @empty
                        <li>No bands found matching your query</li>
                    @endforelse
                    </ul>
                    <hr>

                    <div class="section-title-wrapper">
                        <h2 class="section-title">Albums</h2>
                    </div>



                    <div class="album-grid">
                        @forelse($albums as $album)
                            @include('partials._album-grid-item', ['hasBands' => true])
                        @empty
                            No albums found matching your query
                        @endforelse
                    </div>

                    <hr>
                </div>
            </div>
        </div>
    </section>

@endsection