<?php

namespace Tests\Unit\Http\Requests\Traits;

use Tests\TestCase;
use App\Http\Requests\StoreRequest;

class MessageTraitTest extends TestCase
{

    public function testMessages()
    {
        $request = new StoreRequest();
        $messages = $request->messages();

        $this->assertEquals('The :attribute field is required.', $messages['required']);
        $this->assertEquals('The :attribute folder must not exceed :max in size.', $messages['max']);
        $this->assertEquals('The :attribute must be a file of type: :values.', $messages['mimes']);
        $this->assertEquals('The :attribute must be a string.', $messages['string']);
        $this->assertEquals('The :attribute must be an integer.', $messages['integer']);
        $this->assertEquals('The :attribute must be an Array.', $messages['array']);
    }
}
