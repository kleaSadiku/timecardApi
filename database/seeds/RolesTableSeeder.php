<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::query()->updateOrCreate([
            'name' => 'admin',
        ], [
            'name' => 'admin',
            'guard_name' => 'api'
        ]);
        Role::query()->updateOrCreate([
            'name' => 'user',
        ],[
            'name' => 'user',
            'guard_name' => 'api'
        ]);
        Role::query()->updateOrCreate([
            'name' => 'pm',
        ],[
            'name' => 'pm',
            'guard_name' => 'api'
        ]);
    }
}
