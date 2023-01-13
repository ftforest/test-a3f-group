<?php

class BinaryNode
{
    public $tag;    // значение узла
    public $code;    // значение узла
    public $right;     // правый потомок типа BinaryNode

    public function __construct($tag,$code) {
        $this->tag = $tag;
        $this->code = $code;
        // новые потомки
        $this->right = [];
    }

    // сделаем симметричный проход текущего узла
    public function dump() {
        foreach ($this->right as $item) {
            var_dump($this->tag);
            if (count($item->right) > 0) {
                $item->right->dump();
            }
        }
    }
}

class BinaryTree
{
    protected $root; // корень дерева

    public function __construct() {
        $this->root = [];
    }

    public function isEmpty() {
        return $this->root == [];
    }

    public function insert($tag,$code,$node_prev = null) {
        $code = preg_replace('/<!DOCTYPE.*?>/i','',$code);
        $code = preg_replace('/[>]\s*?[<]/i','><',$code);
        print_r($tag,$code);
        $node = new BinaryNode($tag,$code);
        if ($this->isEmpty()) {
            // правило 1
            $this->root = $node;
            var_dump($node);
            if ($code != '') {
                $this->insertNode($node, $this->root);
            }
        } else {
            $this->insertNode($node, $node_prev);
        }
    }

    protected function insertNode($node, &$subtree) {
        if ($subtree == []) {
            // правило 2
            $subtree = $node;
        }
        else {
            $tags = [];
            // регулярка обволакивающего тега
            if (preg_match_all('/<([-\w]+?)[\s>](?!<\/).*?[>]*?(.*)<\/(.*?)>/i',$node->code,$tags)) {
                print_r($tags);
                if ($tags[1][0] == $tags[3][0]) {
                    $this->insert($tags[1][0],$tags[2][0],$node);
                } else { // если первый и конечный теги не совпали
                    if (preg_match_all('/<([-\w]+?)[\s>].*?[>]*?(.*?)<\/(.*?)>/i',$node->code,$tags)) {
                        print_r($tags);
                    }
                }
            } else {

                if (preg_match_all('/<([-\w]+?)[\s>].*?[>]*?(.*?)<\/(.*?)>/i',$node->code,$tags)) {
                    print_r($tags);
                }

            }


            /*if ($node->value > $subtree->value) {
                // правило 2b
                $this->insertNode($node, $subtree->right);
            }
            else if ($node->value < $subtree->value) {
                // правило 2c
                $this->insertNode($node, $subtree->left);
            }
            else {
                // исключаем повторы, правило 2d
            }*/
        }
    }

    public function traverse() {
        // отображение дерева в возрастающем порядке от корня
        $this->root->dump();
    }
}

$tree = new BinaryTree();
//$tree->insert('html','<body><div></div><div></div></body>');
$tree->insert('',file_get_contents('./page_test_html/index_001_html_5_simple.html'));
$tree->traverse();

/*$tree2 = new BinaryTree();
$tree2->insert('',file_get_contents('./page_test_html/index_001_html_5_simple.html'));
$tree2->traverse();*/

