<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        Setting::create([
            'email' => 'official@gmail.com',
            'phone' => '+1 234 4567 8910',
        ]);
    }
}
