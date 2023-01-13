<?php

class Parsing_Page
{
    private $html_page = '';

    public function __construct(string $path_or_url = '')
    {
        if (filter_var($path_or_url, FILTER_VALIDATE_URL)) $this->html_page = $this->get_url($path_or_url);
        if (file_exists($path_or_url)) $this->html_page = $this->get_file($path_or_url);
    }

    public function get_file($path = '') : string
    {
        if(file_exists($path)) return file_get_contents($path);
        else return '';
    }

    public function get_url($url = '') : string
    {
        return Curl::get_html_from_url($url);
    }

    public function get_content() : string
    {
        return $this->html_page;
    }
}