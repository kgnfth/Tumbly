@extends('layouts.app')

@section('content')

<div class="main-container">
	<section class="height-100 bg-dark">
		<div class="container">
			<div class="row">
				<div class="col text-center">
					<i class="icon-compass display-4"></i>
					<h1 class="h2">Uhoh, page not found (404)</h1>
					<span>The page you requested couldn't be found. <a href="{{ url()->previous() }}" class="text-white">Go back to previous page</a></span>
				</div>
			</div>
		</div>
	</section>
</div>

@endsection
