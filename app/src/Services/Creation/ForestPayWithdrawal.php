<?php

namespace ForestPay\Services\Creation;


class ForestPayWithdrawal
{
    protected $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->data['event'] = \Withdrawal::$event;
        $this->data['data'] = '';

        if ($this->data['amount'] > 0) {
            $this->data['amount'] = (0 - $this->data['amount']);
        }
    }

    public function build()
    {
        $withdrawal = new \Withdrawal($this->data);
        $withdrawal->save();

        $withdrawal->data = json_encode(array_merge($withdrawal->toArray(), $this->data));
        $withdrawal->save();
        return $withdrawal;
    }
}