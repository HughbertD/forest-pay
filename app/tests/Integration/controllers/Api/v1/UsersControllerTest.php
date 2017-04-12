<?php

namespace tests\Api\v1;

use ForestPay\Services\Creation\ForestPayDeposit;
use ForestPay\Services\Creation\ForestPayUser;
use ForestPay\Services\Creation\MoneyTransfer\ForestPayTransfer;
use ForestPay\Services\Creation\MoneyTransfer\InsufficientFundException;

class UsersControllerTest extends \IntegrationTestCase
{
    protected $user;

    protected $searchForUser;

    public function setUp()
    {
        parent::setUp();
        $userBuilder = new ForestPayUser([
            'username' => 'hugh@example.com',
            'password' => 'password',
            'profile' => ['first_name' => 'Hugh', 'last_name' => 'Downer']
        ]);
        $this->user = $userBuilder->build();
        (new ForestPayDeposit([
            'user_id' => $this->user->id,
            'amount' => 100,
        ]))->build();

        $userBuilder = new ForestPayUser([
            'username' => 'waldo@example.com',
            'password' => 'password',
            'profile' => ['first_name' => 'Waldo', 'last_name' => 'Where']
        ]);
        $this->searchForUser = $userBuilder->build();
        $this->be($this->user);
    }

    /**
     * @group DB
     * @group API
     */
    public function testFind()
    {
        $searchFor = urlencode('waldo@example.com');
        $response = $this->call('GET', "api/v1/users/find/{$searchFor}");
        $responseArray = json_decode($response->getContent(), true);
        $this->assertInternalType('array', $responseArray);
        $this->assertArrayHasKey('username', $responseArray);
        $this->assertEquals($responseArray['username'], 'waldo@example.com');
        $this->assertResponseOk();
    }

    /**
     * @group DB
     * @group API
     */
    public function testFindNotFound()
    {
        $searchFor = urlencode('notwaldo@example.com');
        $this->call('GET', "api/v1/users/find/{$searchFor}");
        $this->assertResponseStatus(404);
    }

    /**
     * @group DB
     * @group API
     */
    public function testPayUserNoFunds()
    {
        $response = $this->call('POST', "api/v1/users/pay", [
            'amount' => 200,
            'username' => 'waldo@example.com',
            'reference' => 'Cant afford this payment'
        ])->getContent();
        $this->assertResponseStatus(400);
        $responseArray = json_decode($response, true);
        $this->assertInternalType('array', $responseArray);
        $this->assertArrayHasKey('general', $responseArray);
        $this->assertContains(ForestPayTransfer::$errorMessages['too_low'], $responseArray['general'][0]);
    }

    /**
     * @group DB
     * @group API
     */
    public function testPayUserNotFound()
    {
        $response = $this->call('POST', "api/v1/users/pay", [
            'amount' => 100,
            'username' => 'not-here@example.com',
            'reference' => 'Rent Payment'
        ])->getContent();
        $this->assertResponseStatus(404);
        $responseArray = json_decode($response, true);
        $this->assertInternalType('array', $responseArray);
        $this->assertArrayHasKey('general', $responseArray);
        $this->assertContains(ForestPayTransfer::$errorMessages['cannot_find_user'], $responseArray['general'][0]);
    }

    /**
     * @group DB
     * @group API
     */
    public function testPayUserSuccess()
    {
        $payingUserBalanceStart = $this->user->transactions()->get()->balance();
        $receivingUserBalanceStart = $this->searchForUser->transactions()->get()->balance();

        $this->call('POST', "api/v1/users/pay", [
            'amount' => 100,
            'username' => 'waldo@example.com',
            'reference' => 'Rent Payment'
        ]);

        $payingUserBalance = $this->user->transactions()->get()->balance();
        $receivingUserBalance = $this->searchForUser->transactions()->get()->balance();

        $this->assertResponseOk();
        $this->assertEquals($payingUserBalanceStart - 100, $payingUserBalance);
        $this->assertEquals($receivingUserBalanceStart + 100, $receivingUserBalance);
    }

    /**
     * @group DB
     * @group API
     */
    public function testPayYourself()
    {
        $response = $this->call('POST', "api/v1/users/pay", [
            'amount' => 100,
            'username' => 'hugh@example.com',
            'reference' => 'Rent Payment'
        ])->getContent();
        $responseArray = json_decode($response, true);

        $this->assertResponseStatus(400);
        $this->assertInternalType('array', $responseArray);
        $this->assertArrayHasKey('general', $responseArray);
        $this->assertContains(ForestPayTransfer::$errorMessages['self_transfer'], $responseArray['general'][0]);
    }

    /**
     * @group DB
     * @group API
     */
    public function testPayNegativeSum()
    {
        $response = $this->call('POST', "api/v1/users/pay", [
            'amount' => -100,
            'username' => 'hugh@example.com',
            'reference' => 'Rent Payment'
        ])->getContent();

        $responseArray = json_decode($response, true);
        $this->assertResponseStatus(400);
        $this->assertInternalType('array', $responseArray);
        $this->assertArrayHasKey('general', $responseArray);
        $this->assertEquals(ForestPayTransfer::$errorMessages['negative_amount'], $responseArray['general'][0]);
    }
}
