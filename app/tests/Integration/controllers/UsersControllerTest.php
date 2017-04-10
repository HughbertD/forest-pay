<?php

class UsersControllerTest extends IntegrationTestCase
{
    /**
     * Test storing a new user via Registration
     * @group DB
     * @return void
     */
    public function testStore()
    {
        $this->call('POST', 'users/store', [
            'username' => 'hugh@example.com',
            'password' => 'change_me',
            'profile' => [
                'first_name' => 'hugh',
                'last_name' => 'downer'
            ]
        ]);

        $user = \User::orderBy('id', 'desc')->first();
        $profile = $user->profile()->first();
        $wallet = $user->wallet()->first();
        $notes = $user->notes()->get();

        $this->assertRedirectedTo('/me');
        $this->assertEquals('hugh@example.com', $user->username);
        $this->assertEquals('hugh', $profile->first_name);
        $this->assertEquals('downer', $profile->last_name);
        $this->assertEquals('My Wallet', $wallet->name);

        $this->assertCount(3, $notes);
        $this->assertEquals('User Created', $notes[0]->event);
        $this->assertEquals('Wallet Created', $notes[1]->event);
        $this->assertEquals('User Registered', $notes[2]->event);
    }
}