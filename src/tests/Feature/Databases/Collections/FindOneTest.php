<?php

namespace Tests\Feature\Databases\Collections;

use Tests\TestCase;

class FindOneTest extends TestCase
{
    /**
     * @return void
     */
    public function testOK()
    {
        $response = $this->json('POST', 'http://127.0.0.1:8000/api/v1/storage/jsons/databases/database/collections/collection/insertOne', [
            "id" => 1,
            "name" => "Leanne Graham",
            "username" => "Bret",
            "email" => "Sincere@april.biz",
            "address" => [
                "street" => "Kulas Light",
                "suite" => "Apt. 556",
                "city" => "Gwenborough",
                "zipcode" => "92998-3874",
                "geo" => [
                    "lat" => "-37.3159",
                    "lng" => "81.1496"
                ]
            ],
            "phone" => "1-770-736-8031 x56442",
            "website" => "hildegard.org",
            "company" => [
                "name" => "Romaguera-Crona",
                "catchPhrase" => "Multi-layered client-server neural-net",
                "bs" => "harness real-time e-markets"
            ]
        ]);

        $response = $this->get('http://127.0.0.1:8000/api/v1/storage/jsons/databases/database/collections/collection/findOne?' . http_build_query([
            'filter' => '{"id":1,"name":"Leanne Graham","email":"Sincere@april.biz"}',
            'options' => '{"sort":{"_id":-1}}',
        ]));

        $response->assertStatus(200);
    }

    public function testNotFound()
    {
        $response = $this->get('http://127.0.0.1:8000/api/v1/storage/jsons/databases/database/collections/collection/findOne?' . http_build_query([
            'filter' => '{"id":3,"name":"Leanne Graham","email":"Sincere@april.biz"}',
            'options' => '{"sort":{"_id":-1}}',
        ]));

        $response->assertStatus(404);
    }
}