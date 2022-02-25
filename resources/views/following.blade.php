@extends('layouts.app')

@section('content')
<main class="py-3">
	<div class="container">
		<div class="row">
            <div class="col">
              <table class="table table-borderless table-hover align-items-center">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Title</th>
                    <th scope="col">Updated</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($posts as $post)
                  <tr class="bg-white">
                    <th scope="row">
                      <a class="media align-items-center" href="{{ route('blog', $post->name) }}" target="_blank" rel="noopener noreferrer">
                        <img alt="Image" src="{{ getBlogAvatar($post->name) }}" class="avatar rounded avatar-sm">
                        <div class="media-body">
                          <span class="h6 mb-0">{{ $post->name }}</span>
                        </div>
                      </a>
                    </th>
                    <td>{{ $post->title }}</td>
                    <td>{{ Carbon\Carbon::createFromTimestamp($post->updated)->diffForHumans() }}</td>
                  </tr>
                  <tr class="table-divider"></tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!--end of col-->
          </div>

		<div class="d-flex justify-content-center mt-5 mb-5">
			{{ $posts->appends(request()->input())->links() }}
		</div>
	</div>
</main>
@endsection
