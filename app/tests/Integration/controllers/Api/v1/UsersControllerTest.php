<?php

namespace tests\Api\v1;

use ForestPay\Services\Creation\ForestPayUser;

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
     */
    public function testFindNotFound()
    {
        $searchFor = urlencode('notwaldo@example.com');
        $this->call('GET', "api/v1/users/find/{$searchFor}");
        $this->assertResponseStatus(404);
    }
}
