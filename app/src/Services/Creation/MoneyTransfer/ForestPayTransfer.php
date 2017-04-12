<?php

namespace ForestPay\Services\Creation\MoneyTransfer;

use ForestPay\Services\Creation\ForestPayDeposit;
use ForestPay\Services\Creation\ForestPayWithdrawal;

class ForestPayTransfer
{
    /**
     * @var \User - user who will receive a withdrawal
     */
    protected $payingUser;

    /**
     * @var \User - user who will receive a deposit
     */
    protected $receivingUser;

    /**
     * @var int - Amount the user wants to transfer
     */
    protected $amount;

    /**
     * @var string - Reference to attach to the payment
     */
    protected $reference;

    /**
     * @var array - possible error messages
     */
    public static $errorMessages = [
        'negative_amount' => 'Please enter an amount above zero',
        'too_low' => 'You do not have enough funds in your account',
        'self_transfer' => 'Sorry, you cannot transfer money to yourself',
        'failure' => 'Failed to make payment, please contact support',
        'cannot_find_user' => 'Sorry, we cannot find a user matching those details'
    ];

    public function __construct($payingUserId, $receivingUserName, $amount, $reference = '')
    {
        if ($amount <= 0) {
            throw new TransferValidationException(self::$errorMessages['negative_amount']);
        }
        $this->payingUser = \User::findOrFail($payingUserId)->first();
        $this->payingUser->balance = \Transaction::where('user_id', $payingUserId)->get()->balance();
        if ($this->payingUser->balance < $amount) {
            throw new InsufficientFundException(self::$errorMessages['too_low']);
        }

        $this->receivingUser = \User::where('username', $receivingUserName)->firstOrFail();

        if ($this->receivingUser->id === $this->payingUser->id) {
            throw new TransferValidationException(self::$errorMessages['self_transfer']);
        }
        $this->amount = $amount;
        $this->reference = $reference;
    }

    /**
     * Create the payment between users
     * @return array - containing deposit and withdrawal entities
     * @throws PaymentFailureException
     */
    public function pay()
    {
        try {
            return \DB::transaction(function () {
                $withdrawal = new ForestPayWithdrawal([
                    'user_id' => $this->payingUser->id,
                    'amount' => $this->amount,
                    'wallet_id' => $this->payingUser->wallet()->first()->id
                ]);
                $transfer['withdrawal'] = $withdrawal->build();

                $deposit = new ForestPayDeposit([
                    'user_id' => $this->receivingUser->id,
                    'amount' => $this->amount,
                    'wallet_id' => $this->receivingUser->wallet()->first()->id,
                    'reference' => $this->reference
                ]);
                $transfer['deposit'] = $deposit->build();
                return $transfer;
            });
        } catch (\Exception $e) {
            throw new PaymentFailureException(self::$errorMessages['failure']);
        }
    }
}