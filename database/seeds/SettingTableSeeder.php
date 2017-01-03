<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create(['key' => 'title', 'value' => 'Materialize Blog']);
        Setting::create(['key' => 'desc', 'value' => 'The description of your website']);
        Setting::create(['key' => 'keywords', 'value' => 'Material,PHP']);
        Setting::create(['key' => 'author', 'value' => 'Forehalo']);
        Setting::create(['key' => 'logo', 'value' => '// Forehalo']);
        Setting::create(['key' => 'mail', 'value' => '']);
        Setting::create(['key' => 'post_per_page', 'value' => '8']);
        Setting::create(['key' => 'dashboard_post_per_page', 'value' => '8']);
        Setting::create(['key' => 'dashboard_comment_per_page', 'value' => '10']);
    }
}
