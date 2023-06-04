<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;
use App\Http\Requests\UserRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class UserRequestTest extends TestCase
{
    public function testValidationRules()
    {
        $request = new UserRequest();
        $rules = $request->rules();

        $this->assertArrayHasKey('limit', $rules);
    }

    public function testMessages()
    {
        $request = new UserRequest();
        $messages = $request->messages();

        $this->assertEquals('The :attribute field is required.', $messages['required']);
        $this->assertEquals('The :attribute folder must not exceed :max in size.', $messages['max']);
        $this->assertEquals('The :attribute must be a file of type: :values.', $messages['mimes']);
        $this->assertEquals('The :attribute must be a string.', $messages['string']);
        $this->assertEquals('The :attribute must be an integer.', $messages['integer']);
        $this->assertEquals('The :attribute must be an Array.', $messages['array']);
    }
}
