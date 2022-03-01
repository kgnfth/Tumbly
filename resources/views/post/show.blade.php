@extends('layouts.app')

@section('title', $blog->name)

@section('content')
<!-- 3 column wrapper -->
<div class="flex-grow w-full max-w-full mx-auto sm:px-6 lg:px-16 lg:flex">
	<!-- Left sidebar & main wrapper -->
	<div class="flex-1 min-w-0 xl:flex">
		<!-- Account profile -->
		<div class="xl:flex-shrink-0 xl:w-96 xl:border-r xl:border-gray-200">
			<div class="py-6 pl-4 pr-6 sm:pl-6 lg:pl-8 xl:pl-0">
				<div class="flex items-center justify-between">
					<div class="flex-1 space-y-8">
						<div class="space-y-8 sm:space-y-0 sm:flex sm:justify-between sm:items-center xl:block xl:space-y-8">
							<!-- Profile -->
							<div class="flex flex-col items-center text-center bg-white border border-gray-200 rounded-md">
								<div class="w-full h-40 overflow-hidden">
									<img class="object-cover w-full h-full rounded-t-md" src="{{ $post->trail[0]->blog->theme->header_image ?? 'https://assets.tumblr.com/images/default_header/optica_pattern_06.png' }}">
								</div>
								<div class="flex-auto p-6 -mt-20">
									<img class="w-32 h-32 mx-auto border-4 border-gray-100 rounded-full" src="{{ $avatar }}" onerror="this.onerror=null; this.src='../../assets/img/avatar.png'" alt="Profile image">
									<div class="my-6">
										<div class="mb-3">
											<h5 class="mb-0">
												<a href="{{ route('blog', ['blogUrl' => $blog->name]) }}">
													{{ $blog->name }}
												</a>
											</h5>
											<span class="text-gray-600">
												{!! $blog->description !!}
											</span>
										</div>
									</div>
									<!-- Action buttons -->
									<div>
										@if($blog->followed == true)
										<a href="{{ route('unfollow', ['blogUrl' => $blog->name]) }}" class="items-center px-3 py-2 text-sm font-medium leading-4 text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
											<i class="fa-duotone fa-user-minus -ml-0.5 mr-2 h-4 w-4"></i> Unfullow
										</a>
										@else
										<a href="{{ route('follow', ['blogUrl' => $blog->name]) }}" class="items-center px-3 py-2 text-sm font-medium leading-4 text-white bg-purple-600 border border-transparent rounded-md shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
											<i class="fa-duotone fa-user-plus -ml-0.5 mr-2 h-4 w-4"></i> Follow
										</a>
										@endif
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Media -->
		<div class="bg-white lg:min-w-0 lg:flex-1">
			{!! laraflash()->render() !!}
			@isset($post->reblogged_from_name)
			<div class="pt-4 pb-4 pl-4 pr-6 border-t border-b border-gray-200 sm:pl-6 lg:pl-8 xl:pl-6 xl:pt-6 xl:border-t-0">
				<div class="items-center">
					<a class=" hover:text-purple-600" href="{{ route('post', ['blog' => $post->reblogged_from_name ,'id' => $post->reblogged_from_id]) }}">
						<i class="fad fa-retweet"></i> 
						{{ $post->reblogged_from_name }}
					</a>
				</div>
			</div>
			@endisset
			<div class="pt-4 pb-4 pl-4 pr-6 border-t border-b border-gray-200 sm:pl-6 lg:pl-8 xl:pl-6 xl:pt-5 xl:border-t-0">
				@isset($post->reblogged_root_name)
				<div class="flex-shrink-0 block mb-2 text-xs group">
					<div class="flex items-center">
						<div>
							<a href="{{ route('post', ['blog' => $post->reblogged_root_name ,'id' => $post->reblogged_root_id]) }}" target="_blank">
								<img class="inline-block w-6 h-6" src="{{ getBlogAvatar($post->reblogged_root_name, 24) }}" onerror="this.onerror=null; this.src='{{secure_asset('assets/img/avatar.png')}}'" alt="{{ $post->reblogged_root_name }}">
							</a>
						</div>
						<div class="ml-3">
							<a target="_blank" class="text-sm font-medium text-gray-700 group-hover:text-gray-900" href="{{ route('post', ['blog' => $post->reblogged_root_name ,'id' => $post->reblogged_root_id]) }}" title="{{ $post->reblogged_root_name }}">
								{{ $post->reblogged_root_name }}
							</a>
						</div>
					</div>
				</div>
				@endisset
				@if($post->type == 'photo')
				@if(count($post->photos) > 1)
				<div class="space-y-2 sm:columns-2 md:columns-3 gap-y-6">
					@foreach($post->photos as $photo)
					<div class="card">
						<a data-fancybox="images" href="{{ $photo->original_size->url }}" data-width="{{ $photo->original_size->width }}" data-height="{{ $photo->original_size->height }}">
							<img class="card-img" src="{{ $photo->original_size->url }}" />
						</a>
					</div>
					@endforeach
				</div>
				@else
				@foreach($post->photos as $photo)
					<a data-fancybox="images" href="{{ $photo->original_size->url }}" data-width="{{ $photo->original_size->width }}" data-height="{{ $photo->original_size->height }}">
						<img class="card-img" src="{{ $photo->original_size->url }}" />
					</a>
				@endforeach
				@endif
				@endif
				@if($post->type == 'photo-text')
				@if(count($post->photos) > 1)
				<div class="space-y-2 sm:columns-2 md:columns-3 gap-y-6">
					@foreach($post->photos as $photo)
					<div class="card">
							<a data-fancybox="images" href="{{ $photo->original_size->url }}" data-width="{{ $photo->original_size->width }}" data-height="{{ $photo->original_size->height }}">
								<img class="card-img" src="{{ $photo->original_size->url }}" />
							</a>
					</div>
					@endforeach
				</div>
				@else
					@foreach($post->photos as $photo)
						<a data-fancybox="images" href="{{ $photo->original_size->url }}" data-width="{{ $photo->original_size->width }}" data-height="{{ $photo->original_size->height }}">
							<img class="card-img" src="{{ $photo->original_size->url }}" />
						</a>
					@endforeach
				@endif
				@endif
				@if($post->type == 'video')
				@if($post->video_type == 'tumblr')
				<div>
					<video id="player" poster="{{ $post->thumbnail_url }}" onerror="this.onerror=null; this.src='{{ url('/images/ohno.png') }}'">
						<source src="{{ $post->video_url }}" type="video/mp4">
					</video>
				</div>
				@endif
				@if($post->video_type == 'instagram')
					{!! array_last($post->player)->embed_code !!}
				@endif
				@endif
				@if($post->type == 'video-text')
				@if($post->video_type == 'tumblr')
				<div>
					<video id="player" poster="{{ $post->thumbnail_url }}" onerror="this.onerror=null; this.src='{{ url('/images/ohno.png') }}'">
						<source src="{{ $post->video_url }}" type="video/mp4">
					</video>
				</div>
				@endif
				@if($post->video_type == 'instagram')
				{!! array_last($post->player)->embed_code !!}
				@endif
				@endif
			</div>
			@if(!empty($post->caption))
			<div class="pt-4 pb-4 pl-4 pr-6 border-t border-b border-gray-200 sm:pl-6 lg:pl-8 xl:pl-6 xl:pt-6 xl:border-t-0">
				<div class="mb-3 prose prose-purple prose-slate">
					{!! $post->caption !!}
				</div>
				@if(!empty($post->tags))
				<p>
					Tags:
					@foreach ($post->tags as $tag)
					<a href="{{ route('tagged', ['blogUrl' => $post->blog_name, 'tag' => $tag ])}}" class="inline-block mr-2 leading-8 text-gray-500 no-underline hover:text-gray-700">#{{ $tag }}</a>
					@endforeach
				</p>		
				@endif
			</div>
			@endif
			<div class="pt-4 pb-4 pl-4 pr-6 border-t border-b border-gray-200 sm:pl-6 lg:pl-8 xl:pl-6 xl:pt-6 xl:border-t-0">
				<div class="relative flex w-full h-auto">
					<div class="flex flex-col justify-center w-full text-sm">
						<span class="inline-flex">
							<a href="#" class="inline-block mr-2 text-gray-500 no-underline hover:text-gray-600">
								{{ Carbon\Carbon::createFromTimestamp($post->timestamp)->toFormattedDateString() }}
							</a>
						</span>
					</div>
					<div class="text-gray-500 sm:flex sm:items-center sm:justify-between">
						<div class="flex-1 min-w-0">
							<div class="inline-flex items-center order-1 ml-3 sm:order-0 sm:ml-0">
								<form method="POST" action="{{ route('reblog') }}" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="blog_id" value="{{ $post->id }}">
									<input type="hidden" name="reblog_key" value="{{ $post->reblog_key }}">
									<button class="relative inline-block ml-1 text-2xl text-left align-middle" type="submit">
										<i class="w-5 h-5 text-gray-400 hover:text-gray-500 fa-solid fa-arrows-retweet"></i>
									</button>
								</form>
							</div>
						</div>
						<div class="flex sm:mt-0 sm:ml-4">
							<div class="inline-flex items-center order-0 sm:order-1 sm:ml-3">
								@if($post->liked == true)
								<form method="POST" action="{{ route('unlike') }}" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="blog_id" value="{{ $post->id }}">
									<input type="hidden" name="reblog_key" value="{{ $post->reblog_key }}">
									<button class="relative inline-block ml-1 text-2xl text-left align-middle" type="submit">
										<i class="w-5 h-5 text-red-500 hover:text-gray-500 fa-solid fa-heart"></i>
									</button>
								</form>
								@else
								<form method="POST" action="{{ route('like') }}" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="blog_id" value="{{ $post->id }}">
									<input type="hidden" name="reblog_key" value="{{ $post->reblog_key }}">
									<button class="relative inline-block ml-1 text-2xl text-left align-middle" type="submit">
										<i class="w-5 h-5 text-gray-400 hover:text-gray-500 fa-solid fa-heart"></i>
									</button>
								</form>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="pr-4 bg-gray-50 sm:pr-6 lg:pr-8 lg:flex-shrink-0 lg:border-l lg:border-gray-200 xl:pr-0">
		<div class="pl-6 lg:w-96">
			<div class="pt-6 pb-2">
				<h2 class="text-sm font-semibold">{{ $post->note_count}} Notes</h2>
			</div>
			@isset($post->notes)
			<div>
				<ul role="list" class="divide-y divide-gray-200">
					@foreach($post->notes as $note)
					<li class="py-4">
						<div class="flex space-x-3">
							@if($note->type == 'reblog')
							<div class="relative inline-block">
								<img class="w-16 h-16 rounded-full" src="{{ getBlogAvatar($note->blog_name, 512) }}" alt="">
								<span class="absolute bottom-0 right-0 inline-flex text-green-600 rounded-full bg-green-50 ring-4 ring-white">
									<i class=" fad fa-retweet"></i>
								</span>
							</div>
							<div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
								<p class="text-sm text-gray-500">
									<a class="font-medium text-gray-900" href="{{ route('blog', ['blogUrl' => $note->blog_name])}}" class="text-sm font-medium">{{ $note->blog_name }}</a>
									 reblogged this from 
									@if(!empty($note->reblog_parent_blog_name))
									<a class="font-medium text-gray-900" href="{{ route('blog', ['blogUrl' => $note->reblog_parent_blog_name])}}">{{ $note->reblog_parent_blog_name }}</a>
									@endif
								</p>
								<div class="text-sm text-right text-gray-500 whitespace-nowrap">
									<time>{{ Carbon\Carbon::createFromTimestamp($note->timestamp)->diffForHumans() }}</time>
								</div>
							</div>
							@endif
							@if($note->type == 'like')
							<div class="relative inline-block">
								<img class="w-16 h-16 rounded-full" src="{{ getBlogAvatar($note->blog_name, 512) }}" alt="">
								<span class="absolute bottom-0 right-0 inline-flex text-red-700 rounded-full bg-purple-50 ring-4 ring-white">
									<i class=" fad fa-circle-heart"></i>
								</span>
							</div>
							<div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
								<p class="text-sm text-gray-500">
									liked this
									<a class="font-medium text-gray-900" href="{{ route('blog', ['blogUrl' => $note->blog_name])}}" class="text-sm font-medium">{{ $note->blog_name }}</a>
								</p>
								<div class="text-sm text-right text-gray-500 whitespace-nowrap">
									<time>{{ Carbon\Carbon::createFromTimestamp($note->timestamp)->diffForHumans() }}</time>
								</div>
							</div>
							@endif
						</div>
					</li>
					@endforeach
				</ul>
			</div>
			@endisset
		</div>
	</div>
</div>
@endsection

@section('footer')
	<script type="text/javascript">
		$('[data-fancybox="images"]').fancybox({
			thumbs : {
				autoStart : true
			},
			buttons: [
				"zoom",
				"share",
				"slideShow",
				"fullScreen",
				"download",
				"thumbs",
				"close"
			],
			animationEffect: "zoom",
			transitionEffect: "slide"
		});
	</script>
@endsection
