<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = [
            'user_id' => '1',
            'role_id' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        DB::table('user_roles')->insert($table);
    }
}
