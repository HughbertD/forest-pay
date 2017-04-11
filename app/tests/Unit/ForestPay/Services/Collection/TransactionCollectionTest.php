<?php

class TransactionCollectionTest extends TestCase
{

    public function testBalance()
    {
        $deposit = new \Transaction(['amount' => 100]);
        $withdrawal = new \Transaction(['amount' => -100]);
        $collection = new \ForestPay\Services\Collection\TransactionCollection([$deposit, $withdrawal]);
        $this->assertEquals(0, $collection->balance());
    }
}