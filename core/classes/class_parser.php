<?php

abstract class Parser
{
    abstract function html_file();
    abstract function url_sity();

    abstract function parser();

    function __construct()
    {
    }
}