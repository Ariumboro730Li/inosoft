<?php

namespace Tests\Unit\Services;

use App\Repositories\VehicleRepository;
use App\Services\VehicleService;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Http\JsonResponse;

class VehicleServiceTest extends TestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
        return $app;
    }

    public function testGetVehicleReturnsJsonResponse()
    {
        // Arrange
        $type = 'type1';
        $repositoryMock = $this->createMock(VehicleRepository::class);
        $repositoryMock->expects($this->once())
            ->method('getVehicle')
            ->with($type)
            ->willReturn(['vehicle1', 'vehicle2']);

        $responseFactoryMock = $this->createMock(ResponseFactory::class);
        $responseFactoryMock->expects($this->once())
            ->method('json')
            ->with(['vehicle1', 'vehicle2'])
            ->willReturn(new JsonResponse(['vehicle1', 'vehicle2']));

        $requestMock = $this->createMock(Request::class);

        $this->app->instance(ResponseFactory::class, $responseFactoryMock);

        $service = new VehicleService($requestMock, $repositoryMock);

        // Act
        $result = $service->getVehicle($type);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $result);
    }

    public function testGetVehicleByIdReturnsJsonResponse()
    {
        // Arrange
        $type = 'type1';
        $id = 123;
        $repositoryMock = $this->createMock(VehicleRepository::class);
        $repositoryMock->expects($this->once())
            ->method('getVehicleById')
            ->with($id, $type)
            ->willReturn(['vehicle1']);

        $responseFactoryMock = $this->createMock(ResponseFactory::class);
        $responseFactoryMock->expects($this->once())
            ->method('json')
            ->with(['vehicle1'])
            ->willReturn(new JsonResponse(['vehicle1']));

        $requestMock = $this->createMock(Request::class);

        $this->app->instance(ResponseFactory::class, $responseFactoryMock);

        $service = new VehicleService($requestMock, $repositoryMock);

        // Act
        $result = $service->getVehicleById($type, $id);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $result);
    }
}
