<?php


namespace Tests\Feature;


use Tests\ApiTestCase;

class StoreTest extends ApiTestCase
{

    public function test_get_store_list_as_customer()
    {
        $this->loginCustomer();

        $response = $this->get('/api/stores');

        $response->assertStatus(200);
    }


    public function test_get_store_single_list_as_customer()
    {
        $this->loginCustomer();

        $response = $this->get('/api/stores/1');

        $response->assertStatus(200);
    }

    public function test_post_store()
    {
        $this->loginOwner();

        $data = [
            'name' => 'test store'
        ];

        $response = $this->post('/api/stores', $data);

        $response->assertStatus(201);
    }

    public function test_edit_store()
    {
        $this->loginOwner();

        $data = [
            'name' => 'test store2'
        ];

        $response = $this->put('/api/stores/1', $data);

        $response->assertStatus(200);
    }
}
