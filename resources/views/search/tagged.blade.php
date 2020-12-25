@extends('layouts.app')

@section('content')
<main class="py-3">
	<div class="container">
		<div class="image-gallery" data-columns="5">
			@foreach($tagged as $post)
				@if($post->type == 'photo')
					<a href="{{ route('post', ['blog' => $post->blog_name ,'id' => $post->id, 'slug' => $post->slug]) }}">
						<img class="card-img-top" src="{{ array_first($post->photos)->original_size->url }}">
					</a>
				@endif

				@if($post->type == 'video')
					@if(empty($post->thumbnail_url))

					@else
					<a href="{{ route('post', ['blog' => $post->blog_name ,'id' => $post->id, 'slug' => $post->slug]) }}" class="img-c">
						<img class="card-img-top" src="{{ $post->thumbnail_url }}">
						<div class="img-overlay text-light">
							<i class="fas fa-play-circle fa-3x"></i>
						</div>
					</a>
					@endif
				@endif
			@endforeach
		</div>



	</div>
</main>
@endsection
