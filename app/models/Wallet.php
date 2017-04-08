<?php

class Wallet extends Eloquent
{
    protected $fillable = ['name'];

    public function transactions()
    {
        return $this->hasMany('Transaction');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }
}