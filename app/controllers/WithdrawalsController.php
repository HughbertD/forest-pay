<?php

class WithdrawalsController extends BaseController
{
    public function toBank()
    {
        $banks = \BankAccount::where('user_id', Auth::user()->id)->get();
        foreach ($banks as $bank) {
            $bankList[$bank->id] = $bank->displayName;
        }
        return View::make('withdrawals.add', compact('banks', 'bankList'));
    }
}