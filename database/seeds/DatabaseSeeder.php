<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(\CreateAdminUser::class);
        $this->call(\PermissionsTableSeeder::class);
        $this->call(\OrganizationsTableSeeder::class);
        $this->call(\StatusTableSeeder::class);
        $this->call(\UserOrganizationsTableSeeder::class);
        $this->call(\RolesTableSeeder::class);
        $this->call(\RolesAndPermissionsTableSeeder::class);
        $this->call(\UserRolesTableSeeder::class);

        Model::reguard();
    }
}
