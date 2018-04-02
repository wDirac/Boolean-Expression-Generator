<?php

function write($fname, $fmode, $fdata){

	$file = fopen($fname, $fmode);
	fwrite($file, $fdata);
	fclose($file);
	
	return 1;
}

function read($fname, $ret_type=0, $data_len=0){
	$contentAndSize = [];
	$f_size = filesize($fname);

	$file = fopen($fname, 'r');
	$content = fread($file, $data_len === 0 ? $f_size : $data_len);
	fclose($file);

	if($ret_type === 0){
		return $content;
	}elseif($ret_type === 1){
		return $f_size;
	}elseif($ret_type === 2){
		$contentAndSize[0] = $content;
		$contentAndSize[1] = $f_size;

		return $contentAndSize;
	}
}

function gen_block($block_num, $symbols, $operators_form, $not_pos = 'L'){

	$ret = [];

	for($b = 0; $b < $block_num; $b++){
        

		$output = gen_sublock($symbols, $operators_form, $not_pos).$operators_form[3];
        
      
        if($b === ($block_num - 1)){

        	if(!in_array($output, $ret, 1)){

        		$ret[$b] = str_replace($operators_form[3], '', $output);

            }else{

            	$b--;
            	continue;
            }

        }

        if($b != ($block_num - 1)){
        	if(!in_array($output, $ret,1)){
        		$ret[$b] = $output;
        	}else{
        		$b--;
        		continue;
        	}
        }
	
	}

	$ret = implode('', $ret);
    return $ret;
 
}

function gen_sublock($symbols, $operator_form, $not_pos){

	$ret = [];
	$s_default = ['a','v','x','f','w','6','5'];
	$op_default = $operator_form;
    
    if(is_array($symbols) && (count($symbols) >= 2) && ($symbols != $s_default)){
    	$s_default = $symbols;
    }

	$not = [$op_default[4],''];

	for($a = 0; $a < count($s_default); $a++){

		if($a == 0 && $not_pos === 'R'){
			$ret[$a] = $op_default[0].$s_default[$a].$not[mt_rand(0,1)].$op_default[2];
		
		}elseif($a == 0 && $not_pos === 'L'){
			$ret[$a] = $op_default[0].$not[mt_rand(0,1)].$s_default[$a].$op_default[2];
		}

		if($a == (count($s_default) - 1) && $not_pos === 'R'){
			$ret[$a] = $s_default[$a].$not[mt_rand(0,1)].$op_default[1];

		}elseif($a == (count($s_default) - 1) && $not_pos === 'L'){
			$ret[$a] = $not[mt_rand(0,1)].$s_default[$a].$op_default[1];
		}

		if(($a != 0) && ($a != (count($s_default) - 1)) && ($not_pos === 'R')){
			$ret[$a] = $s_default[$a].$not[mt_rand(0,1)].$op_default[2];

		}elseif(($a != 0) && ($a != (count($s_default) - 1)) && ($not_pos === 'L')){

			$ret[$a] = $not[mt_rand(0,1)].$s_default[$a].$op_default[2];
		}
        
	}
    
	$ret = implode('',$ret);
	return $ret;

}



write('test.bn', 'wb', gen_block(300, ['A','B','C','D','E','F','Z','Y'], ['','', ' ', ' + ', "'",''],'R') );




?>