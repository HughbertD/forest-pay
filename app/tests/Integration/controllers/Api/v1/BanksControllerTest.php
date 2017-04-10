<?php

namespace tests\Api\v1;

use ForestPay\Services\Creation\ForestPayUser;

class BanksControllerTest extends \IntegrationTestCase
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
    }

    /**
     * @group DB
     */
    public function testStoreBank()
    {
        $this->be($this->user);
        $response = $this->call('POST', 'api/v1/banks', [
            'name' => 'Bank Name',
            'bank_name' => 'Barclays Bank',
            'iban' => 'GB04BARC20474473160944',
            'beneficiary_name' => 'Karl Francis'
        ]);

        $jsonResponse = json_decode($response->getContent(), true);
        $bankAccount = \BankAccount::orderBy('id', 'desc')->first();
        $transactions = $bankAccount->transactions()->get();

        $this->assertResponseOk();
        $this->assertInternalType('array', $jsonResponse);
        $this->assertArrayHasKey('id', $jsonResponse);
        $this->assertTrue(is_numeric($jsonResponse['id']));

        $this->assertInstanceOf(\BankAccount::class, $bankAccount);
        $this->assertCount(1, $transactions);
        $this->assertEquals('Bank Account Created', $transactions[0]->event);
    }

    /**
     * @group DB
     */
    public function testStoreBankGivesValidationError()
    {
        $this->be($this->user);
        $response = $this->call('POST', 'api/v1/banks', [
            'bank_name' => 'Barclays Bank',
            'beneficiary_name' => 'Karl Francis'
        ]);
        $jsonResponse = json_decode($response->getContent(), true);

        $this->assertResponseStatus(400);
        $this->assertInternalType('array', $jsonResponse);
        $this->assertArrayHasKey('name', $jsonResponse);
        $this->assertArrayHasKey('iban', $jsonResponse);
    }
}