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
                            <h1 class="header-title text-center">Page not found</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </header>

    <section class="section">
        <div class="container">
            <div class="row">

            <div class="col-md-6">
                <p class="lead">
                    We apologize but something's gone wrong — an old link, a bad link, or some little glitch.
                </p>
                <p class="lead">
                    Would you like to: <a href="javascript: history.go(-1)">Go back</a> or go to the <a href="{{ url('/') }}">home page</a>?
                </p>
            </div>
        </div>
    </section>

@endsection