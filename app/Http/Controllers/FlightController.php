<?php

namespace App\Http\Controllers;

use App\Flight;
use App\Http\Requests\FlightRequest;
use App\Http\Resources\FlightResource;
use App\Jobs\GetFlightAdvisories;
use App\Jobs\GetFlightWeather;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request   $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $flights = Flight::query()
            ->with('airspace', 'weather')
            ->paginate();

        if ($request->expectsJson()) {
            return FlightResource::collection($flights);
        }

        // handle view
        return view('flight.index', ['flights' => $flights]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('flight.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\FlightRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FlightRequest $request)
    {
        $request->validate([
            'longitude' => 'required',
            'latitude'  => 'required',
            'date'      => 'required',
        ]);

        $flight = Flight::create([
            'long'                => $request->longitude,
            'lat'                 => $request->latitude,
            'flight_time'         => $request->date,
            'notes'               => $request->input('notes', ''),
            'duration_in_seconds' => $request->input('duration_in_seconds', 0),
        ]);

        GetFlightWeather::dispatch($flight);
        GetFlightAdvisories::dispatch($flight);

        if ($request->expectsJson()) {
            return (new FlightResource($flight))
                ->response()
                ->setStatusCode(201);
        }

        return redirect("/flights/{$flight->id}");
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request   $request
     * @param  \App\Flight               $flight
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Flight $flight)
    {
        if ($request->ajax()) {
            return new FlightResource($flight);
        }

        return view('flight.show', ['flight' => $flight]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function edit(Flight $flight)
    {
        return view('flight.edit', ['flight' => $flight]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\FlightRequest  $request
     * @param  \App\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function update(FlightRequest $request, Flight $flight)
    {
        $flight->lat = $request->input('latitude', $flight->lat);
        $flight->long = $request->input('longitude', $flight->long);
        $flight->flight_time = $request->input('date', $flight->flight_time);
        $flight->notes = $request->input('notes', $flight->notes);
        $flight->duration_in_seconds = $request->input('duration_in_seconds', $flight->duration_in_seconds);
        $flight->save();
        $flight->refresh();

        GetFlightWeather::dispatch($flight);
        GetFlightAdvisories::dispatch($flight);

        if ($request->expectsJson()) {
            return new FlightResource($flight);
        }

        return redirect("/flights/{$flight->id}");
    }
}
