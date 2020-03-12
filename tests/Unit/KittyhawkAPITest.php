<?php

namespace Tests\Unit;

use App\Services\DataObjects\KittyhawkResponse;
use GeoJSON\Geometry\Factory;
use App\Services\KittyhawkAPI;
use PHPUnit\Framework\TestCase;

class KittyhawkAPITest extends TestCase
{
    /** @test */
    public function api_returns_instance_of_kittyhawk_response()
    {
        /** @var KittyhawkAPI $api */
        $api = app(KittyhawkAPI::class);
        $response = $api->setGeometry(Factory::prep()->setCoordinates([1.2, 3.4])->get())
            ->query();

        $this->assertInstanceOf(KittyhawkResponse::class, $response);
    }
}
