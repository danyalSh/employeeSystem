<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CreateAdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = [
            [
                'first_name' => 'admin',
                'last_name' => 'admin',
                'username' => env('DEFAULT_ADMIN_USERNAME'),
                'email' => env('DEFAULT_ADMIN_EMAIL'),
                'password' => bcrypt(env('DEFAULT_ADMIN_PASSWORD')),
                'remember_token' => bcrypt('admin'),
                'is_admin' => true,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        DB::table('users')->insert($table);
    }
}
