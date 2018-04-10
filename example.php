<?php

require_once('bgen_lib.php');
ini_set('memory_limit', -1);

$file_name = 'test.txt';

$mode = [6540,'RC','N-R'];
$symbols = ['A','B', 'C', 'D', 'E', 'F', 'Q', 'j', 'O', 'Z'];
$operators_form = ['(',')', ' x ', ' + ', "'"];

$data = gen_block($mode, $symbols, $operators_form);

write($file_name, $data);


?>
