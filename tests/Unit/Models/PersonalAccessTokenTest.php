<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\PersonalAccessToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;

class PersonalAccessTokenTest extends TestCase
{
    // use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Refresh MongoDB collections
        $this->refreshMongoCollections();
    }

    protected function refreshMongoCollections()
    {
        // Drop the existing collection
        Schema::dropIfExists('personal_access_tokens');

        // Recreate the collection
        Schema::create('personal_access_tokens', function (Blueprint $collection) {
            // Add fields to the collection as needed
        });
    }

    public function testFindToken()
    {
        // Create a new PersonalAccessToken instance
        $token = PersonalAccessToken::factory()->create();

        // Call the findToken method with the generated token
        $foundToken = PersonalAccessToken::find($token->_id);
        // Perform assertions
        // $this->assertInstanceOf(PersonalAccessToken::class, $foundToken);
        $this->assertEquals($token->id, $foundToken->id);
    }

    public function testFindTokenWithValidToken()
    {
        // Create a new PersonalAccessToken instance
        $token = PersonalAccessToken::factory()->create([
            'token' => hash('sha256', 'valid-token'),
        ]);

        // Call the findToken method with the valid token
        $foundToken = PersonalAccessToken::findToken('valid-token');

        // Perform assertions
        $this->assertInstanceOf(PersonalAccessToken::class, $foundToken);
        $this->assertEquals($token->id, $foundToken->id);
    }

    public function testFindTokenWithInvalidToken()
    {
        // Call the findToken method with an invalid token
        $foundToken = PersonalAccessToken::findToken('invalid-token');

        // Perform assertions
        $this->assertNull($foundToken);
    }

    public function testFindTokenWithCompositeToken()
    {
        // Create a new PersonalAccessToken instance
        $token = PersonalAccessToken::factory()->create([
            'token' => hash('sha256', 'valid-token'),
        ]);

        // Create a composite token with ID and token separated by "|"
        $compositeToken = $token->id . '|' . 'valid-token';

        // Call the findToken method with the composite token
        $foundToken = PersonalAccessToken::findToken($compositeToken);

        // Perform assertions
        $this->assertInstanceOf(PersonalAccessToken::class, $foundToken);
        $this->assertEquals($token->id, $foundToken->id);
    }
    public function testCan()
    {
        // Create a new PersonalAccessToken instance
        $token = new PersonalAccessToken([
            'abilities' => ['create', 'edit'],
        ]);

        // Perform assertions
        $this->assertTrue($token->can('create'));
        $this->assertTrue($token->can('edit'));
        $this->assertFalse($token->can('delete'));
    }

    public function testCant()
    {
        // Create a new PersonalAccessToken instance
        $token = new PersonalAccessToken([
            'abilities' => ['create', 'edit'],
        ]);

        // Perform assertions
        $this->assertFalse($token->cant('create'));
        $this->assertFalse($token->cant('edit'));
        $this->assertTrue($token->cant('delete'));
    }
}
