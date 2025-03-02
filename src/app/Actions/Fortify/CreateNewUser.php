<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $request = new RegisterRequest();
        $request->merge($input);
        $validated = $request->validate($request->rules());

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($validated['password']),
        ]);
    }
}
