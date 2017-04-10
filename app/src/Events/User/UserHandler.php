<?php

namespace ForestPay\Events\User;

use ForestPay\Events\EnterNoteTrait;

class UserHandler
{
    use EnterNoteTrait;

    public function onCreate(\User $user)
    {
        $this->createNote([
            'user_id' => $user->id,
            'event' => 'User Created',
            'data' => json_encode($user)
        ]);
    }

    public function wasRegistered(\User $user)
    {
        $this->createNote([
            'user_id' => $user->id,
            'event' => 'User Registered',
            'data' => json_encode($user)
        ]);
    }
}