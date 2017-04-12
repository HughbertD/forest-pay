<?php

namespace tests\Api\v1;

use ForestPay\Services\Creation\ForestPayUser;

class WithdrawalsControllerTest extends \IntegrationTestCase
{
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $userBuilder = new ForestPayUser([
            'username' => 'hugh@example.com',
            'password' => 'password',
            'profile' => ['first_name' => 'Hugh', 'last_name' => 'Downer']
        ]);
        $this->user = $userBuilder->build();
        $this->be($this->user);
    }

    /**
     * @group DB
     */
    public function testWithdrawToNotYourBank()
    {
        \Route::enableFilters();
        (new \BankAccount([
            'name' => 'Bank Name',
            'bank_name' => 'Barclays Bank',
            'iban' => 'GB04BARC20474473160944',
            'beneficiary_name' => 'Karl Francis',
            'user_id' => $this->user->id
        ]))->save();
        $this->call('POST', 'api/v1/withdrawals/to_bank', [
            'bank_id' => 100,
            'amount' => 100
        ])->getContent();
        $this->assertResponseStatus(401);
    }

    /**
     * @group DB
     */
    public function testWithdrawToBank()
    {
        (new \BankAccount([
            'name' => 'Bank Name',
            'bank_name' => 'Barclays Bank',
            'iban' => 'GB04BARC20474473160944',
            'beneficiary_name' => 'Karl Francis',
            'user_id' => $this->user->id
        ]))->save();
        (new \Deposit([
            'amount' => 100,
            'wallet_id' => $this->user->wallet()->first()->id,
            'user_id' => $this->user->id,
            'event' => \Deposit::$event,
            'data' => ''
        ]))->save();

        $response = $this->call('POST', 'api/v1/withdrawals/to_bank', [
            'bank_id' => 1,
            'amount' => 100
        ])->getContent();
        $response = json_decode($response, true);
        $this->assertResponseOk();
        $this->assertInternalType('array', $response);
    }
}