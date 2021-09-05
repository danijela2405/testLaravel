<?php

namespace Tests\Feature;

use Tests\ApiTestCase;

class UserTest extends ApiTestCase
{

    public function test_get_profile()
    {
        $this->loginOwner();

        $response = $this->get('/api/auth/user-profile');

        $response->assertStatus(200);
    }


    public function test_register()
    {
        $data = [
            'name' => 'test',
            'email' => rand(1,1000).'test@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/api/auth/register', $data);

        $response->assertStatus(201);
    }

}
