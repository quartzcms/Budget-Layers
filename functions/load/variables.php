<?php
	function loadvariable ($bg_connexion){
		$select1=$bg_connexion->query("SELECT * FROM ".HASH."_config");
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_title = $select1->fetch();
		$bg_title_page = $bg_fetch_title->title;
		return $bg_title_page;
	}
	
	function loadtemplatetitle($bg_connexion) {
		$select1=$bg_connexion->query("SELECT * FROM ".HASH."_template WHERE active='1' AND admin='0'");
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_template = $select1->fetch();
		$bg_title_template=$bg_fetch_template->title;
		return $bg_title_template;
	}
	
	function loadtitle($bg_connexion,$bg_title_page){
		$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_container_tags WHERE tag = :al_title_page");
		$select1->bindParam(':al_title_page', $bg_title_page);
		$select1->execute();
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_title_expense = $select1->fetch();

		$bg_title_page = !empty($bg_fetch_title_expense->name) ? $bg_fetch_title_expense->name : '';
		return $bg_title_page;
	}

	function security (){
		if(empty($_SESSION['pseudom'])){
			die('Not enough permission');
		}
	}
	
	function ifpause ($bg_connexion){
		$select1=$bg_connexion->query("SELECT * FROM ".HASH."_config");
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_title = $select1->fetch();
		$bg_title_page = $bg_fetch_title->pause;
		if($bg_title_page=='1'){
			return true;
		}
		else {
			return false;
		}
	}
	
	function error_message($bg_storing, $bg_array) {
		$_SESSION['error_message']='';
		
		foreach($bg_array as $bg_key => $bg_value){
			$bg_error='';
			$bg_key = explode(':',$bg_key);
			$bg_name=$bg_key[0];
			$bg_type=$bg_key[1];
			$bg_validation=$bg_key[2];
			$bg_length=$bg_key[3];
			// INPUT
			// VALIDATION 
			// email,fill,noSpecial,maxLength,minLength
			if($bg_type=="input"){
				if($bg_validation=="email"){
					if(!filter_var($bg_value, FILTER_VALIDATE_EMAIL)){
						$bg_error.="Please enter a valid email adress ! (Field ".$bg_name.")<br />";
					}	
				}
				
				if($bg_validation=="fill"){
					if(empty($bg_value)){
						$bg_error.="Please enter a value ! (Field ".$bg_name.")<br />";
					}
				}
				
				if($bg_validation=="noSpecial"){
					if(!preg_match("/[A-Za-z, :,0-9]/", $bg_value)){
						$bg_error.="Specials caracters are forbidden ! (Field ".$bg_name.")<br />";
					}
				}
				
				if($bg_validation=="maxLength"){
					if(strlen($bg_value) > $bg_length){
						$bg_error.="The maximum length of the field have been reached ! (Field ".$bg_name.")<br />";
					}
				}
				
				if($bg_validation=="minLength"){
					if(strlen($bg_value) < $bg_length){
						$bg_error.="The minimal length of the field have been reached ! (Field ".$bg_name.")<br />";
					}
				}
			}
			// TEXTAREA
			// VALIDATION 
			// fill,maxLength,minLength
			if($bg_type=="textarea"){
				
				if($bg_validation=="fill"){
					if(empty($bg_value)){
						$bg_error.="Please enter a value ! (Field ".$bg_name.")<br />";
					}
				}
				
				if($bg_validation=="maxLength"){
					if(strlen($bg_value) > $bg_length){
						$bg_error.="The maximum length of the field have been reached ! (Field ".$bg_name.")<br />";
					}
				}
				
				if($bg_validation=="minLength"){
					if(strlen($bg_value) < $bg_length){
						$bg_error.="The minimal length of the field have been reached ! (Field ".$bg_name.")<br />";
					}
				}
			}
			
			// SELECT
			// VALIDATION 
			// select
			if($bg_type=="select"){
				if($bg_validation=="select"){
					if($bg_value=='defaut' || $bg_value=='0' || $bg_value=='' || $bg_value=='00'){
						$bg_error.="Please choose an option from the select container ! (Field ".$bg_name.")<br />";
					}
				}
			}
			// RADIO
			// VALIDATION 
			// check,defaut
			if($bg_type=="radio"){
				if($bg_validation=="check"){
					if(empty($bg_value)){
						$bg_error.="Please choose an option ! (Field ".$bg_name.")<br />";
					}
					
					if($bg_value=="defaut"){
						$bg_error.="Please choose an option else than the default one ! (Field ".$bg_name.")<br />";
					}
				}
			}
			// CHECKBOX
			// VALIDATION 
			// check
			if($bg_type=="checkbox"){
				if($bg_validation=="check"){
					if(empty($bg_value)){
						$bg_error.="Please choose an option ! (Field ".$bg_name.")<br />";
					}
				}
			}
		}
		if($bg_storing==true){
			$_SESSION['error_message'] = $bg_error;
		}
		else {
			return $bg_error;
		}
	}
	
	/*encoding*/
	
	function utf8DecodeEncodeArray($array, $decodeEncode) {
		$utf8DecodedEncodeArray = array();
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				$utf8DecodedEncodeArray[$key] = utf8DecodeEncodeArray($value, $decodeEncode);
				continue;
			}		
		   	if($decodeEncode=='decode'){
				$utf8DecodedEncodeArray[$key] = stripslashes($value);
			}
			if($decodeEncode=='table'){
				$utf8DecodedEncodeArray[$key] = addslashes($value);
			}
		}
		return $utf8DecodedEncodeArray;
	}
	
	function encoding($bg_string) {
		if(is_array($bg_string)){
			return utf8DecodeEncodeArray($bg_string, 'table');
		}
		else {
			return addslashes($bg_string);
		}
	}
	
	function decoding($bg_string) {
		if(is_array($bg_string)){
			return utf8DecodeEncodeArray($bg_string, 'decode');
		}
		else {
			return stripslashes($bg_string);
		}
	}
	
	function decoding_ck($bg_string) {
		$bg_string=str_replace('&nbsp;',' ',$bg_string);
		return html_entity_decode(stripslashes($bg_string));
		/*****************************************
		Use <?php eval( '?> '.$expense.' <?php ' ); ?> to output php in template 
		where expense is the main type
		******************************************/
	}
	
	
	function repopulateform($bg_array) {
		foreach($bg_array as $bg_key => $bg_value){
			$_SESSION['populate'][$bg_key]=$bg_value;
		}
	}
?>