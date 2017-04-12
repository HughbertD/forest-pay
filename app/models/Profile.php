<?php

class Profile extends Eloquent
{
    public $fillable = ['first_name', 'last_name'];

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }
}