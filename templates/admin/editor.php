<?php
	if($_SESSION['editor']=='ckeditor' && function_exists('ckeditor_head')){
		echo ckeditor_head();
	}
?>
