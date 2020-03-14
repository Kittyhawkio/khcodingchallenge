@extends('includes.app')

@section('content')

@php
$latUnit = $flight->lat > 0 ? 'N' : 'S';
$longUnit = $flight->long > 0 ? 'E' : 'W';
@endphp

<div>
    @include('includes.map')

    <div id="sidebar" class="relative lg:fixed left-0 top-0
                                bg-white border-t lg:border-r border-indigo-600
                                px-8 w-screen lg:w-auto lg:h-screen">

    <div class="min-w-64 w-auto flex flex-col">

    <div class="py-5">
        {{-- Longitude/Latitude --}}
        <div class="">
            <div class="font-bold text-xl">Flight:</div>
            <div class="text-lg font-mono">
                <span>{{ abs($flight->lat) }}°{{ $latUnit }}</span>, <span>{{ abs($flight->long) }}°{{ $longUnit }}</span>
            </div>
        </div>
    </div>
    <div class="py-5">
        <span class="font-bold">At: </span><span>{{ $flight->flight_time->toCookieString() }}</span>
    </div>
    <div class="py-5">
        {{-- Weather --}}
        <div>
        <span class="text-xl font-bold">Weather:</span>
        <span class="text-xl">{{ $flight->weather->weather_blurb }}</span>
        </div>
        <div class="text-lg">Temperature: {{ $flight->weather->temperature }}°F</div>
        <small class="text-xs">Last updated {{ $flight->weather->updated_at->diffForHumans() }}.</small>
    </div>
    <div class="py-5">
        {{-- Airspace --}}
        <div class="text-xl font-bold">Airspace:</div>
        <div class="text-lg" style="color: {{ $flight->airspace->color->hex() }}">{{ $flight->airspace->full_overview }}</div>
    </div>
    <div class="py-5">
        <span class="font-bold">Notes:</span><br />
        {{ $flight->notes }}
    </div>

    <div class="pb-5 flex justify-end ">
    <a class="px-5 py-2 w-full lg:w-auto text-center bg-indigo-100 lg:bg-gray-200 border-gray-300 rounded hover:bg-indigo-200"
        href="/flights/{{ $flight->id }}/edit">Edit...</a>
    </div>

    </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
map.on('load', function() {
    map.addSource('points', {
        'type': 'geojson',
        'data': {
            'type': 'FeatureCollection',
            'features': [
                {
                    'type': 'Feature',
                    'geometry': @json(\GeoJSON\Geometry\Factory::prep()->setCoordinates([$flight->lat, $flight->long])->get()->toArray()),
                    'properties': {
                        'title': 'Flight Location',
                        'icon': 'airfield'
                    }
                },
            ]
        }
    });
    map.addLayer({
        'id': 'points',
        'type': 'symbol',
        'source': 'points',
        'layout': {
            // get the icon name from the source's "icon" property
            // concatenate the name to get an icon from the style's sprite sheet
            'icon-image': ['concat', ['get', 'icon'], '-15'],
            // get the title name from the source's "title" property
            'text-field': ['get', 'title'],
            'text-font': ['Open Sans Semibold', 'Arial Unicode MS Bold'],
            'text-offset': [0, 0.6],
            'text-anchor': 'top'
        }
    });
});
</script>
@endpush
