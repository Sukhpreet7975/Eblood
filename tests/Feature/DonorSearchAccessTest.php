<?php

use App\Models\User;

test('donor users can access the donor search routes', function () {
    $donor = User::create([
        'name' => 'Donor User',
        'email' => 'donor@example.com',
        'password' => 'password',
        'role' => 'donor',
        'city' => 'Lahore',
        'blood_group' => 'O+',
        'available' => 'yes',
    ]);

    $this->actingAs($donor)
        ->get('/search')
        ->assertOk()
        ->assertSee('Find the right donor');

    $this->actingAs($donor)
        ->getJson('/live-search')
        ->assertOk();
});

test('requester users can search available donors and see limited donor details', function () {
    User::create([
        'name' => 'Amina Khan',
        'email' => 'amina@example.com',
        'password' => 'password',
        'city' => 'Lahore',
        'blood_group' => 'O+',
        'available' => 'yes',
        'role' => 'donor',
        'phone' => '03001234567',
    ]);

    User::create([
        'name' => 'Zahid Ali',
        'email' => 'zahid@example.com',
        'password' => 'password',
        'city' => 'Karachi',
        'blood_group' => 'A+',
        'available' => 'yes',
        'role' => 'donor',
        'phone' => '03009876543',
    ]);

    $requester = User::create([
        'name' => 'Requester User',
        'email' => 'requester@example.com',
        'password' => 'password',
        'role' => 'requester',
        'city' => 'Lahore',
    ]);

    $response = $this->actingAs($requester)
        ->get('/search?city=Lahore&blood_group=O+');

    $response->assertOk();
    $response->assertSee('Amina Khan');
    $response->assertSee('O+');
    $response->assertSee('Available now');
    $response->assertDontSee('03001234567');
    $response->assertDontSee('Phone');
});
