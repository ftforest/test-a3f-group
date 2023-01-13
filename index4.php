<?php

class BinaryNode
{
    public $level;    // значение узла
    public $id;
    public $tag;    // значение узла
    public $right;     // правый потомок типа BinaryNode
    public static $count_tags = 0;

    public function __construct($tag) {
        $this->tag = $tag;
        $this->id = self::$count_tags++;
        //$this->code = $code;
        // новые потомки
        $this->right = [];
    }

    // сделаем симметричный проход текущего узла
    public function dump($level) {
        foreach ($this->right as $item) {
            echo "\n";
            echo str_repeat('-',$level);
            echo($this->tag);
            print_r($this->id);
            if (count($item->right) > 0) {
                $level++;
                $item->dump($level);
            } else {
                return;
            }
        }
    }
}

class BinaryTree
{
    protected $root; // корень дерева
    public static $tags = ['div' => 0];

    public function __construct()
    {
        $this->root = new BinaryNode('root');
    }

    public function create($code) {
        $code = preg_replace('/<!DOCTYPE.*?>/i','',$code);
        $code = preg_replace('/[>]\s*?[<]/i','><',$code);
        //print_r($code);

            if ($code != '') {
                $this->insertNode($this->root, $code);
            }

    }

    public function insertNode(&$subtree, $code = '')
    {
        //if ($code == '') return;
        $tags = [];
        if (preg_match_all('/<([-\w]+?)[\s>].*?<(.*?)>/i',$code,$tags)) {
            print_r($tags);
            for ($i = 0; $i < count($tags[0]); $i++) {
                if ('/'.$tags[1][$i] == $tags[2][$i]) {
                    //print_r("\n".$tags[1][$i]."");
                    self::$tags[$tags[1][$i]]++;

                    $code = mb_substr( $code, strlen($tags[0][$i]));
                    $node = new BinaryNode($tags[1][$i]);
                    $subtree->right[] = $node;

                    //$this->insertNode( $node, $code);

                }
            }
            /*if ('/'.$tags[1] == $tags[2]) {
                print_r("\n".$tags[1]."");
                self::$tags[$tags[1]]++;

                $code = mb_substr( $code, strlen($tags[0]));
                $node = new BinaryNode($tags[1]);
                $subtree->right[] = $node;

                $this->insertNode( $node, $code);

            } else if (strpos($tags[2], '/') === false){

                self::$tags[$tags[1]]++;
                preg_match('/(<.+?>.*?)<[^\/]/i',$code,$tag_delet);
                //print_r($tag_delet);
                $code = mb_substr( $code, strlen($tag_delet[1]));
                $node = new BinaryNode($tags[1]);
                $subtree->right[] = $node;

                $this->insertNode($node, $code);

            }*/
        } else if (preg_match('/<(.*?)>/i',$code,$tags)) {
            if (strpos($tags[1], '/') !== false){
                return;
            }
        }
        return;
        //print_r($code);echo "==";
    }

    public function traverse() {
        // отображение дерева в возрастающем порядке от корня
        $this->root->dump(0);
    }
}

$tree = new BinaryTree();
$tree->create('<div></div><div></div>');
$tree->traverse(0);
echo "\n\n";
print_r(BinaryTree::$tags);
//$tree->create('<body><div></div><div></div></body>');
//$tree->create(file_get_contents('./page_test_html/index_001_html_5_simple.html'));
//$tree->create(file_get_contents('./page_test_html/index_001_html_5_simple.html'));