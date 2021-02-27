<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User([
            'name' => 'Almighty Admin',
            'email' => 'admin@almighty.com',
            'password' => app('hash')->make('test1234'),
            'api_token' => Str::random(60),
            'role' => User::ROLE_ADMIN,
            'api_token_expire_date' => (new Carbon())->addDays(1)
        ]);

        $admin->save();

        $client = new User([
            'name' => 'Almighty Client',
            'email' => 'client@almighty.com',
            'password' => app('hash')->make('test1234'),
            'api_token' => Str::random(60),
            'role' => User::ROLE_CLIENT,
            'api_token_expire_date' => (new Carbon())->addDays(1)
        ]);

        $client->save();
    }
}
