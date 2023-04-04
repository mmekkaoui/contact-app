<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    /**
     * Contact controller test.
     *
     * @return void
     */
    public function testCreateContact()
    {
        $data = [
            "user" => [
                "email" => "test@example.com",
                "name" => "test",
                "phone_numbers" => [
                    [
                        "phone_type_id" => "1",
                        "phone_number" => "01234566799"
                    ],
                    [
                        "phone_type_id" => "1",
                        "phone_number" => "01234566799"
                    ]
                ],
                "addresses" => [
                    [
                        "address_line" => "address line 1",
                        "pincode" => "12345"
                    ],
                    [
                        "address_line" => "address line 2",
                        "pincode" => "12345"
                    ]
                ]
            ]
        ];

        $response = $this->post('/api/contacts', $data);

        $response->assertStatus(200);
    }
}
