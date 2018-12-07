<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Admin\User::class)->create([
            'name' => 'root',
            'email' => '1638824607@qq.com',
            'password' => bcrypt('root'),
        ]);
    }
}
