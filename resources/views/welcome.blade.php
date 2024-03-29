@extends('layouts.app')

@section('content')
{!! laraflash()->render() !!}
<div class="pb-8 bg-white sm:pb-12 lg:pb-12">
  <div class="pt-8 overflow-hidden sm:pt-12 lg:relative lg:py-48">
    <div class="max-w-md px-4 mx-auto sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl lg:grid lg:grid-cols-2 lg:gap-24">
      <div>
        <div>
          <img class="w-auto h-11" src="https://tailwindui.com/img/logos/workflow-mark.svg?color=indigo&shade=600" alt="Workflow">
        </div>
        <div class="mt-20">
          <div class="mt-6 sm:max-w-xl">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Come for what you love.</h1>
            <p class="mt-6 text-xl text-gray-500">Stay for what you discover.</p>
          </div>
          <div class="mt-12 sm:max-w-lg sm:w-full sm:flex">
            <div class="mt-4 sm:mt-0">
              @if(session()->exists('oauth_token'))
                <a href="{{ route('home') }}" class="block w-full px-5 py-3 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:px-10">Authenticate with Tumblr</a>
              @else
                <a href="{{ route('tumblr.auth') }}" class="block w-full px-5 py-3 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:px-10">Authenticate with Tumblr</a>
              @endif
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="sm:mx-auto sm:max-w-3xl sm:px-6">
      <div class="py-12 sm:relative sm:mt-12 sm:py-16 lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
        <div class="hidden sm:block">
          <div class="absolute inset-y-0 w-screen left-1/2 bg-gray-50 rounded-l-3xl lg:left-80 lg:right-0 lg:w-full"></div>
          <svg class="absolute -mr-3 top-8 right-1/2 lg:m-0 lg:left-0" width="404" height="392" fill="none" viewBox="0 0 404 392">
            <defs>
              <pattern id="837c3e70-6c3a-44e6-8854-cc48c737b659" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
              </pattern>
            </defs>
            <rect width="404" height="392" fill="url(#837c3e70-6c3a-44e6-8854-cc48c737b659)" />
          </svg>
        </div>
        <div class="relative pl-4 -mr-40 sm:mx-auto sm:max-w-3xl sm:px-0 lg:max-w-none lg:h-full lg:pl-12">
          <img class="w-full rounded-md shadow-xl ring-1 ring-black ring-opacity-5 lg:h-full lg:w-auto lg:max-w-none" src="assets/img/front.png" alt="App Image">
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
