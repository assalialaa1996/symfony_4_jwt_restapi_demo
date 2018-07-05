<?php

namespace App\Tests;

use App\Controller\FootballLeagueController;

class FootballLeagueControllerTest extends BaseTestCase
{
    public function testNewLeague____when_Creating_New_League____League_Is_Created_And_Returned_With_Correct_Response_Status()
    {
        $leagueName = "Test League 1";

        $data = [
            "name" => $leagueName
        ];

        $response = $this->client->post("leagues", [
            'body' => json_encode($data)
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $responseData = json_decode($response->getBody(), true);

        $this->assertArrayHasKey("data", $responseData);
        $this->assertArrayHasKey("name", $responseData['data']);
        $this->assertEquals($leagueName, $responseData['data']['name']);
    }

    public function testNewLeague____when_Creating_New_League_With_Existing_Name____League_Is_NOT_Created_And_Error_Response_Is_Returned()
    {
        // Create new league
        $leagueName = "Test League 1";

        $data = [
            "name" => $leagueName
        ];

        $response = $this->client->post("leagues", [
            'body' => json_encode($data)
        ]);

        // Now try to create new league with same name
        $response = $this->client->post("leagues", [
            'body' => json_encode($data)
        ]);

        $this->assertEquals(400, $response->getStatusCode());

        $responseData = json_decode($response->getBody(), true);
        $this->assertArrayHasKey("error", $responseData);
        $this->assertArrayHasKey("code", $responseData['error']);
        $this->assertArrayHasKey("message", $responseData['error']);
        $this->assertEquals(400, $responseData['error']['code']);
        $this->assertEquals("League with given name already exists.", $responseData['error']['message']);
    }

//    public function testNewLeague____when_Creating_New_League_With_Blank_Name____League_Is_NOT_Created_And_Error_Response_Is_Returned()
//    {
//        $leagueName = "";
//
//        $data = [
//            "name" => $leagueName
//        ];
//
//        $response = $this->client->post("leagues", [
//            'body' => json_encode($data)
//        ]);
//
//        $this->assertEquals(400, $response->getStatusCode());
//
//        $responseData = json_decode($response->getBody(), true);
//        $this->assertArrayHasKey("error", $responseData);
//        $this->assertArrayHasKey("code", $responseData['error']);
//        $this->assertArrayHasKey("message", $responseData['error']);
//        $this->assertEquals(400, $responseData['error']['code']);
//        $this->assertEquals("League with given name already exists.", $responseData['error']['message']);
//    }
}