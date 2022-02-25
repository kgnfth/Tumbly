@extends('layouts.app')

@section('title', $blog->name)

@section('content')

<div class="main-container">
	<section class="space-sm">
		<div class="container">
			<div class="row">
				<div class="mb-4 col-12 col-md-4 mb-md-0">
					<div class="text-center card card-profile-large">
						<div class="card-header">
							<img alt="Image" src="{{ $post->trail[0]->blog->theme->header_image ?? 'https://assets.tumblr.com/images/default_header/optica_pattern_06.png' }}" class="bg-image">
						</div>
						<div class="card-body">
							<a href="#">
								<img src="{{ $avatar }}" class="avatar avatar-lg hoverZoomLink">
							</a>
							<div class="my-3">
								<div class="mb-2">
									<h5 class="mb-0">{{ $blog->name }}</h5>
									<span class="text-muted">{!! $blog->description !!}</span>
								</div>

							</div>
							<div>
								@if($blog->followed == true)
									<a href="{{ route('unfollow', ['blogUrl' => $blog->name]) }}" class="btn btn-outline-danger btn-active"><i class="fad fa-user-times"></i> Unfollow</a>
								@else
									<a href="{{ route('follow', ['blogUrl' => $blog->name]) }}" class="btn btn-outline-primary"><i class="fad fa-user-plus"></i> Follow</a>
								@endif
							</div>
						</div>
					</div>
				</div>

				<div class="col-12 col-md-8">
					{!! laraflash()->render() !!}
					<div class="card">
						@isset($post->reblogged_from_name)
						<div class="card-header card-header-borderless d-flex justify-content-between">
							<small class="text-muted"><i class="fad fa-retweet"></i> {{ $post->reblogged_from_name }}</small>
							@isset($post->reblogged_root_name)
							@if(!empty($post->reblogged_root_name))
							<small class="text-muted">
								<i class="fad fa-repeat"></i>
								<a href="{{ route('blog', ['blogUrl' => $post->reblogged_root_name]) }}">{{ $post->reblogged_root_name }}</a>
							</small>
							@endif
							@endisset
						</div>
						@endisset
						<div class="card-body">
							@if($post->type == 'photo')
								@if(count($post->photos) > 1)
									<div class="card-columns" style="column-count: 3">
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
								<div class="card-columns" style="column-count: 3">
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
						@if(!empty($post->summary))
						<div class="card-footer d-flex justify-content-between">
							<span class="mb-0 d-block">{!! $post->summary !!}</span>
						</div>
						@endif
						<div class="card-footer">
							<div class="d-flex justify-content-between align-items-center">
								<div>
									<form method="POST" action="{{ route('reblog') }}" enctype="multipart/form-data">
										@csrf
										<input type="hidden" name="blog_id" value="{{ $post->id }}">
										<input type="hidden" name="reblog_key" value="{{ $post->reblog_key }}">
										<button class="btn btn-sm btn-outline-primary" type="submit"><i class="fad fa-retweet"></i></button>
									</form>
								</div>
								@if($post->liked == true)
								<div>
									<form method="POST" action="{{ route('unlike') }}" enctype="multipart/form-data">
										@csrf
										<input type="hidden" name="blog_id" value="{{ $post->id }}">
										<input type="hidden" name="reblog_key" value="{{ $post->reblog_key }}">
										<button class="btn btn-sm btn-outline-danger active" type="submit"><i class="fas fa-heart"></i></button>
									</form>
								</div>
								@else
									<form method="POST" action="{{ route('like') }}" enctype="multipart/form-data">
										@csrf
										<input type="hidden" name="blog_id" value="{{ $post->id }}">
										<input type="hidden" name="reblog_key" value="{{ $post->reblog_key }}">
										<button class="btn btn-sm btn-outline-danger" type="submit"><i class="fas fa-heart"></i></button>
									</form>
								@endif
								@isset($post->reblogged_from_name)
								<div>
									<img alt="Image" src="{{ getBlogAvatar($post->reblogged_from_name, 24) }}" class="avatar avatar-xs">
                                	<a href="{{ route('blog', ['blogUrl' => $post->reblogged_from_name]) }}">{{ $post->reblogged_from_name }}</a>
								</div>
								@endisset
								<div>
		                            <div class="text-small">
		                                <ul class="list-inline">
		                                    <li class="list-inline-item">
												<div class="accordion" id="accordion-1" data-children=".accordion-item">
													<div class="accordion-item">
														<a data-toggle="collapse" data-parent="#accordion-1" href="#accordion-panel-1" aria-expanded="false" aria-controls="accordion-1" class="collapsed">
															<div class="text-dark">{{ $post->note_count}} Notes</div>
														</a>
													</div>
												</div>
		                                    </li>
		                                    <li class="list-inline-item">
		                                    	<div class="opacity-50 text-dark">
		                                    		{{ Carbon\Carbon::createFromTimestamp($post->timestamp)->toFormattedDateString() }}
		                                    	</div>
		                                    </li>
		                                </ul>
		                            </div>
								</div>
                            </div>
                        </div>

						<div id="accordion-panel-1" role="tabpanel" class="collapse">
							<div class="shadow list-group list-group-flush pre-scrollable">
							@isset($post->notes)
								@foreach($post->notes as $note)
									<div class="list-group-item list-group-item-action">
										@if($note->type == 'reblog')
											<img alt="Image" src="{{ getBlogAvatar($note->blog_name, 512) }}" class="avatar avatar-xs">
											<span class="badge badge-success"><i class="fad fa-retweet"></i></span>
											<small class="text-muted">
												<a href="{{ route('blog', ['blogUrl' => $note->blog_name])}}">{{ $note->blog_name }}</a>
												reblogged this
												@if(!empty($note->reblog_parent_blog_name))
												from
												<a href="{{ route('blog', ['blogUrl' => $note->reblog_parent_blog_name])}}">{{ $note->reblog_parent_blog_name }}</a>
												@endif
											</small>
											<small class="text-muted">{{ Carbon\Carbon::createFromTimestamp($note->timestamp)->diffForHumans() }}</small>
										@endif

										@if($note->type == 'like')
											<img alt="Image" src="{{ getBlogAvatar($note->blog_name, 512) }}" class="avatar avatar-xs">
											<span class="badge badge-danger"><i class="fad fa-heart"></i></span>
											<small class="text-muted"><a href="{{ route('blog', ['blogUrl' => $note->blog_name])}}">{{ $note->blog_name }}</a> liked this</small>
											<small class="text-muted">{{ Carbon\Carbon::createFromTimestamp($note->timestamp)->diffForHumans() }}</small>
										@endif
									</div>
								@endforeach
							@endisset
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
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
