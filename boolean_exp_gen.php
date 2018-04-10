<?php
:::
function write($fname, $fmode, $fdata){
	$file = fopen($fname, $fmode);
	fwrite($file, $fdata);
	fclose($file);
	return 1;
}

function gen_block($a){
	$ret[$a] = '';

	for($b = 0; $b < $a; $b++){
		$output = gen_sub_block().' or ';
		$output_final = gen_sub_block();

		$b < $a - 1 && !in_array($output, $ret) ? $ret[$b] = $output : $ret[$b] = $output_final;
	}
    
    write('genBlock.output', 'w', implode('',$ret));
	return implode('',$ret);
}

function gen_sub_block(){
	$ret[100] = '';
	$and = 'and';
	$r = 0;

	$b = ['not q','q','not w', 'w', 'not e', 'e', 'not r', 'r','not t','t','not y', 'y', 'not u', 'u', 'not i', 'i',
	     'not o','o','not p', 'p', 'not a', 'a', 'not s', 's','not d','d','not f', 'f', 'not g', 'g', 'not h', 'h',
	     'not j','j','not k', 'k', 'not l', 'l', 'not z', 'z','not x','x','not c', 'c', 'not v', 'v', 'not b', 'b','not n', 'n','not m', 'm']; // 26

	    for($e = 0; $e < 28; $e++){
    	$fin_pos = 28 - $e;
        
    	if($e === 0){
    		$ret[$e] = '(';
    		goto b;
    	}

    	if($e == 26){
    		$ret[$e] = $b[mt_rand($r, $r + 1)];
    	}

    	if($fin_pos === 1){
    		$ret[$e] = ')';
    	}elseif($e != 0 && $e < 26){
    		$ret[$e] = $b[mt_rand($r, $r + 1)].' and ';
    	}
        
        $r = $r + 2;

        b:
    	}
        
        return implode('', $ret);

}

echo gen_block(10);

?>
