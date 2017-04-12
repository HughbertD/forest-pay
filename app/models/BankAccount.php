<?php

class BankAccount extends Eloquent
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function transactions()
    {
        return $this->hasMany('Transaction');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function getDisplayNameAttribute()
    {
        return $this->name . " (" . $this->bank_name . ")";
    }
}