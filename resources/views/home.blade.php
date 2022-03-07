@extends('layouts.app')

@section('content')

<div class="max-w-full px-2 pt-12 pb-24 mx-auto sm:px-6 lg:px-16">

	<div class="pb-6">
		<h2 id="product-marketing-heading" class="text-2xl font-extrabold text-gray-900">Dashboard</h2>
		<p class="mt-2 text-sm text-gray-500">You're caught up. Check these out:</p>
	</div>

	<div class="container">
		<div class="mx-auto space-y-2 sm:columns-2 md:columns-3 lg:columns-4 xl:columns-5 gap-y-6">
			@foreach($dashboardPosts as $post)
				@if($post->type == 'photo')
				<div class="relative">
					<div class="relative flex-col inline-block w-full min-w-0 break-inside">
						<a href="{{ route('post', ['blog' => $post->blog_name ,'id' => $post->id, 'slug' => $post->slug]) }}">
							<img class="object-cover object-center w-full h-full rounded" src="{{ $post->src }}" onerror="this.onerror=null; this.src='images/ohno.png'">
						</a>
					</div>
					@isset($post->gallery)
					@if($post->gallery == true)
						<div class="absolute top-0 right-0 flex items-center justify-center w-0 h-0 p-0 rounded-none opacity-70 border-t-66 border-l-66 border-t-current border-l-transparent">
							<a data-fancybox="{{ $post->id }}" data-thumb="{{ $post->src }}" href="{{ $post->src }}" class="absolute cursor-zoom-in text-light" style="top: -60px; left: -32px;">
								<x-heroicon-s-photograph class="w-6 h-6 text-white"/>
							</a>
						</div>

						<div class="hidden">
							@foreach ($post->pics as $photo)
							<a data-fancybox="{{ $post->id }}" href="{{ $photo }}" >
							  <img class="rounded" src="{{ $photo }}" />
							</a>
							@endforeach
						</div>
					@endif
					@endisset				
				</div>	
				@endif
				@if($post->type == 'video')
				<div class="relative">
					<div class="relative flex-col inline-block w-full min-w-0 break-inside">
						<a href="{{ route('post', ['blog' => $post->blog_name ,'id' => $post->id, 'slug' => $post->slug]) }}" class="img-c">
							@if(empty($post->src_type) == 'text')
								<img alt="Image" src="{{ $post->video_poster }}" onerror="this.onerror=null; this.src='images/ohno.png'" class="object-cover object-center w-full h-full rounded">
							@else
								<img alt="Image" src="{{ $post->video_poster }}" onerror="this.onerror=null; this.src='images/ohno.png'" class="object-cover object-center w-full h-full rounded">
							@endif
						</a>
					</div>
					@isset($post->video_url)
					<div class="absolute top-0 right-0 flex items-center justify-center w-0 h-0 p-0 rounded-none opacity-70 border-t-66 border-l-66 border-t-current border-l-transparent">
						<a data-fancybox-plyr href="{{ $post->video_url }}" data-thumb="{{ $post->video_poster }}" class="absolute text-light" style="top: -60px; left: -32px;">
							<x-heroicon-s-play class="w-6 h-6 text-white"/>
						</a>
					</div>
				@endisset
				</div>
				@endif
			@endforeach
		</div>

		<div class="mt-12">
			{{ $dashboardPosts->appends(request()->input())->links() }}
		</div>
	</div>
</div>
@endsection

@section('footer')
<script type="text/javascript">
	@foreach($dashboardPosts as $post)
		@if($post->type == 'photo')
			@isset($post->gallery)
				@if($post->gallery == true)
				Fancybox.bind(`[data-fancybox="{{ $post->id }}"]`, {
				dragToClose: false,
				closeButton: "top",
				on: {
					initCarousel: (fancybox) => {
					const slide = fancybox.Carousel.slides[fancybox.Carousel.page];
				
					fancybox.$container.style.setProperty(
						"--bg-image",
						`url("${slide.thumb}")`
					);
					},
					"Carousel.change": (fancybox, carousel, to, from) => {
					const slide = carousel.slides[to];
					fancybox.$container.style.setProperty(
						"--bg-image",
						`url("${slide.thumb}")`
					);
					},
				},
				});
				@endif
			@endisset
		@endif
	@endforeach
</script>
@endsection