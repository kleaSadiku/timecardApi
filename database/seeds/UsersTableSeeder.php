<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::where('name', 'admin')->first();
        $user = Role::where('name', 'user')->first();
        $pm = Role::where('name', 'pm')->first();
        User::class->create()->each(function ($user) use ($admin) {
            /** @var User $user */
            $user->assignRole($admin);
        });

    }
}
