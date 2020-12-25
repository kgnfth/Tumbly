@extends('layouts.app')

@section('content')
<div class="py-3">
	<div class="container">
		<div class="grid">
			@foreach($posts as $post)
				@if($post->type == 'photo')
				<div class="grid-item">
					<a href="{{ route('post', ['blog' => $post->blog_name ,'id' => $post->id, 'slug' => $post->slug]) }}">
						<img class="card-img-top" src="{{ array_first($post->photos)->original_size->url }}">
					</a>
				</div>
				@endif

				@if($post->type == 'video')
				<div class="grid-item">
					<a href="{{ route('post', ['blog' => $post->blog_name ,'id' => $post->id, 'slug' => $post->slug]) }}" class="img-c">
						<img alt="Image" src="{{ $post->thumbnail_url }}" class="card-img-top">
						<div class="img-overlay text-light">
							<i class="fas fa-play-circle fa-3x"></i>
						</div>
					</a>
				</div>
				@endif
			@endforeach
		</div>
	</div>
</div>
	<div class="container">
		{{ $posts->links() }}
	</div>
@endsection
