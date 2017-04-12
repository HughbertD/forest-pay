<?php

namespace Api\v1;

use ForestPay\Services\Creation\ForestPayWithdrawal;
use ForestPay\Services\Validation\Withdrawal;

class WithdrawalsController extends \BaseController
{
    public function toBank()
    {
        $data = \Input::only('bank_id', 'amount');
        $data['user_id'] = \Auth::user()->id;
        $data['wallet_id'] = \Auth::user()->wallet()->get()->first()->id;

        $withdrawalValidator = new Withdrawal($data, \Auth::user()->transactions()->get()->balance());
        if ($withdrawalValidator->fails()) {
            return \Response::json($withdrawalValidator->messages(), 400);
        }

        $withdrawal = (new ForestPayWithdrawal($withdrawalValidator->data()))->build();
        return \Response::json($withdrawal->toArray());
    }
}