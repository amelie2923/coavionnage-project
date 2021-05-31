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

    // Test of a traveler who registers with having non authorize characters

    public function testNameWithDigits()
    {
        $userData = [
            "name" => "Doe666",
            "email" => "doe@example.com",
            "password" => "Demo12345!",
            "confirm_password" => "Demo12345!"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "name" => ['Votre nom doit contenir uniquement des lettres']
                ]
            ]);
    }

    // Test of a traveler who registers without having given his email

    public function testEmailEmpty()
    {
        $userData = [
            "name" => "Doe",
            "password" => "Demo12345!",
            "confirm_password" => "Demo12345!"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "email" => ['Vous devez spécifier votre email']
                ]
            ]);
    }

    // Test of a traveler who registers without having given his password

    public function testPasswordEmpty()
    {
        $userData = [
            "name" => "Doe",
            "email" => "doe@example.com",
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "password" => ['Vous devez spécifier votre mot de passe']
                ]
            ]);
    }

    // Test of a traveler who registers with a password too short

    public function testPasswordTooShort()
    {
        $userData = [
            "name" => "Doe",
            "email" => "doe@example.com",
            "password" => "Do1234!",
            "confirm_password" => "Do1234!"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "password" => ['Votre mot de passe doit faire au minimum 8 caractères']
                ]
            ]);
    }

    // Test of a traveler who registers with a password whithout special chars & digits

    public function testPasswordWithoutSpecialCharsAndDigits()
    {
        $userData = [
            "name" => "Doe",
            "email" => "doe@example.com",
            "password" => "demotest", // Password not contain special char, digits and uppercase
            "confirm_password" => "demotest"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "password" => ['Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial']
                ]
            ]);
    }

    // Test of a traveler who registers without having confirmed his password

    public function testConfirmPasswordEmpty()
    {
        $userData = [
            "name" => "Doe",
            "email" => "doe@example.com",
            "password" => "Demo12345!",
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
