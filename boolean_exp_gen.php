<?php

function write($fname, $fdata, $fmode = 'wb'){ // no completada

	$file = fopen($fname, $fmode);
	fwrite($file, $fdata);
	fclose($file);
	
}

function read($fname, $ret_type=0, $data_len=0){ // casi completada
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

function gen_block($mode, $symbols, $operators_form){

	$s_comb = pow(2, count($symbols));

	if($mode[1] === 'RC' && $mode[0] > $s_comb){
		echo 'Parametro cantidad en $mode[0] debe ser inferior o igual a '.$s_comb.' Eject Eject, autodestruction in 3,2,1....';
		exit();
	}

	$ret = [];

	for($b = 0; $b < $mode[0]; $b++){
        

		$output = gen_sublock($mode, $symbols, $operators_form).$operators_form[3];
        
      
        if($b === ($mode[0] - 1)){

        	if(($mode[1] === 'RC') && !in_array($output, $ret, 1)){

        		$ret[$b] = str_replace($operators_form[3], '', $output);

            }elseif($mode[1] === 'RC'){

            	$b--;
            	continue;
            }

            if($mode[1] === 'R'){
            	$ret[$b] = str_replace($operators_form[3], '', $output);
            }

        }

        if($b != ($mode[0] - 1)){

        	if(($mode[1] === 'RC') && !in_array($output, $ret,1)){
        		$ret[$b] = $output;
        	}elseif($mode[1] === 'RC'){
        		$b--;
        		continue;
        	}

        	if($mode[1] === 'R'){
        		$ret[$b] = $output;
        	}
        }
	
	}

	$ret = implode('', $ret);
    return $ret;
 
}

function gen_sublock($mode, $symbols, $operator_form){

	$ret = [];
	$s_default = ['a','v','x','f','w','6','5'];
	$op_default = $operator_form;
    
    if(is_array($symbols) && (count($symbols) >= 2) && ($symbols != $s_default)){
    	$s_default = $symbols;
    }

	$not = [$op_default[4],''];

	for($a = 0; $a < count($s_default); $a++){

		if($a == 0 && $mode[2] === 'N-R'){
			$ret[$a] = $op_default[0].$s_default[$a].$not[mt_rand(0,1)].$op_default[2];
		
		}elseif($a == 0 && $mode[2] === 'N-L'){
			$ret[$a] = $op_default[0].$not[mt_rand(0,1)].$s_default[$a].$op_default[2];
		}

		if($a == (count($s_default) - 1) && $mode[2] === 'N-R'){
			$ret[$a] = $s_default[$a].$not[mt_rand(0,1)].$op_default[1];

		}elseif($a == (count($s_default) - 1) && $mode[2] === 'N-L'){
			$ret[$a] = $not[mt_rand(0,1)].$s_default[$a].$op_default[1];
		}

		if(($a != 0) && ($a != (count($s_default) - 1)) && ($mode[2] === 'N-R')){
			$ret[$a] = $s_default[$a].$not[mt_rand(0,1)].$op_default[2];

		}elseif(($a != 0) && ($a != (count($s_default) - 1)) && ($mode[2] === 'N-L')){

			$ret[$a] = $not[mt_rand(0,1)].$s_default[$a].$op_default[2];
		}
        
	}
    
	$ret = implode('',$ret);
	return $ret;

}

?>
