<?php

$htmlPage = file_get_contents('./page_test_html/index_001_html_5_simple.html');

if (true) {

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://yarbox.ru');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    $htmlPage = curl_exec($ch);

}


preg_match_all('/<[^!]*?([\w\/]*?)[\s>]/i',$htmlPage,$tags);

echo "<pre>";
//print_r($tags);
echo "</pre>";

$tags_one = ['link','meta','img','input','br','hr','frame'];
$tags_exclude = ['script','style','noscript'];
$tags_exclude_svg = ['rect','g','path','xml','defs'];
$tags_exclude_all = array_merge($tags_exclude,$tags_exclude_svg);

$tags_count = [];
$tags_clear = [];
$tree = [];
$miss = false;
$level = 0;
$prev_tags = [];
$prev_tags_displey = true;
foreach ($tags[1] as $item) {

    if ($miss) { continue; }
    if (empty(trim($item))) continue;

    $tags_clear[] = $item;

    if (in_array(ltrim($item,'/'),$tags_exclude_all)) continue;

    if (in_array($item,$tags_one)) {
        $level++;
        $tree[] = [$item,$level];
        $level--;
        if (empty($tags_count[$item])) $tags_count[$item] = 1;
        else $tags_count[$item]++;
        continue;
    }
    if (strpos($item, '/') !== false) {
        if ($prev_tags_displey) $tree[] = [array_pop($prev_tags),$level];
        $level--;
    }
    else {
        $level++;
        $tree[] = [$item,$level];
        if (empty($tags_count[$item])) $tags_count[$item] = 1;
        else $tags_count[$item]++;
        if ($prev_tags_displey) array_push($prev_tags,$item);
    }
}

echo "<pre>";
//print_r($tree);
echo "</pre>\n";

foreach ($tree as $item) {
    echo str_repeat('-',$item[1]);
    echo $item[0]."\n";
}
echo "\n<pre>";
print_r($tags_count);
echo "</pre>\n";
print_r(array_sum($tags_count));