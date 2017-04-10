<?php

use ForestPay\Services\Creation\ForestPayUser;
use ForestPay\Services\Validation\ValidationOfficer;

use Illuminate\Support\MessageBag;

class UsersController extends BaseController
{
    /**
     * @var User
     */
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function me()
    {
        $user = User::find(Auth::user()->id);
        return View::make('users.me', ['user' => $user]);
    }

    /**
     * Create a new user, log them in, send them to /me
     */
    public function store()
    {
        $validationOfficer = new ValidationOfficer(
            new \ForestPay\Services\Validation\User($input = Input::all()),
            new \ForestPay\Services\Validation\Profile(Input::get('profile'))
        );

        if ($validationOfficer->fails()) {
            return Redirect::back()->withInput()->withErrors($validationOfficer->messages());
        }

        try {
            $userBuilder = new ForestPayUser($input);
            $user = $userBuilder->build();
        } catch (\Exception $e) {
            // @todo: Logging
            return Redirect::back()->withInput()->withErrors(new MessageBag([
                'general' => 'Sorry, something went wrong, please contact support'
            ]));
        }

        Auth::login($user);
        return Redirect::to('/me');
    }
}