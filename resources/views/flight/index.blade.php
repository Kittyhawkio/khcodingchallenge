@extends('includes.container')

@section('title')
Flight Listing
@endsection

@section('body')
<div class="pb-5 flex justify-end ">
<a class="px-5 py-2 w-full lg:w-auto text-center bg-indigo-100 lg:bg-gray-200 border-gray-300 rounded hover:bg-indigo-200" href="/flights/create">Add...</a>
</div>
@foreach ($flights as $flight)
    @php $latUnit = $flight->lat > 0 ? 'N' : 'S'; @endphp
    @php $longUnit = $flight->long > 0 ? 'E' : 'W'; @endphp
    <div class="{{ $loop->even ? 'bg-gray-200' : '' }} py-5 px-3 flex justify-start rounded-tl-lg">
        <div class="inline-block flex flex-col justify-around mr-5">
            <a class="block mr-5 text-indigo-800 hover:text-indigo-400" href="{{ url("/flights/{$flight->id}/edit") }}">
                <svg class="fill-current inline-block w-10 lg:w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M6.47 9.8A5 5 0 0 1 .2 3.22l3.95 3.95 2.82-2.83L3.03.41a5 5 0 0 1 6.4 6.68l10 10-2.83 2.83L6.47 9.8z"/></svg>
            </a>
            <a class="block mr-5 text-indigo-800 hover:text-indigo-400" href="{{ url("/flights/{$flight->id}") }}">
                <svg class="fill-current inline-block w-10 lg:w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M.2 10a11 11 0 0 1 19.6 0A11 11 0 0 1 .2 10zm9.8 4a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm0-2a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
            </a>
        </div>
        <div class="w-1/3 inline-block mr-5">
            <div class="">
                <span class="font-bold">Flight:</span>
                <span>{{ abs($flight->lat) }}°{{ $latUnit }}</span>, <span>{{ abs($flight->long) }}°{{ $longUnit }}</span>
            </div>
            <div class="mt-2 text-xs">
                <div class="hidden lg:block">
                    <span class="font-bold">Notes:</span> {{ $flight->notes }}
                </div>
                @if(! is_null($flight->weather))
                    <div class="lg:hidden block">{{ $flight->weather->weather_blurb }}</div>
                    <div class="lg:hidden block">Temp: {{ $flight->weather->temperature }}°F</div>
                @endif
            </div>
        </div>
        @if(! is_null($flight->weather))
        <div class="hidden lg:block w-1/3 text-sm">
            <div>{{ $flight->weather->weather_blurb }}</div>
            <div>Temp: {{ $flight->weather->temperature }}°F</div>
            <small class="text-xs">Last updated {{ $flight->weather->updated_at->diffForHumans() }}.</small>
        </div>
        @endif
        @if(! is_null($flight->airspace))
        <div class="hidden md:flex justify-around items-center content-center mx-auto w-1/2 lg:w-1/6 text-sm rounded-full text-center"
            style="background: {{ $flight->airspace->color->hex() }}40;">
            <div>{{ $flight->airspace->full_overview }}</div>
        </div>
        @endif
    </div>
@endforeach

@endsection

@section('footer')
{{ $flights->links() }}
@endsection
