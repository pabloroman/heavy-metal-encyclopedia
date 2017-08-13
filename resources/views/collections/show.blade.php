@extends('layouts.main')

@section('title', $playlist->title)
@section('description', $playlist->description)
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
                            <h1 class="header-title">{{ $playlist->title }}</h1>
                        </div>
                    </div>
                </div>
                <p class="lead">{!! nl2br($playlist->description) !!}</p>
            </div>
        </div>
   </header>

    <section class="section">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="section-title-wrapper">
                        <h2 class="section-title">Albums in this collection</h2>
                    </div>
                    <div class="album-grid">
                        @foreach($playlist->albums as $album)
                            @include('partials._album-grid-item', ['hasBands' => true])
                        @endforeach
                    </div>

                    <hr>
                </div>
            </div>
        </div>
    </section>

@endsection