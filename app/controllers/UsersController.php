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

    protected $allowedTemplates = ['users.pay'];

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function pay($username)
    {
        $user = \User::where('username', $username)->with('profile')->first();
        return View::make('users.pay', compact('user'));
    }

    /**
     * @return mixed
     */
    public function me()
    {
        $user = User::find(Auth::user()->id);
        $deposits = $user->deposits()->orderBy('created_at', 'desc')->limit(10)->get();
        $transactions = \Transaction::where('user_id', $user->id)->get();

        return View::make('users.me', ['user' => $user, 'wallet' => $user->wallet()->first(), 'banks' => $user->bankAccounts()->get(), 'deposits' => $deposits, 'transactions' => $transactions]);
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
        Event::fire('User.wasRegistered', [$user]);
        return Redirect::to('/me');
    }
}