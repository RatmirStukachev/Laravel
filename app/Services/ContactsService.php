<?php

namespace App\Services;

class ContactsService
{
    public static function getPhoneLink($phone): string
    {
        return 'tel:+'. preg_replace('/\D/', '', $phone);
    }

    public static function getPhoneViberLink($phone): string
    {
        return 'viber://chat?number=+'. preg_replace('/\D/', '', $phone);
    }

    public static function prepareForLink($phone): string
    {
        return preg_replace('/\D/', '', $phone);
    }

    public static function getPhoneWhatsappLink($phone): string
    {
        return 'whatsapp://send?phone=+' . preg_replace('/\D/', '', $phone);
    }

    public static function getPhoneTelegramLink($nicName): string
    {
        return 'tg://resolve?domain=' . $nicName;
    }

    public static function getTelegramLinkViaPhone($phone): string
    {
        return 'tg://resolve?phone=' . preg_replace('/\D/', '', $phone);
    }

    public static function getInstagramLink($username): string
    {
        return 'https://www.instagram.com/' . ltrim($username, '@');
    }

    public static function getTikTokLink($username): string
    {
        return 'https://www.tiktok.com/@' . ltrim($username, '@');
    }

    public static function getEmailLink($email): string
    {
        return 'mailto:' . $email;
    }
}
