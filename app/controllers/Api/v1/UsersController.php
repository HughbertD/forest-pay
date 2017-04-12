<?php

namespace Api\v1;

use ForestPay\Services\Creation\MoneyTransfer\ForestPayTransfer;
use ForestPay\Services\Creation\MoneyTransfer\InsufficientFundException;
use ForestPay\Services\Creation\MoneyTransfer\PaymentFailureException;
use ForestPay\Services\Creation\MoneyTransfer\TransferValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsersController extends \BaseController
{
    public function find($username)
     {
         try {
            $user = \User::where('username', $username)->select('username')->firstOrFail();
         } catch (ModelNotFoundException $e) {
            return \Response::make('User not found', 404);
         }
         return \Response::json($user->toArray());
     }

     public function pay()
     {
         $data = \Input::only(['username', 'amount', 'reference']);
         try {
            $transferBuilder = new ForestPayTransfer(\Auth::user()->id, $data['username'], $data['amount'], $data['reference']);
            $transfer = $transferBuilder->pay();
         } catch (InsufficientFundException $e) {
             return \Response::json(['general' => [$e->getMessage()]], 400);
         } catch (ModelNotFoundException $e) {
             return \Response::json(['general' => [ForestPayTransfer::$errorMessages['cannot_find_user']]], 404);
         } catch (PaymentFailureException $e) {
             return \Response::json(['general' => [$e->getMessage()]], 400);
         } catch (TransferValidationException $e) {
            return \Response::json(['general' => [$e->getMessage()]], 400);
         }

         return \Response::json([
//             'amount' => $transfer['withdrawal']->amount
         ]);
     }
}