<?php
	if($_SESSION['editor']=='ckeditor' && function_exists('ckeditor_footer')){
		echo ckeditor_footer();
	}
?>
