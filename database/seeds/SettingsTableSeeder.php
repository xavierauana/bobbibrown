<?php

use App\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $settings = [
            [
                'label' => "Test Passing Rate",
                'code'  => 'test_passing_rate',
                'value' => "80",
            ]
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
