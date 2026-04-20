<?php

function get_path ($module, $view) {
	$dir =  dirname($_SERVER['PHP_SELF']);
	$dirs = explode('/', $dir);
	$side = !empty($dirs[1]) ? strtolower($dirs[1]).'/' : '';
	
	$last_character = explode('/', $_SERVER['DOCUMENT_ROOT']);
	if(end($last_character) == ''){
		$separator = '';
	} else {
		$separator = '/';
	}
	return $_SERVER['DOCUMENT_ROOT'].$separator.$side.'modules/'.$module.'/views/'.$view.'.php';
}

function render ($vars, $module, $view) {
	extract($vars);
	mb_internal_encoding('UTF-8');
	mb_http_output('UTF-8');
	mb_http_input('UTF-8');
	mb_language('uni');
	mb_regex_encoding('UTF-8');
	ob_start('mb_output_handler');
	header('Content-type: text/html; charset=utf-8');
	include(get_path($module, $view));
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

?>