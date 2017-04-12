<?php

namespace Api\v1;

use ForestPay\Services\Creation\ForestPayWithdrawal;
use ForestPay\Services\Validation\BankAccount;
use ForestPay\Services\Validation\Withdrawal;

class BanksController extends \BaseController
{
    public function store()
    {
        $data = \Input::only('bank_name', 'name', 'iban', 'beneficiary_name');
        $data['user_id'] = \Auth::user()->id;

        $bankValidator = new BankAccount($data);
        if ($bankValidator->fails()) {
            return \Response::json($bankValidator->messages(), 400);
        }

        $bank = new \BankAccount($bankValidator->data());
        $bank->save();

        return \Response::json($bank->toArray());
    }

    public function withdraw()
    {
        $data = \Input::only('bank_id', 'amount');
        $data['user_id'] = \Auth::user()->id;
        $data['wallet_id'] = \Auth::user()->wallet()->get()->first()->id;

        $withdrawalValidator = new Withdrawal($data);
        if ($withdrawalValidator->fails()) {
            return \Response::json($withdrawalValidator->messages(), 400);
        }

        $withdrawal = (new ForestPayWithdrawal($withdrawalValidator->data()))->build();
        return \Response::json($withdrawal->toArray());
    }
}