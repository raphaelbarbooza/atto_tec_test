<?php

namespace App\Helpers;

class StringHelper
{

    public static function onlyNumbers(string $string) : string
    {
        return strval(preg_replace('/\D/', '', $string));
    }

    public static function removeChars(string $string, array $charList) : string
    {
        foreach($charList as $char){
            $string = str_replace($char,'',$string);
        }
        return $string;
    }

    public static function mask (string $placeholder, string $value, string $char = '#'): string
    {
        $template = strtr($placeholder, [$char => '%s']);

        return sprintf($template, ...str_split($value));
    }

}
