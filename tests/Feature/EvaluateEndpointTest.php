<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EvaluateEndpointTest extends TestCase
{
    public function test_x_capacity_absence(): void
    {
        $response = $this->postJson('/api/v1/wjc/evaluate', [
            'y_capacity' => 10,
            'z_amount_wanted' => 4,
        ]);

        $response
            ->assertStatus(422);

        $this->assertTrue(in_array("The x capacity field is required.", $response->json("errors")["x_capacity"]));
    }

    public function test_invalid_x_capacity_type(): void
    {
        $response = $this->postJson('/api/v1/wjc/evaluate', [
            'x_capacity' => 'string',
            'y_capacity' => 10,
            'z_amount_wanted' => 4,
        ]);

        $response
            ->assertStatus(422);

        $this->assertTrue(in_array("The x capacity field must be an integer.", $response->json("errors")["x_capacity"]));
    }

    public function test_y_capacity_absence(): void
    {
        $response = $this->postJson('/api/v1/wjc/evaluate', [
            'x_capacity' => 2,
            'z_amount_wanted' => 4,
        ]);

        $response
            ->assertStatus(422);

        $this->assertTrue(in_array("The y capacity field is required.", $response->json("errors")["y_capacity"]));
    }

    public function test_invalid_y_capacity_type(): void
    {
        $response = $this->postJson('/api/v1/wjc/evaluate', [
            'x_capacity' => 2,
            'y_capacity' => 'string',
            'z_amount_wanted' => 4,
        ]);

        $response
            ->assertStatus(422);

        $this->assertTrue(in_array("The y capacity field must be an integer.", $response->json("errors")["y_capacity"]));
    }

    public function test_z_amount_wanted_absence(): void
    {
        $response = $this->postJson('/api/v1/wjc/evaluate', [
            'x_capacity' => 2,
            'y_capacity' => 10,
        ]);

        $response
            ->assertStatus(422);

        $this->assertTrue(in_array("The z amount wanted field is required.", $response->json("errors")["z_amount_wanted"]));
    }

    public function test_invalid_z_amount_wanted_type(): void
    {
        $response = $this->postJson('/api/v1/wjc/evaluate', [
            'x_capacity' => 2,
            'y_capacity' => 10,
            'z_amount_wanted' => 'string',
        ]);

        $response
            ->assertStatus(422);

        $this->assertTrue(in_array("The z amount wanted field must be an integer.", $response->json("errors")["z_amount_wanted"]));
    }

    public function test_invalid_z_amount_wanted_below_bound(): void
    {
        $response = $this->postJson('/api/v1/wjc/evaluate', [
            'x_capacity' => 2,
            'y_capacity' => 10,
            'z_amount_wanted' => 1,
        ]);

        $response
            ->assertStatus(200);

        $this->assertFalse($response->json("success"));

        $this->assertEquals("No Solution", $response->json("message"));
    }

    public function test_invalid_z_amount_wanted_above_bound(): void
    {
        $response = $this->postJson('/api/v1/wjc/evaluate', [
            'x_capacity' => 2,
            'y_capacity' => 10,
            'z_amount_wanted' => 15,
        ]);

        $response
            ->assertStatus(200);

        $this->assertFalse($response->json("success"));

        $this->assertEquals("No Solution", $response->json("message"));
    }

    public function test_invalid_z_amount_wanted_incorrect_solution(): void
    {
        $response = $this->postJson('/api/v1/wjc/evaluate', [
            'x_capacity' => 2,
            'y_capacity' => 10,
            'z_amount_wanted' => 5,
        ]);

        $response
            ->assertStatus(200);

        $this->assertFalse($response->json("success"));

        $this->assertEquals("No Solution", $response->json("message"));
    }

    public function test_valid_solution(): void
    {
        $response = $this->postJson('/api/v1/wjc/evaluate', [
            'x_capacity' => 2,
            'y_capacity' => 10,
            'z_amount_wanted' => 4,
        ]);

        $response
            ->assertStatus(200);

        $this->assertTrue(is_array($response->json("solution")));

        $this->assertTrue(is_numeric($response->json("solution")[0]["step"]));
        $this->assertTrue(is_numeric($response->json("solution")[0]["bucketX"]));
        $this->assertTrue(is_numeric($response->json("solution")[0]["bucketY"]));
        $this->assertTrue(is_string($response->json("solution")[0]["action"]));
    }
}
