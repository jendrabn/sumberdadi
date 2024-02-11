<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'manage all users']);
        Permission::create(['name' => 'manage all communities']);
        Permission::create(['name' => 'manage all stores']);

        Permission::create(['name' => 'manage community']);
        Permission::create(['name' => 'manage community event']);
        Permission::create(['name' => 'views community event participants']);

        Permission::create(['name' => 'manage store']);
        Permission::create(['name' => 'manage store products']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo('manage all users');
        $admin->givePermissionTo('manage all communities');
        $admin->givePermissionTo('manage all stores');

        Role::create(['name' => 'user']);
        Role::create(['name' => 'seller']);
    }
}
