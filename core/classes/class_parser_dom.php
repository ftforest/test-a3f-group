<?php

class Parser_Dom
{
    // var
    private $tags; // all tags: dirty
    private $tags_count = []; // summ unicu tags
    private $tags_clear = []; // all tags: clear
    private $tree = [];
    public $tags_one = ['link','meta','img','input','br','hr','frame'];
    public $tags_exclude_main = ['script','style','noscript'];
    public $tags_exclude_svg = ['rect','g','path','xml','defs'];
    private $space = '&nbsp;';
    // settings
    private $prev_tags_displey = false; // add or not closes tags
    private $parents_id_create = true; // add or not closes tags

    public function __construct($html_page = '')
    {
        if (preg_match_all('/<[^!]*?([\w\/]*?)[\s>]/i',$html_page,$tags)) {
            $this->tags = $tags[1];
        }
    }

    public function data_processing()
    {
        $tags_exclude_all = array_merge($this->tags_exclude_main,$this->tags_exclude_svg);

        $miss = false;
        $level = 0;
        $prev_tags = [];
        $item_id = 0;
        $parent_id = 0;
        foreach ($this->tags as $item) {

            if ($miss) { continue; }
            if (empty(trim($item))) continue;

            $this->tags_clear[] = $item;

            if (in_array(ltrim($item,'/'),$tags_exclude_all)) continue;

            if (in_array($item,$this->tags_one)) {
                $level++;
                $item_id++;
                $this->tree[] = [$item,$level,$item_id,$parent_id];
                $level--;
                if (empty($this->tags_count[$item])) $this->tags_count[$item] = 1;
                else $this->tags_count[$item]++;
                continue;
            }
            if (strpos($item, '/') !== false) {
                $parent_node = array_pop($prev_tags);
                if ($this->prev_tags_displey) $this->tree[] = $parent_node;
                $level--;
                $parent_id = $parent_node[3];
            }
            else {
                $level++;
                $item_id++;
                $this->tree[] = [$item,$level,$item_id,$parent_id];
                if (empty($this->tags_count[$item])) $this->tags_count[$item] = 1;
                else $this->tags_count[$item]++;
                array_push($prev_tags,[$item,$level,$item_id,$parent_id]);
                $parent_id = $item_id;
            }
        }
        return true;
    }

    public function build_tree()
    {
        echo "<hr>";
        echo "Tree build:";
        echo "<br>";
        foreach ($this->tree as $item) {
            echo str_repeat('-',$item[1]);
            echo $item[0].str_repeat($this->space,5)."level:".$item[1]."-id:".$item[2]."-parent_id:".$item[3]."<br>";
        }
        echo "<br>";
        echo "End Tree build.";
        echo "<hr>";
    }

    public function print_tags_statistic()
    {
        asort($this->tags_count);
        echo "<hr>";
        echo "Count Tags:";
        echo "<br>";
        echo "<pre>";
        print_r($this->tags_count);
        echo "</pre>";
        echo "<hr>";
    }

    public function summ_tags()
    {
        echo "Summ All Tags:";
        echo "<br>";
        echo "tags:".array_sum($this->tags_count);
        echo "<hr>";
    }

    public function summ_unic_tags()
    {
        echo "Summ All Unic Tags:";
        echo "<br>";
        echo "tags:".count($this->tags_count);
        echo "<hr>";
    }
}