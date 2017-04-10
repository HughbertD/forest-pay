<?php

namespace ForestPay\Events\User;

class UserSubscriber
{
    public function subscribe($events)
    {
        $events->listen('eloquent.created: User', 'ForestPay\Events\User\UserHandler@onCreate');
    }
}