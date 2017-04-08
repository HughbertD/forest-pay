<?php

class ValidationOfficerTest extends IntegrationTestCase
{
    /**
     * @group DB
     * @return void
     */
    public function testValidationOfficerReturnsErrors()
    {
        $validationOfficer = new \ForestPay\Services\Validation\ValidationOfficer(
            new \ForestPay\Services\Validation\User(['username' => 'hugh@example.com', 'password' => '']),
            new \ForestPay\Services\Validation\Profile(['first_name' => 'Hugh', 'last_name' => ''])
        );

        $messageBags = $validationOfficer->messages();
        $this->assertInstanceOf(\Illuminate\Support\MessageBag::class, $messageBags);
        $messages = $messageBags->getMessages();

        $this->assertArrayHasKey('password', $messages);
        $this->assertArrayHasKey('last_name', $messages);
        $this->assertArrayNotHasKey('username', $messages);
        $this->assertArrayNotHasKey('first_name', $messages);
    }
}