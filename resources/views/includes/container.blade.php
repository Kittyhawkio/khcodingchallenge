@extends('includes.app')

@section('content')

<div class="my-5 md:my-0 mx-auto bg-white rounded-lg xl:w-1/2 lg:w-2/3 w-5/6 border border-gray-400">
    <div class="pl-2 py-2 bg-indigo-200 rounded-t-lg w-full text-xl">
        @yield('title')
    </div>
    <div class="py-6 mx-auto w-5/6">
        @yield('body')
    </div>
    <div class="py-2 w-full rounded-b-lg border-t border-gray-200 mt-5">
        @yield('footer')
    </div>
</div>

@endsection
