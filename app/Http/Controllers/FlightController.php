<?php

namespace App\Http\Controllers;

use App\Flight;
use App\Http\Resources\Flight as FlightResource;
use App\Jobs\FlightEnvironmentStatusJob;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class FlightController extends Controller
{
    private static $validationRules = [
        'flight_time' => 'date|required',
        'lat' => 'nullable|numeric|between:-90,90',
        'long' => 'nullable|numeric|between:-180,180',
        'duration_in_seconds' => 'numeric|between:0,99999|required',
        'notes' => 'required|string',
    ];

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $range = $request->range;
        $range = json_decode($range, true);
        $paginate = ($range[1] - $range[0]) + 1;
        $page = ($range[1] + 1) / $paginate;
        $sort = $request->sort;
        $sort = json_decode($sort, true);

        /** @var LengthAwarePaginator $flights */
        $flights = Flight::orderBy($sort[0], $sort[1])->paginate($paginate, ['*'], 'page', $page);

        // Headers are customized for React Admin, it expects the Content-Range for pagination
        return response($flights)
            ->withHeaders([
                'Content-Range' => sprintf(
                    'flights %d-%d/%d',
                    $flights->firstItem() - 1, // Emits 1-based index, we want 0-based
                    $flights->lastPage() - 1, // Emits 1-based index, we want 0-based
                    $flights->total()
                ),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(static::$validationRules);

        $flight = Flight::create([
            'flight_time' => $request->flight_time,
            'lat' => $request->lat,
            'long' => $request->long,
            'duration_in_seconds' => $request->duration_in_seconds,
            'notes' => $request->notes,
        ]);

        FlightEnvironmentStatusJob::dispatchAfterResponse($flight);

        return new FlightResource($flight);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function show(Flight $flight)
    {
        return new FlightResource($flight);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flight $flight)
    {
        $request->validate(static::$validationRules);

        $flight->update($request->only(['flight_time', 'lat', 'long', 'notes', 'duration_in_seconds']));

        if ($flight->wasChanged(['flight_time', 'lat', 'long'])) {
            FlightEnvironmentStatusJob::dispatchAfterResponse($flight);
        }

        return new FlightResource($flight);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flight $flight)
    {
        $flight->delete();

        return response()->json(null, 204);
    }
}
