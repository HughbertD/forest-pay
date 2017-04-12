<?php

namespace tests\Api\v1;

use ForestPay\Services\Creation\ForestPayUser;

class DepositsControllerTest extends \IntegrationTestCase
{
    /**
     * @var \User
     */
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
    }

    /**
     * @group DB
     */
    public function testStoreDeposit()
    {
        $response = $this->call('POST', 'api/v1/deposits', [
            'to_user' => 'hugh@example.com',
            'amount' => 100.00,
            'reference' => 'For the rent',
            'from_user' => 'tenant_hugh@example.com'
        ]);
        $jsonResponse = json_decode($response->getContent(), true);
        $deposit = \Deposit::orderBy('id', 'desc')->first();

        $this->assertResponseOk();
        $this->assertInternalType('array', $jsonResponse);
        $this->assertInstanceOf(\Transaction::class, $deposit);
        $this->assertEquals(\Deposit::$event, $deposit->event);
        $this->assertInternalType('array', $deposit->data);
        $this->assertFalse(empty($deposit->data));
    }

    /**
     * @group DB
     */
    public function testStoreDepositGivesValidationError()
    {
        $response = $this->call('POST', 'api/v1/deposits', [
            'to_user' => 'idontexist@example.com',
            'amount' => 100.00,
            'reference' => 'For the rent',
            'from_user' => 'tenant_hugh@example.com'
        ]);
        $jsonResponse = json_decode($response->getContent(), true);
        $this->assertResponseStatus(400);
        $this->assertInternalType('array', $jsonResponse);
        $this->assertArrayHasKey('wallet_id', $jsonResponse);
        $this->assertArrayHasKey('user_id', $jsonResponse);
    }
}