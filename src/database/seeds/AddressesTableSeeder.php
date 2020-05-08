<?php

use App\User;
use App\MelaMart\Entities\Address;
use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users =  User::all();
        $users->each(
            function ($user) {
                factory(Address::class, 4)->create(['user_id' => $user->id]);
            }
        );
    }
}
