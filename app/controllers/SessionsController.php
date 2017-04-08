<?php

class SessionsController extends BaseController
{
    /**
     * @var User
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create()
	{
	    if (Auth::check()) {
	        return Redirect::to('/');
        }

		return View::make('sessions.login');
	}

	public function destroy()
    {
        Auth::logout();
        return Redirect::to('/login');
    }

	public function store()
    {
        if (Auth::attempt(Input::only('username', 'password'))) {
            dd("Success");
        }

        return Redirect::back()->withInput();
    }
}
