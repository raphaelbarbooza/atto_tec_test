<?php

namespace App\Services;


class LocalizationServices
{

    public static function getLocale(){
        $currentLocale = config('app.locale');
        // Try to check if we have some session with locale
        if(session()->has('selected_locale')){
            $locale = session()->get('selected_locale');
            if(in_array($locale,['en','pt-BR','es']))
                $currentLocale = session()->get('selected_locale');
        }
        // Return locale
        return $currentLocale;
    }

    public static function setLocale($locale){
        // Get current route name
        \session()->put('selected_locale', $locale);
        return \session()->get('selected_locale') == $locale;
    }

}
