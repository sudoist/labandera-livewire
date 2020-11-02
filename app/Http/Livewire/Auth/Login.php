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

    public function authenticate(GuzzleHelper $guzzleHelper)
    {
        $this->validate();

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
            $this->setSessionData('token', $response->token);
            $this->getUserInfo($guzzleHelper);

            return redirect()->intended(route('home'));

        } else {
            $newUser = User::create([
                'name' => $this->email,
                'email' => $this->email,
                'password' => encrypt('DragonBleaPiece')
            ]);

            Auth::login($newUser);
            $this->setSessionData('token', $response->token);
            $this->getUserInfo($guzzleHelper);

            return redirect()->intended(route('home'));
        }

    }

    private function setSessionData($key, $value)
    {
        session([$key => $value]);
    }

    private function getUserInfo(GuzzleHelper $guzzleHelper)
    {

        $requests = [
            'user' => '/api/auth/me',
        ];

        $responses = $guzzleHelper->get($requests);

        $user = json_decode($responses['user']->getBody()->getContents());

        $this->setSessionData('name', $user->name);
        $this->setSessionData('email', $user->email);
    }

    public function render()
    {
        return view('livewire.auth.login')->extends('layouts.auth');
    }
}
