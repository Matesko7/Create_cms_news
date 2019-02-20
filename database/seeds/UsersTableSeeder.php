<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_visitor = Role::where('name', 'visitor')->first();
        $role_editor  = Role::where('name', 'editor')->first();
        $role_admin  = Role::where('name', 'admin')->first();

        $admin = new User();
        $admin->name = 'Matej';
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('*admin*');
        $admin->save();
        $admin->roles()->attach($role_admin);

        $editor = new User();
        $editor->name = 'Lukáš';
        $editor->email = 'editor@example.com';
        $editor->password = Hash::make('*editor*');
        $editor->save();
        $editor->roles()->attach($role_editor);

        $visitor = new User();
        $visitor->name = 'Lukáš';
        $visitor->email = 'visitor@example.com';
        $visitor->password = Hash::make('*visitor*');
        $visitor->save();
        $visitor->roles()->attach($role_visitor);
    }
}
