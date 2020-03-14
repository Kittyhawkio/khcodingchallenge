@extends('includes.container')

@section('title')
Create Flight
@endsection

@section('body')
<form id="edit-form" method="POST" action="/flights">
    @method('POST')
    @csrf
    <div class="flex-col flex justify-between">

    {{-- Latitude & Longitude --}}
    <div class="flex justify-start my-5">
        <div class="mr-5">
            {{-- Latitude --}}
            <label class="font-bold" for="latitude">Latitude:</label>
            <input class="text-right bg-gray-100 border border-gray-200 rounded @error('latitude') border-red-600 @enderror"
                step=0.05 type="number" id="latitude" name="latitude"
                min="-90" max="90" value={{ old('latitude') ?? 0 }} />°N
        </div>
        <div class="mr-5">
            {{-- Longitude --}}
            <label class="font-bold" for="longitude">Longitude:</label>
            <input class="text-right bg-gray-100 border border-gray-200 rounded @error('longitude') border-red-600 @enderror"
                step=0.05 type="number" id="longitude" name="longitude"
                min="-180" max="180" value={{ old('longitude') ?? 0 }} />°E
        </div>
    </div>

    {{-- Flight Date/Time --}}
    <div class="my-5">
        <label class="font-bold" for="date">Flight Date:</label>
        <input class="text-right bg-gray-100 border border-gray-200 rounded @error('date') border-red-600 @enderror"
            type="datetime-local" id="date" name="date" value="{{ old('date') ?? now()->isoFormat('YYYY-MM-DDThh:mm') }}">
    </div>

    {{-- Flight duration --}}
    <div class="my-5">
        <label class="font-bold" for="longitude">Flight Duration:</label>
        <input class="text-right bg-gray-100 border border-gray-200 rounded @error('duration_in_seconds') border-red-600 @enderror"
            step=1 type="number" id="duration_in_seconds" name="duration_in_seconds" min="0" value={{ old('duration_in_seconds') }} /> seconds
    </div>

    <div class="my-10">
        <label class="block font-bold" for="notes">Notes:</label>
        <textarea id="notes" name="notes"
            class="@error('notes') border-red-600 @enderror w-full h-32 bg-gray-100 border border-gray-200 rounded p-1"
            >{{ old('notes') }}</textarea>
    </div>

    </div>

    @if($errors->any())
        <div class="text-red-400">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="list-disc list-inside">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @php

        @endphp
    @endif
</form>
@endsection

@section('footer')
<div class="flex justify-around items-center" x-data="{}">
<a class="px-5 py-2 mx-auto bg-gray-200 border-gray-300 rounded hover:bg-indigo-200" href="javascript:void(0)" onclick="back()">Back</a>
<a class="px-5 py-2 mx-auto bg-indigo-300 border-gray-300 rounded hover:bg-indigo-200"
    x-on:keydown.window.enter="submitForm()" href="javascript:void(0)"
    onclick="submitForm()">Save</a>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
<script>
function back() {
    if (! document.referrer.endsWith('create')) {
        window.history.back();
    } else {
        window.location = '/flights';
    }
}
function submitForm() {
    document.getElementById('edit-form').submit()
}
</script>
@endpush
