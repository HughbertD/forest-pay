<?php

class IntegrationTestCase extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->app['artisan']->call('migrate');
    }
}