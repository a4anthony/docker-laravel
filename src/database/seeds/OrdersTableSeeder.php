<?php

use App\MelaMart\Entities\Order;
use App\User;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $users->each(
            function ($user) {
                factory(Order::class, 8)->create(
                    [
                        'user_id' => $user->id,
                        'reference' => $user->id . 'rejnasbvewuew98w8'
                    ]
                );
            }
        );
    }
}
