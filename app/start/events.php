<?php
Event::subscribe(new \ForestPay\Events\BankAccount\BankAccountSubscriber);
Event::subscribe(new \ForestPay\Events\User\UserSubscriber);
Event::subscribe(new \ForestPay\Events\Wallet\WalletSubscriber);