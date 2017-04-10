<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $hidden = ['password'];

	public $fillable = ['username', 'password'];

	public function bankAccounts()
    {
        return $this->hasMany('BankAccount');
    }

    public function notes()
    {
        return $this->hasMany('Note');
    }

	public function profile()
    {
        return $this->hasOne('Profile');
    }

    public function transactions()
    {
        return $this->hasMany('Transaction');
    }

    public function wallet()
    {
        return $this->hasOne('Wallet');
    }
}
