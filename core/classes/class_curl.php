<?php

class Curl
{

    public static $url = 'https://yarbox.ru';
    public static $ch;

    public static function init ($url = '')
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) self::$url = $url;
        else if ($url != '') echo error_response(2001,'not valid url page',[],200)['error_msg'];

        self::$ch = curl_init();

        curl_setopt(self::$ch, CURLOPT_URL, self::$url);
        curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(self::$ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt(self::$ch, CURLOPT_HEADER, 0);
        curl_setopt(self::$ch, CURLOPT_SSL_VERIFYHOST, 0);

    }

    public static function get_html_from_url ($url = '') : string
    {
        self::init($url);
        return curl_exec(self::$ch);
    }

}