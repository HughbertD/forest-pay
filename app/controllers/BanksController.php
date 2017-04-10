<?php

class BanksController extends BaseController
{
    protected $allowedTemplates = ['banks.add'];

    public function template($template)
    {
        return parent::template($template);
    }

    public function index()
    {
        $banks = \BankAccount::where('user_id', Auth::user()->id)->get();
        return View::make('banks.index', compact('banks'));
    }
}