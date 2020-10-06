<?php


namespace App\Helpers;


use App\User;

class PhoneHelper
{
    const REGEX_MASK = '^\+?7\(7([0124567][0-8]\)\d{3}\-\d{2}\-\d{2})$^';

    public static function isCorrectFormat($phone)
    {
        return (bool) preg_match(self::REGEX_MASK, $phone);
    }

    public static function format($phone)
    {
        $phone = self::toNumeric($phone);
        return self::formatFromNumeric($phone);
    }

    public static function toNumeric($phone, $withoutFirstNum = false)
    {
        $phone = preg_replace("/[^0-9]/", "", $phone);
        if (strlen($phone) == 11 || ($withoutFirstNum && strlen($phone) == 10)) {
            $phone = '7'.substr($phone, -10, 10);
            return $phone;
        }
        return null;
    }

    public static function formatFromNumeric($phone)
    {
        if (strlen($phone) != 11) {
            return null;
        }

        $phone = '+7('.substr($phone, 1, 3).')'.substr($phone, 4, 3)
            .'-'.substr($phone, 7, 2).'-'.substr($phone, 9, 2);

        if (!self::isCorrectFormat($phone)) {
            return null;
        }

        return $phone;
    }

    public static function isBusy($phone)
    {
        $phone = self::toNumeric($phone);
        $match = implode('%', (array) $phone);
        $result = User::query()->where('phone', 'like', $match)->exists();
        return $result ? true : false;
    }
}