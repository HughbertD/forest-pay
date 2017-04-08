<?php

use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    private $range = [
        'low' => 1,
        'high' => 10
    ];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
        $faker = Faker::create();
        foreach (range($this->range['low'], $this->range['high']) as $i) {

            // new user
            $user = User::create([
                'username' => $faker->email,
                'password' => Hash::make($faker->password()),
            ]);

            // attach profile
            $user->profile()->save(new Profile([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
            ]));

            // attach wallet
            $user->wallet()->save(new Wallet([
                'name' => $faker->domainWord
            ]));

            // Create between 1 and 2 bank accounts for user
            $bankAccounts = [$this->getBankAccount($faker)];
            if ($i >= $this->range['high'] / 2) {
                $bankAccounts[] = $this->getBankAccount($faker);
            }
            $user->bankAccounts()->saveMany($bankAccounts);
        }
	}

    /**
     * Get a bank account
     * @param \Faker\Generator $faker
     * @return BankAccount
     */
	private function getBankAccount(\Faker\Generator $faker)
    {
        return new BankAccount([
            'name' => ucwords($faker->domainWord),
            'bank_name' => $faker->randomElement(['Lloyds TSB', 'Co-operate Bank', 'HSBC']),
            'iban' => $faker->iban($faker->countryCode),
            'beneficiary_name' => $faker->firstName . ' ' . $faker->lastName
        ]);
    }

}
