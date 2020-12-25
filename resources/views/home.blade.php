@extends('layouts.app')

@section('content')
<main class="py-3">
	<section class="space-xxs">
        <div class="container-fluid">
        	<div class="row justify-content-center">
        		<div class="col">
        			<h1 class="h2 mb-2">Dashboard</h1>
        		</div>
        	</div>
        </div>
    </section>
	<div class="container-fluid">
		<div class="card-columns">
			@foreach($dashboardPosts as $post)
				@if($post->type == 'photo')
					<div class="card">
						<a href="{{ route('post', ['blog' => $post->blog_name ,'id' => $post->id, 'slug' => $post->slug]) }}">
							<img class="card-img" src="{{ $post->src }}" onerror="this.onerror=null; this.src='images/ohno.png'">
						</a>
						@isset($post->gallery)
							@if($post->gallery == true)
								<div class="badge-corner">
									<object>
										<a id="{{ $post->id }}" href="javascript:void(0);" class="text-light">
											<i class="fad fa-images"></i>
										</a>
									</object>
								</div>
							@endif
						@endisset
					</div>
				@endif
				@if($post->type == 'video')
					<div class="card">
						<a href="{{ route('post', ['blog' => $post->blog_name ,'id' => $post->id, 'slug' => $post->slug]) }}" class="img-c">
							@if(empty($post->src_type) == 'text')
								<img alt="Image" src="{{ $post->video_poster }}" onerror="this.onerror=null; this.src='images/ohno.png'" class="card-img">
							@else
								<img alt="Image" src="{{ $post->video_poster }}" onerror="this.onerror=null; this.src='images/ohno.png'" class="card-img">
							@endif
						</a>
						@isset($post->video_url)
							<div class="badge-corner">
								<object>
									<a data-fancybox href="{{ $post->video_url }}" class="text-light">
										<i class="fad fa-play-circle"></i>
									</a>
								</object>
							</div>
						@endisset
					</div>
				@endif
			@endforeach
		</div>

		<div class="d-flex justify-content-center mt-5 mb-5">
			{{ $dashboardPosts->appends(request()->input())->links() }}
		</div>
	</div>
</main>
@endsection


@section('footer')
	<script type="text/javascript">
		@foreach($dashboardPosts as $post)
			@if($post->type == 'photo')
				@isset($post->gallery)
					@if($post->gallery == true)
						$('#{{ $post->id }}').on('click', function() {
							$.fancybox.open([
								@if(!empty($post->pics))
								@foreach($post->pics as $photo)
								{
									src: '{{ $photo }}',
									opts : {
										thumb   : '{{ $photo }}'
									}
								},
								@endforeach
								@endif
							])
						});
					@endif
				@endisset
			@endif
		@endforeach
	</script>
@endsection
