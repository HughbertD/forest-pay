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

        $this->assertResponseOk();
        $this->assertInternalType('array', $jsonResponse);
        $this->assertArrayHasKey('id', $jsonResponse);
        $this->assertTrue(is_numeric($jsonResponse['id']));
    }
}