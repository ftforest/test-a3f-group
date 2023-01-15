<?php

function class_autoload($api = false) {
    if ($api) {
        spl_autoload_register(function($class_name) {
            require('./../core/classes/class_'.strtolower($class_name).'.php');
        });
    } else {
        spl_autoload_register(function($class_name) {
            require('./core/classes/class_'.strtolower($class_name).'.php');
        });
    }
}

function error_response($code, $msg, $data = [], $http_code = 0) {
    if (!$http_code) $http_code = in_array($code, [1001, 1005]) ? 401 : 400;
    header($_SERVER['SERVER_PROTOCOL'].' '.$http_code.' Error', true, $http_code);
    $result['error_code'] = $code;
    $result['error_msg'] = $msg;
    if ($data) $result['error_data'] = $data;
    return $result;
}

function response($response) {
    $response = !isset($response['error_code']) ? ['success'=>'true', 'response'=>$response] : ['success'=>'false', 'error'=>$response];
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}

function patterns_include($name) {
    echo "<hr>";
    echo $name."<br>";
    include "./patterns/".$name.".php";
    echo "<hr>";
}

function patterns_include_all($dir) {

    foreach (glob($dir."/*.php") as $filename)
    {
        echo "\n<hr>\n";
        echo $filename."<br>\n";
        require $filename;
        echo "\n<hr>\n";
    }
}
