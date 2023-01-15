<?php


class Form
{
    public static function getForm()
    {
        echo "<form action='/' method='get'>";
        echo "<input type='text' name='url' placeholder='введите адрес сайта'>";
        echo "</form>";
        if (empty($_GET['url'])) {
            $url = '';
        }else {
            $url = $_GET['url'];
        }
        if (!preg_match('/http[s]*?:\/\//i',$url,$out)) {
            $url = 'https://'.$url;
        }
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return $url;
        }else {
            return '';
        }
    }
}
?>
