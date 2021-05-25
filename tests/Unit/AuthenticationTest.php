<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Models\User;
use App\Http\Controllers\Api\AuthController;

class AuthenticationTest extends TestCase
{
    /********* Tests for traveller role register (route api/register) *********/

    /** @test */

    // Test of a traveler who registers without having given his name

    public function testNameEmpty()
    {
        $userData = [
            "email" => "doe@example.com",
            "password" => "demo12345!",
            "confirm_password" => "demo12345!"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "name" => ['Vous devez spécifier votre nom']
                ]
            ]);
    }

    // Test of a traveler who registers without having confirmed his password

    public function testConfirmPasswordEmpty()
    {
        $userData = [
            "name" => "Doe",
            "email" => "doe@example.com",
            "password" => "demo12345!",
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "confirm_password" => ['Le champ de confirmation du mot de passe est obligatoire']
                ]
            ]);
    }

    // Test of a traveler who registers with an incorrect confirmation password

    public function testPasswordAndConfirmPasswordNotMatching()
    {
        $userData = [
            "name" => "Doe",
            "email" => "doe@example.com",
            "password" => "Demo12345!",
            "confirm_password" => "12345Demo!", // Passwords not match
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "confirm_password" => ['Votre mot de passe et votre mot de passe de confirmation doivent être identiques']
                ]
            ]);
    }
}
