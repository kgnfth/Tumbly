@extends('layouts.app')

@section('title', $blog->name)

@section('content')
<div>
	<img class="object-cover w-full h-32 lg:h-48" src="{{ $blog->theme->header_image ?? 'https://assets.tumblr.com/images/default_header/optica_pattern_06.png' }}">
	<div class="max-w-5xl px-4 mx-auto sm:px-6 lg:px-8">
		<div class="-mt-12 sm:-mt-16 sm:flex sm:items-end sm:space-x-5">
			<div class="flex">
				<img class="w-24 h-24 rounded-full ring-4 ring-white sm:h-32 sm:w-32" src="{{ getBlogAvatar($blog->name) }}">
			</div>
			  <div class="mt-6 sm:flex-1 sm:min-w-0 sm:flex sm:items-center sm:justify-end sm:space-x-6 sm:pb-1">
				@if($blogInfo->blog->followed == true)
				<a href="{{ route('unfollow', ['blogUrl' => $blogInfo->blog->name]) }}" class="flex flex-col items-center px-3 py-2 mt-6 space-y-3 text-sm font-medium leading-4 text-white bg-red-600 border border-transparent rounded-md shadow-sm justify-stretch sm:flex-row sm:space-y-0 sm:space-x-4 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"><i class="fad fa-user-times"></i> Unfollow</a>
				@else
				<a href="{{ route('follow', ['blogUrl' => $blogInfo->blog->name]) }}" class="flex flex-col items-center px-3 py-2 mt-6 space-y-3 text-sm font-medium leading-4 text-white bg-purple-600 border border-transparent rounded-md shadow-sm justify-stretch sm:flex-row sm:space-y-0 sm:space-x-4 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"><i class="fad fa-user-plus"></i> Follow</a>
				@endif

				@if ($blog->share_likes == true)
				<a href="{{ route('getBlogLikes', ['blogUrl' => $blog->name]) }}" class="flex flex-col items-center px-3 py-2 mt-6 space-y-3 text-sm font-medium leading-4 text-white bg-teal-600 border border-transparent rounded-md shadow-sm justify-stretch sm:flex-row sm:space-y-0 sm:space-x-4 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500"><i class="fad fa-heart"></i> View user likes</a>
				@endif
			  </div>
		</div>
		<div class="flex-1 min-w-0 mt-6 sm:block">
			  <h1 class="text-2xl font-bold text-gray-900 truncate">
				{{ $blog->name }}
			  </h1>
		</div>
	</div>
</div>



<main class="max-w-full px-2 pt-12 pb-24 mx-auto sm:px-6 lg:px-16">
	<div class="container-fluid">
		<div class="mb-4 row">
			<div class="col-12 d-flex justify-content-between">
				<div class="d-flex align-items-center">
					<span class="mr-2 text-muted text-small text-nowrap">Sort by:</span>
					<a href="{{ request()->fullUrlWithQuery(['type' => 'video'])}}" class="mb-1 btn btn-secondary">Videos</a>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="mx-auto space-y-2 sm:columns-2 md:columns-3 lg:columns-4 xl:columns-5 gap-y-6">
				@foreach($posts as $post)
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
				{{ $posts->appends(request()->input())->links() }}
			</div>
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
