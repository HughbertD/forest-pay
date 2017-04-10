<?php

namespace Api\v1;

use ForestPay\Services\Validation\BankAccount;

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
}