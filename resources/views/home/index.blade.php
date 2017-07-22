@extends('layouts.main')

@section('navigation')

<div class="homepage">

    <section class="hero">

    @include('layouts._nav', ['position' => 'home'])

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="text-center">
                    <h1 class="hero__tagline">Heavy Metal Encylopedia</h1>
                    <p class="hero__description lead">There are currently {{ number_format($bandCount) }} bands, {{ number_format($albumCount) }} albums and {{ number_format($reviewCount) }} reviews in {{ config('app.name') }}.</p>
                </div>
            </div>
        </div>
    </div>

    </section>

</div>

@endsection
