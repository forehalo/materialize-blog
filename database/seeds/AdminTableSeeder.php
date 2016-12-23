<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\Admin::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'admin',
        ]);
    }
}
