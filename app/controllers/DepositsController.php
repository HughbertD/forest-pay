<?php

class DepositsController extends BaseController
{
    protected $allowedTemplates = ['deposits.add'];

    public function template($template)
    {
        return parent::template($template);
    }

    public function index()
    {
        $deposits = \Deposit::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->limit(10)->get();
        return View::make('deposits.index', compact('deposits'));
    }
}