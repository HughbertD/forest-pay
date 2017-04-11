<?php

class DepositTest extends IntegrationTestCase
{
    /**
     * @var \User
     */
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $userBuilder = new \ForestPay\Services\Creation\ForestPayUser([
            'username' => 'hugh@example.com',
            'password' => 'password',
            'profile' => ['first_name' => 'Hugh', 'last_name' => 'Downer']
        ]);
        $this->user = $userBuilder->build();
    }

    /**
     * @group DB
     */
    public function testDepositScope()
    {
        $data = [
            'user_id' => $this->user->id,
            'wallet_id' => $this->user->wallet()->first()->id,
            'amount' => 100,
            'to_user' => 'hugh@example.com',
            'from_user' => 'hugh@example.com',
            'event' => \Deposit::$event,
            'data' => ''
        ];
        $deposit = new \Deposit($data);
        $this->user->deposits()->save($deposit);
        $this->assertInstanceOf(\Deposit::class, $deposit);

        $data['event'] = 'Transaction';
        $transaction = new \Transaction($data);
        $this->user->transactions()->save($transaction);
        $this->assertInstanceOf(\Transaction::class, $transaction);

        $data['event'] = 'Withdrawal';
        $transaction = new \Transaction($data);
        $this->user->transactions()->save($transaction);
        $this->assertInstanceOf(\Transaction::class, $transaction);

        $deposits = $this->user->deposits()->get();
        $this->assertCount(1, $deposits);

        $transactions = $this->user->transactions()->get();
        $this->assertCount(3, $transactions);
    }
}