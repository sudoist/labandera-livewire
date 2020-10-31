<?php

namespace App\Http\Livewire\Auth;

use App\Helpers\API\GuzzleHelper;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var bool */
    public $remember = false;

    protected $rules = [
        'email' => ['required', 'email'],
        'password' => ['required'],
    ];

    public function authenticate()
    {
        $this->validate();

        // Auth with API
        $guzzleHelper = new GuzzleHelper();
        $request = '/api/auth/login';

        $body = [
            "email" => $this->email,
            "password" => $this->password
        ];

        $response = $guzzleHelper->post($request, $body);

        if ($response == '404' || $response == '401') {
            $this->addError('email', trans('auth.failed'));

            return false;
        }

        $findUser = User::where('email', $this->email)->first();

        if ($findUser) {

            Auth::login($findUser);
            session(['token' => $response->token]);

            return redirect()->intended(route('home'));

        } else {
            $newUser = User::create([
                'name' => $this->email,
                'email' => $this->email,
                'password' => encrypt('DragonBleaPiece')
            ]);

            Auth::login($newUser);
            session(['token' => $response->token]);

            return redirect()->intended(route('home'));
        }

    }

    public function render()
    {
        return view('livewire.auth.login')->extends('layouts.auth');
    }
}
