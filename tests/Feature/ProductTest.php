<?php


namespace Tests\Feature;


use Tests\ApiTestCase;

class ProductTest extends ApiTestCase
{

    public function test_get_store_list_as_customer()
    {
        $this->loginCustomer();

        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }

    public function test_post_product()
    {
        $this->loginOwner();

        $data = [
            'name' => 'product',
            'quantity' => 100,
            'product_attributes' => [
                [
                    'name' => 'size',
                    'value' => 'M',
                ],
                [
                    'name' => 'color',
                    'value' => 'blue',
                ],
            ],
            'price' =>
                [
                    'value' => 21.35,
                    'currency' => 'USD',
                ],
        ];

        $response = $this->post('/api/products', $data);

        $response->assertStatus(201);
    }

    public function test_update_product()
    {
        $this->loginOwner();

        $data = [
            'name' => 'product change',
            'quantity' => 300,
            'product_attributes' => [
                [
                    'id' => 1,
                    'name' => 'size',
                    'value' => 'M',
                ],
                [
                    'id' => 2,
                    'name' => 'color',
                    'value' => 'blue',
                ],
                [
                    'name' => 'shape',
                    'value' => 'slim-fit',
                ],
            ],
            'price' =>
                [
                    'value' => 25.00,
                    'currency' => 'HRK',
                ],
        ];

        $response = $this->post('/api/products', $data);

        $response->assertStatus(201);
    }

    public function test_update_product_as_customer()
    {
        $this->loginCustomer();

        $data = [
            'name' => 'product change',
            'quantity' => 300,
            'product_attributes' => [
                [
                    'id' => 1,
                    'name' => 'size',
                    'value' => 'M',
                ],
                [
                    'id' => 2,
                    'name' => 'color',
                    'value' => 'blue',
                ],
                [
                    'name' => 'shape',
                    'value' => 'slim-fit',
                ],
            ],
            'price' =>
                [
                    'value' => 25.00,
                    'currency' => 'HRK',
                ],
        ];

        $response = $this->post('/api/products', $data);

        $response->assertStatus(403);
    }
}