<?php

// INIT

require('./core/functions.php');

class_autoload();

$path_or_url = 'https://github.com';
$path_or_url = './page_test_html/index_001_html_5_simple.html';
$url = Form::getForm();
if ($url != '') $path_or_url = $url;

$pp = new Parsing_Page($path_or_url);
$html_page = $pp->get_content();
echo $path_or_url."<br>";

$pdom = new Parser_Dom($html_page);
$pdom->data_processing();
$pdom->print_tags_statistic();
$pdom->summ_tags();
$pdom->summ_unic_tags();
$pdom->build_tree();

echo 'zzzzzzzzzzzzz';

//patterns_include('Registry');
//patterns_include('Object_Pool');
//patterns_include('Singleton');
//patterns_include('Multiton');
//patterns_include('MultitonDifferent');
//patterns_include('FactoryMethod');
//patterns_include('AbstractFactory');
//patterns_include('LazyInitialization');
//patterns_include('Prototype');
//patterns_include('Builder');
patterns_include_all('./patterns');