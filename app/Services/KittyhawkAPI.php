<?php

namespace App\Services;

use App\Services\DataObjects\KittyhawkResponse;
use Exception;
use GuzzleHttp\Client;
use GeoJSON\Contracts\GeometryContract;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;

/**
 * A service class for interacting with the Kittyhawk API.
 * Takes in information, generates a GeoJSON request, and returns response data.
 */
final class KittyhawkAPI
{
    private const ENDPOINT = 'https://app.kittyhawk.io/api/atlas/advisories';

    private ?GeometryContract $geometry = null;

    private Client $http;

    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    /**
     * Set the Geometry of the request.
     *
     * @param \GeoJSON\Contracts\GeometryContract $geometry
     * @return $this
     */
    public function setGeometry(GeometryContract $geometry): self
    {
        $this->geometry = $geometry;

        return $this;
    }

    /**
     * Returns the request as an array object.
     *
     * @return array{
     *      geometry: array{
     *          format: string,
     *          data: string
     *      }
     *  }
     */
    public function getRequest(): array
    {
        return [
            'geometry' => [
                'format' => 'geojson',
                'data'   => (string) $this->geometry,
            ],
        ];
    }

    /**
     * Undocumented function
     *
     * @return \App\Services\DataObjects\KittyhawkResponse
     */
    public function query(): KittyhawkResponse
    {
        if (is_null($this->geometry)) {
            throw new Exception('Unable to make a request without geometry set.');
        }

        try {
            $response = $this->http->post(self::ENDPOINT, ['json' => $this->getRequest()]);
            $responseJson = $this->processResponse($response);
        } catch (ClientException $exception) {
            $responseJson = $this->processResponse($exception->getResponse());
        }

        return new KittyhawkResponse($responseJson);
    }

    private function processResponse(Response $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
