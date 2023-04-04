<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use WithFaker;

    public function __construct()
    {
        parent::__construct();
        $this->setUpFaker();
    }

    /**
     * Contact create test.
     *
     * @return void
     */
    public function testCreateContact()
    {
        $data = [
            "user" => [
                "email" => $this->faker->email,
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

    /**
     * Contact update test.
     *
     * @return void
     */
    public function testUpdateContact()
    {
        $contact = Contact::first();

        $data = [
            "user" => [
                "name" => "test",
                "email" => "test@example.com",
                "phone_numbers" => [
                    [
                        "id" => 1,
                        "phone_type_id" => "1",
                        "phone_number" => "01234566799999"
                    ],
                    [
                        "id" => 1,
                        "phone_type_id" => "1",
                        "phone_number" => "01234566799"
                    ]
                ],
                "addresses" => [
                    [
                        "id" => 1,
                        "address_line" => "address line 1",
                        "pincode" => "12345"
                    ],
                    [
                        "id" => 1,
                        "address_line" => "address line 2",
                        "pincode" => "12345"
                    ]
                ]
            ]
        ];

        $response = $this->put('/api/contacts/' . $contact->id, $data);

        $response->assertStatus(200);
    }

    /**
     * Contact delete test.
     *
     * @return void
     */
    public function testDeleteContact()
    {
        $contact = Contact::first();

        $response = $this->delete('/api/contacts/' . $contact->id);

        $response->assertStatus(200);
    }
}
