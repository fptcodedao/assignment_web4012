<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::create([
            'name' => 'Full Admin',
            'slug' => 'full_admin',
            'permissions' => ['isAdmin']
        ]);

        \App\Models\Role::create([
           'name' => 'Editor',
            'slug' => 'editor',
            'permissions' => ['posts.*']
        ]);
    }
}
