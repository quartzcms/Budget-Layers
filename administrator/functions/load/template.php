<?php
	function load_modules($bg_connexion, $bg_tag, $bg_id, $bg_action){
		if($bg_tag=='0'){
			$bg_tag='index';
		}
		
		if($bg_tag=='index' && !isset($_SESSION['pseudom'])){
			$bg_tag='connexion';
		}
		
		$bg_get_info='';
		
		$function_name = ($bg_action != '0') ? $bg_action."_".$bg_tag : $bg_tag;
		if(!preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $function_name) || !function_exists($function_name)){
			http_response_code(404);
			return '<div class="alert alert-danger" role="alert">This page is not available. The plugin providing it may be unpublished.</div>';
		}
		
		if($bg_action != '0'){	
			$bg_get_info=$function_name($bg_connexion);
			if(empty($bg_get_info)){
				header("Location: ".$_SERVER['HTTP_REFERER']);
			}
		}
		else {			
			if($bg_tag){	
				$bg_get_info=$bg_tag($bg_connexion);
			}
		}
		return $bg_get_info;	
	}

	function load_template ($bg_connexion, $bg_site_title, $bg_get_info, $bg_title_page){
		$bg_info_admin = $bg_get_info;
		$bg_title_template=loadfileinfo($bg_connexion);
		$bg_site_title = loadvariable($bg_connexion);
		include('../templates/'.$bg_title_template.'/index.php');
	}
?>