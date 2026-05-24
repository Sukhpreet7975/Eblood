<?php

use App\Models\User;

it('shows validation errors and preserves submitted values on the request form', function () {
    $requester = new User([
        'name' => 'Requester One',
        'email' => 'requester.validation@example.com',
        'password' => 'password',
        'role' => 'requester',
        'city' => 'Dhaka',
    ]);
    $requester->id = 'requester-validation-1';

    $response = $this->actingAs($requester)
        ->from(route('requester.requests.create'))
        ->followingRedirects()
        ->post(route('requester.requests.store'), [
            'patient_name' => 'Maria Cruz',
            'blood_group' => 'A+',
            'hospital' => 'City Hospital',
            'city' => 'Dhaka',
            'phone' => '',
            'message' => 'Urgent blood needed for surgery.',
        ]);

    $response->assertOk();
    $response->assertSee('The phone field is required.');
    $response->assertSee('value="Maria Cruz"', false);
    $response->assertSee('City Hospital', false);
    $response->assertSee('Urgent blood needed for surgery.', false);
});
