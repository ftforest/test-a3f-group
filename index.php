<?php

// INIT

require('./core/functions.php');

class_autoload();

$path_or_url = 'https://github.com';
$path_or_url = './page_test_html/index_001_html_5_simple.html';

$pp = new Parsing_Page($path_or_url);
$html_page = $pp->get_content();

$pdom = new Parser_Dom($html_page);
$pdom->data_processing();
$pdom->print_tags_statistic();
$pdom->summ_tags();
$pdom->summ_unic_tags();
$pdom->build_tree();

echo 'zzzzzzzzzzzzz';