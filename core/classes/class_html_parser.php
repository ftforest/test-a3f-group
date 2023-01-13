<?php

class Html_Parser extends Parser
{
    public $html_code;
    public $html_tags_unic;

    public function html_file()
    {

    }
    public function url_sity()
    {

    }
    public function parser()
    {

        preg_match_all('/<([-\w]+?)[\s>]/i',$this->html_code,$html_tags);
        $this->dump_var($html_tags[1]);

        $this->html_tags_unic = $this->unic_array($html_tags[1]);
        $this->dump_var($this->html_tags_unic);

    }
    public function unic_array($arr)
    {
        return  array_unique($arr);
    }
    public function dump_var($var)
    {
        echo "<pre>";
        print_r($var);
        echo "</pre>";
    }

    public function get_html_page($path)
    {
        $this->html_code = file_get_contents($path);
    }
    public function display_html()
    {
        $this->html_code = preg_replace('/</i','&lang;',$this->html_code);
        $this->html_code = preg_replace('/>/i','&rang;',$this->html_code);

        echo $this->html_code;

        preg_match_all('/&lang;([-\w]+?)(\s|&rang;)/i',$this->html_code,$html_tags);
        $this->dump_var($this->unic_array($html_tags[1]));

    }

}