@extends('layouts.app')

@section('content')
<div class="main-container">
    {!! laraflash()->render() !!}
    <section class="space-lg bg-white">
        <div class="container">
            <div class="row align-items-center justify-content-around">
                <div class="col-12 col-md-6 col-lg-5 text-center text-md-left section-intro">
                    <h1>Come for what you love.</h1>
                    <h1>Stay for what you discover.</h1>
                    @if(session()->exists('oauth_token'))
                    <a href="{{ route('home') }}" class="btn btn-success btn-lg">Authenticate with Tumblr</a>
                    @else
                    <a href="{{ route('tumblr.auth') }}" class="btn btn-success btn-lg">Authenticate with Tumblr</a>
                    @endif
                </div>
                <!--end of col-->
                <div class="col-12 col-md-6 col-lg-6">
                    <img alt="Image" class="img-fluid w-100" src="//wingman.mediumra.re/assets/img/graphic-golden-gate-bridge.svg">
                </div>
                <!--end of col-->
            </div>
            <!--end of row-->
        </div>
        <!--end of container-->
    </section>
    <!--end of section-->
</div>
@endsection
