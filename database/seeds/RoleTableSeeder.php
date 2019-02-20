<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_visitor = new Role();
        $role_visitor->name = 'visitor';
        $role_visitor->description = 'Návštevník';
        $role_visitor->save();

        $role_admin = new Role();
        $role_admin->name = 'admin';
        $role_admin->description = 'Správca';
        $role_admin->save();

        $role_editor = new Role();
        $role_editor->name = 'editor';
        $role_editor->description = 'Redaktor';
        $role_editor->save();
    }
}
