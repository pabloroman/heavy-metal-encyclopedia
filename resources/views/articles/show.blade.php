@extends('layouts.main')

@section('title', $article->title)
@section('description', $article->description)
@section('navigation')
    @include('layouts._nav')
@endsection

@section('content')

<article class="article">

    @include('articles._header')

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @include('articles._content')
                </div>
            </div>
        </div>
    </section>
</article>

@endsection