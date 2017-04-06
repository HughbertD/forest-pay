<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $hidden = array('password');

	public function bankAccounts()
    {
        return $this->hasMany('BankAccount');
    }

	public function profile()
    {
        return $this->hasOne('Profile');
    }

    public function wallet()
    {
        return $this->hasOne('Wallet');
    }
}
