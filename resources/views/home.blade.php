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
							<a id="{{ $post->id }}" href="javascript:void(0);" class="absolute text-light" style="top: -60px; left: -32px;">
								<x-heroicon-s-photograph class="w-6 h-6 text-white"/>
							</a>
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
						<a data-fancybox href="{{ $post->video_url }}" class="absolute text-light" style="top: -60px; left: -32px;">
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
