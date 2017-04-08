<?php

namespace ForestPay\Services\Creation;

/**
 * Class Builder
 * Get a valid ForestPay user
 * @package ForestPay\Services\Production\ForestPayUser
 */
class ForestPayUser
{
    /**
     * @var array
     */
    private $data = [
        'profile' => [], 'wallet' => [
            'name' => 'My Wallet',
        ]
    ];

    public function __construct(array $data = [])
    {
        $this->data = array_merge($this->data, $data);
        $this->data['password'] = \Hash::make($this->data['password']);
    }

    public function build()
    {
        $user = \DB::transaction(function () {
            $user = new \User($this->data);
            $user->save();
            $user->profile()->save(new \Profile($this->data['profile']));
            $user->wallet()->save(new \Wallet($this->data['wallet']));
            return $user;
        });
        return $user;
    }
}