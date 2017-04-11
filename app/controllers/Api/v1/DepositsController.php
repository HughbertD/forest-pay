<?php

namespace Api\v1;

use ForestPay\Services\Creation\ForestPayDeposit;
use ForestPay\Services\Validation\Deposit;

class DepositsController extends \BaseController
{
    public function store()
    {
        $data = \Input::only('to_user', 'amount', 'reference', 'from_user');

        $user = \User::ofEmail($data['to_user'])->with('wallet')->first();

        if ($user instanceof \User) {
            $data['wallet_id'] = $user->wallet()->first()->id;
            $data['user_id'] = $user->id;
        }

        $depositValidator = new Deposit($data);
        if ($depositValidator->fails()) {
            return \Response::json($depositValidator->messages(), 400);
        }

        $depositBuilder = new ForestPayDeposit($depositValidator->data());
        $deposit = $depositBuilder->build();
        $deposit->save();

        return \Response::json($deposit->toArray());
    }
}