<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    
public function register(Request $request){
     
$validator = $this->validator($request->all());
    if($validator->fails()){
           return response()->json([
            'errors' => $validator->errors()
        ], 422); 
    };

    $user = $this->create($validator->validated());
    Auth::login($user);
     return response()->json([
        'user' => $user
    ], 201);

    
}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
       return Validator::make($data, [
    'name' => ['required', 'string', 'max:255'],

    'email' => [
        'required',
        'string',
        'email',
        'max:255',
        'unique:users'
    ],

    'password' => [
        'required',
        'string',
        'min:8',
        'confirmed'
    ],
]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            
        ]);
    }
}
