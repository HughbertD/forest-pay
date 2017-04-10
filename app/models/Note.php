<?php

    class Note extends Eloquent
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        $this->belongsTo('User');
    }
}