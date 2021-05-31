<?php

namespace App\Http\Validation;


class RegisterValidation {
    public function rules() {
        return [
            'name' => ['required', 'string', 'max:150', 'min:3', 'regex:/^[a-zA-Z]+$/u'],
            'email' => ['required', 'string', 'email', 'max:150', 'min:3', 'unique:users'],
            'password' => [
                'required', 'string', 'min:8',
                // 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/',
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character,
            ],
            'confirm_password' => ['required', 'same:password'],
        ];
    }


    public function messages() {
        return [
            'name.required' => 'Vous devez spécifier votre nom',
            'name.regex' => 'Votre nom doit contenir uniquement des lettres',
            'email.required' => 'Vous devez spécifier votre email',
            'password.required' => 'Vous devez spécifier votre mot de passe',
            'password.min' => 'Votre mot de passe doit faire au minimum 8 caractères',
            'password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial',
            'confirm_password.required' => 'Le champ de confirmation du mot de passe est obligatoire',
            'confirm_password.same' => 'Votre mot de passe et votre mot de passe de confirmation doivent être identiques'
        ];
    }
}