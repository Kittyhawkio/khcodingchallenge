<div class="relative md:absolute md:fixed top-0 left-0">
    <div id="map" class="w-screen h-64 md:h-screen"></div>
</div>

@push('scripts')
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.52.0/mapbox-gl.js'></script>
<script>
mapboxgl.accessToken = '{{ config('services.mapbox.token') }}';
var map = new mapboxgl.Map({
    container: 'map', // container id
    style: 'mapbox://styles/mapbox/light-v10?optimize=true', // stylesheet location
    center: [{{ $flight->long }}, {{ $flight->lat }}], // starting position [long, lat]
    zoom: 14 // starting zoom
});
</script>
@endpush

@push('styles')
<link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.52.0/mapbox-gl.css' rel='stylesheet' />

@endpush
