<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;
class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::create([
            'full_name' => 'KhariDz',
            'avatar' => '',
            'story' => '',
            'email' => 'admin@fptcodedao.com',
            'username' => 'admin',
            'password' => bcrypt('admin123'),
            'token_hash' => bcrypt(time()),
            'token_expired' => now(),
        ]);

        $role = \App\Models\Role::where('slug', 'full_admin')->first();

        $admin->roles()->attach($role);
    }
}
