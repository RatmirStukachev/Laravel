<?php

namespace App\Services\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

final class TextService
{
    public static function clearPhone($value)
    {
        $phone = preg_replace("/\D/", "", $value);
        return '+' . $phone;
    }

    public static function pregPhone($value)
    {
        if (preg_match("/^\+(\d{3})(\d{2})(\d{3})(\d{2})(\d{2})$/", $value, $matches)) {
            $phone = "+{$matches[1]} ({$matches[2]}) {$matches[3]}-{$matches[4]}-{$matches[5]}";
        } else {
            $phone = $value;
        }

        return $phone;
    }


    public static function viber($value)
    {
        return 'viber:' . self::clearPhone($value);
    }

    public static function telegram($value)
    {
        return 'tg://resolve?domain=' . $value;
    }

    public static function whatsapp($value)
    {
        return 'https://wa.me/' . self::clearPhone($value);
    }

    public static function getSettingValue($dataKey, $dataValue)
    {
        $settings = self::getSettings();
        $settingDataValues = $settings->where('data_key', $dataKey)->first()->data_val;

        return $settingDataValues[$dataValue] ?? null;
    }

    public static function getSettings()
    {
        Cache::forget('settings');
        return Cache::flexible(
            key: 'settings',
            ttl: [
                60,
                config('cache.stores.settings'),
            ],
            callback: function () {
                return Setting::all();
            });
    }
}
