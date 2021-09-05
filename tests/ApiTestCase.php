<?php


namespace Tests;


use App\Models\User;
use GuzzleHttp\Client;

class ApiTestCase extends TestCase
{

    public function loginOwner()
    {
        $user = User::firstOrCreate(['role' => 'owner']);
        $this->actingAs($user, 'api');
    }

    public function loginCustomer()
    {
        $user = User::firstOrCreate(['role' => 'user']);
        $this->actingAs($user, 'api');
    }
}