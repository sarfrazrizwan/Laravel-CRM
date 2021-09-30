<?php

use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Illuminate\Support\Facades\Artisan::call("roles-and-permissions:update",
            ['csvFilePath' => resource_path('config/roles_and_permissions.csv')]);

    }
}
