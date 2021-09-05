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
        $user = User::find(2);
        $this->actingAs($user, 'api');
    }
}