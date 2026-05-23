<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;

class SettingsHelper
{
    public static function getPhone()
    {
        if (File::exists(storage_path('app/settings.json'))) {
            $settings = json_decode(File::get(storage_path('app/settings.json')), true);
            return $settings['phone'] ?? '+79991234567';
        }
        return '+79991234567';
    }
}