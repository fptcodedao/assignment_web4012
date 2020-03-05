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
            'story' => 'Xin Chào, tôi là Khải là 1 website developer tương lai. Ước mơ trở thành full stack developer giỏi. Tận dụng các kỹ năng và kinh nghiệm cntt để giúp ích cho tương lai.',
            'email' => 'admin@fptcodedao.com',
            'username' => 'admin',
            'password' => bcrypt('admin123'),
            'token_hash' => bcrypt(time()),
            'token_expired' => now(),
        ]);

        $editor = Admin::create([
            'full_name' => 'Editor',
            'avatar' => '',
            'story' => '',
            'email' => 'editor@fptcodedao.com',
            'username' => 'editor',
            'password' => bcrypt('admin123'),
            'token_hash' => bcrypt(time()),
            'token_expired' => now(),
        ]);

        $role_admin = \App\Models\Role::where('slug', 'full_admin')->first();
        $role_editor = \App\Models\Role::where('slug', 'editor')->first();

        $admin->roles()->attach($role_admin);
        $editor->roles()->attach($role_editor);
    }
}
