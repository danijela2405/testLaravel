<?php


namespace Tests\Feature;


use Tests\ApiTestCase;

class ReservationTest extends ApiTestCase
{

    public function test_get_reservation_list_as_customer()
    {
        $this->loginCustomer();

        $response = $this->get('/api/reservations');

        $response->assertStatus(200);
    }

    public function test_get_reservation_list_as_owner()
    {
        $this->loginOwner();

        $response = $this->get('/api/reservations');

        $response->assertStatus(200);
    }

    public function test_post_reservation()
    {
        $this->loginCustomer();

        $data = [
            'pick_up_date' => new \DateTime('tomorrow'),
            'product_id' => 2
        ];

        $response = $this->post('/api/reservations', $data);

        $response->assertStatus(201);
    }

    public function test_update_reservation()
    {
        $this->loginCustomer();

        $data = [
            'pick_up_date' => new \DateTime('+ 3 days')
        ];

        $response = $this->put('/api/reservations/1', $data);

        $response->assertStatus(200);
    }
}