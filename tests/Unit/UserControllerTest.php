<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\UserController;
use App\Http\Requests\UserRequest;
use PHPUnit\Framework\Assert;

class UserControllerTest extends TestCase
{
    public function testIndexReturnsData()
    {
        $userRequest = UserRequest::create('/users', 'GET', ['limit' => 10]);
        $response = (new UserController())->index($userRequest);
        $responseData = json_decode($response->getContent(), true);
        Assert::assertArrayHasKey('data', $responseData);
        Assert::assertCount(10, $responseData['data']);    }

}
