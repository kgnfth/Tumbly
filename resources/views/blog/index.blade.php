@extends('layouts.app')

@section('title', $blog->name)

@section('content')
<div class="main-container">
	<section class="bg-dark text-light footer-long">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col">
					<div class="media">
						<img alt="Image" src="{{ getBlogAvatar($blog->name) }}" class="shadow mr-md-5 avatar avatar-xlg case-study">
						<div class="media-body">
							<div class="mb-3">
								<h1 class="mb-2 h2">{{ $blog->title }}</h1>
								<span class="text-muted">{{ $blog->ask_page_title }}</span>
							</div>
							<p>{!! $blog->description !!}</p>
							<div>
								@if($blogInfo->blog->followed == true)
									<a href="{{ route('unfollow', ['blogUrl' => $blogInfo->blog->name]) }}" class="btn btn-outline-danger btn-active"><i class="fad fa-user-times"></i> Unfollow</a>
								@else
									<a href="{{ route('follow', ['blogUrl' => $blogInfo->blog->name]) }}" class="btn btn-outline-primary"><i class="fad fa-user-plus"></i> Follow</a>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<main class="py-3">
	<div class="container-fluid">
		<div class="mb-4 row">
			<div class="col-12 d-flex justify-content-between">
				<div class="d-flex align-items-center">
					<span class="mr-2 text-muted text-small text-nowrap">Sort by:</span>
					<a href="{{ request()->fullUrlWithQuery(['type' => 'video'])}}" class="mb-1 btn btn-secondary">Videos</a>
				</div>
			</div>
		</div>
		<div class="card-columns">
			@foreach($posts as $post)
				@if($post->type == 'photo')
					<div class="card">
						<a href="{{ route('post', ['blog' => $post->blog_name ,'id' => $post->id, 'slug' => $post->slug]) }}">
							<img class="card-img" src="{{ $post->src }}" onerror="this.onerror=null; this.src='{{ url('/images/ohno.png') }}'">
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

				@if($post->type == 'video' && isset($post->video_poster))
				<div class="card">
					<a href="{{ route('post', ['blog' => $post->blog_name ,'id' => $post->id, 'slug' => $post->slug]) }}" class="img-c">
						@if(empty($post->src_type) == 'text' )
							<img alt="Image" src="{{ $post->video_poster }}" onerror="this.onerror=null; this.src='{{ url('/images/ohno.png') }}'" class="card-img">
						@else
							<img alt="Image" src="{{ $post->video_poster }}" onerror="this.onerror=null; this.src='{{ url('/images/ohno.png') }}'" class="card-img">
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
					@if($post->video_type === 'instagram')
						<div class="badge-corner">
							<object>
								<i class="fab fa-instagram"></i>
							</object>
						</div>
					@endif
				</div>
				@endif
			@endforeach
		</div>

		<div class="mt-5 d-flex justify-content-center">
			{{ $posts->appends(request()->input())->links() }}
		</div>
	</div>
</main>
@endsection


@section('footer')
	<script type="text/javascript">
		@foreach($posts as $post)
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
