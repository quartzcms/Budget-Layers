<?php
	function loadvariable ($bg_connexion){
		$select=$bg_connexion->query("SELECT * FROM ".HASH."_config");
		$select->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_config = $select->fetch();
		$bg_title_page = $bg_fetch_config->title;
		return $bg_title_page;
	}
	
	function loadfileinfo ($bg_connexion){
		$select=$bg_connexion->query("SELECT * FROM ".HASH."_template WHERE active='1' AND admin='1'");
		$select->setFetchMode(PDO::FETCH_OBJ);
		$bg_init_template = $select->fetch();
		$bg_title_template = $bg_init_template->title;
		return $bg_title_template;
	}
	
	function loaddefaulttemplate ($bg_connexion){
		$select=$bg_connexion->query("SELECT * FROM ".HASH."_template WHERE active='1' AND admin='0'");
		$select->setFetchMode(PDO::FETCH_OBJ);
		$bg_init_template = $select->fetch();
		$bg_title_template = $bg_init_template->title;
		return $bg_title_template;
	}
	
	function format_tag($bg_txt_string) {
		$bg_txt = str_replace("'", "_", $bg_txt_string);
		$bg_txt = str_replace("\"", "_", $bg_txt);
		$bg_txt = str_replace("&#39;", "_", $bg_txt);
		$bg_txt = str_replace("&quot;", "_", $bg_txt);
		$bg_transliterationTable = array('á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', 'ç' => 'c', 'Ç' => 'C', 'Ð' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ê' => 'e', 'Ê' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ƒ' => 'f', 'ƒ' => 'F', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ñ' => 'n', 'Ñ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ö' => 'oe', 'Ö' => 'OE', 'š' => 's', 'Š' => 'S', 'ß' => 'SS', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'û' => 'u', 'Û' => 'U', 'ü' => 'ue', 'Ü' => 'UE', 'ý' => 'y', 'Ý' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'ž' => 'z', 'Ž' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u');
		$bg_txt = str_replace(array_keys($bg_transliterationTable), array_values($bg_transliterationTable), html_entity_decode($bg_txt));
		$bg_txt = preg_replace_callback("/[^a-zA-Z0-9]/", function(){ return "_"; }, $bg_txt);
		return $bg_txt;
	}
	
	function security (){
		if(!isset($_SESSION['pseudom'])){
			die('Not enough permission');
		}
	}
	
	function buildContainer ($bg_connexion){
		$container = '
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
			<!-- Brand and toggle get classed for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="index.php?page=cpanel">Demo - Budget-Layers</a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
			  <ul class="nav navbar-nav">
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">Modules <span class="caret"></span></a>
				  <ul class="dropdown-container" role="container">
					<li><a href="index.php">Modules</a></li>
					<li><a href="index.php?page=addmodule">Add module</a></li>
				  </ul>
				</li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">Expenses <span class="caret"></span></a>
				  <ul class="dropdown-container" role="container">
					<li><a href="index.php?page=list_expense">Expenses</a></li>
					<li><a href="index.php?page=add_expense">Add expense</a></li>
				  </ul>
				</li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">Users <span class="caret"></span></a>
				  <ul class="dropdown-container" role="container">
					<li><a href="index.php?page=list_user">Users</a></li>
					<li><a href="index.php?page=add_user">Add user</a></li>
				  </ul>
				</li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">Container <span class="caret"></span></a>
				  <ul class="dropdown-container" role="container">
					<li><a href="index.php?page=container_list">Container</a></li>
					<li><a href="index.php?page=add_tag_name">Add tag</a></li>
				  </ul>
				</li>
				<li><a href="index.php?page=configuration">Configuration</a></li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">Plugins <span class="caret"></span></a>
				  <ul class="dropdown-container" role="container">
					<li><a href="index.php?page=plugins&action=add">Add a plugin</a></li>
					<li><a href="index.php?page=plugins">List of plugins</a></li>';
					
					$select1=$bg_connexion->query("SELECT * FROM ".HASH."_config WHERE id = '1'");
					$select1->setFetchMode(PDO::FETCH_OBJ);
					$bg_fetch_config = $select1->fetch();
					
					if($bg_fetch_config->pause == 0){
						$select1=$bg_connexion->query("SELECT * FROM ".HASH."_plugins WHERE publish='1'");
						$select1->setFetchMode(PDO::FETCH_OBJ);
						
						while($bg_fetch_plugins = $select1->fetch()){
							$plugin_default_tag=$bg_fetch_plugins->default_tag;
							$plugin_title=$bg_fetch_plugins->title;
							$container .= "<li><a href=\"index.php?page=$plugin_default_tag\">$plugin_title</a></li>";
						}
					}
					$container .= '
					</ul>
				</li>
			  </ul>
			  <ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">View site <span class="caret"></span></a>
				  <ul class="dropdown-container" role="container">
					<li><a href="../index.php" target="_blank">View site</a></li>
					<li><a href="index.php?page=disconnect">Disconnect</a></li>
				  </ul>
				</li>
			  </ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>';
		return $container;
	}
	
	function detectEmptyParameter($bg_string){
		if($bg_string){	
			$bg_tableau = explode('?',$bg_string);
			$bg_string1 = $bg_tableau[1];
			
			if(substr_count($bg_string1, '&') == 0){
				$bg_tableau=explode('=', $bg_string1);
				
				if($bg_tableau[1]==""){
					die("Missing parameter in the url !");
				}
			}
			else{
				$bg_tableau=explode('&',$bg_string1);
				
				for($bg_i=0; $bg_i<count($bg_tableau); $bg_i++){
					$bg_get_value=explode("=",$bg_tableau[$bg_i]);			
					
					if($bg_get_value[1]==""){
						die("Missing parameter in the url !");
					}
				}
			}
		}
	}
	
	function error_message($bg_storing, $bg_array) {
		$_SESSION['error_message']='';
		$bg_error='';
		foreach($bg_array as $bg_key => $bg_value){
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
					if($bg_value=='NONE'){
						$bg_error.="The value NONE is not permitted ! (Field ".$bg_name.")<br />";
					}
				}
				if($bg_validation=="noSpecial"){
					if(!preg_match("/[A-Za-z, :,0-9]/", $bg_value)){
						$bg_error.="Specials caracters are forbidden ! (Field ".$bg_name.")<br />";
					}
				}
				if($bg_validation=="number"){
					if(!is_numeric($bg_value)){
						$bg_error.="Must be a valid integer ! (Field ".$bg_name.")<br />";
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
				$utf8DecodedEncodeArray[$key] = addslashes($value);	
			}
			else {
				$utf8DecodedEncodeArray[$key] =  htmlspecialchars(stripslashes($value), ENT_QUOTES);
			}
		}
		return $utf8DecodedEncodeArray;
	}
	
	function encoding($bg_string) {
		if(is_array($bg_string)){
			return utf8DecodeEncodeArray($bg_string, 'decode');
		}
		else {
			return addslashes($bg_string);
		}
	}
	
	function decoding($bg_string) {
		if(is_array($bg_string)){
			return utf8DecodeEncodeArray($bg_string, 'encode');
		}
		else {
			return htmlspecialchars(stripslashes($bg_string), ENT_QUOTES);
		}	
	}
	
	function encoding_ck($bg_string) {
		return addslashes($bg_string);
	}
	
	function decoding_ck($bg_string) {
		return stripslashes(htmlspecialchars($bg_string));
	}
	
	function repopulateform($bg_array) {
		foreach($bg_array as $bg_key => $bg_value){
			$_SESSION['populate'][$bg_key]=$bg_value;
		}
	}
	
	function substr_count_array( $bg_string, $bg_array ) {
		 $bg_count = 0;
		 foreach ($bg_array as $bg_value) {
			  if($bg_value==$bg_string){
				$bg_count++;
			  }
		 }
		 return $bg_count;
	}
	
	function get_pagination() {
		$var_Pa=(isset($_GET['k']) ? $_GET['k'] : '');
		$var_item = "10";
		if($var_Pa == ""){$var_Pa = 0;}
		$var_St = $var_Pa*$var_item;
		if($var_St == ""){$var_St = 0;}
		return $var_St.",".$var_item;
	}
	
	function pagination($var_nbT) {
		$var_Pa = (isset($_GET['page']) ? $_GET['page'] : '');
		$var_k = (isset($_GET['k']) ? $_GET['k'] : '');
		if($var_Pa){
			$page="?page=".$var_Pa."&k=";
		}
		else {
			$page="?k=";
		}
		$var_array = array();
		$var_item = "10";
		if($var_k == ""){$var_k = 0;}
		$var_St = $var_k*$var_item;
		if($var_St == ""){$var_St = 0;}
		$pagination="";
		$pagination .= "<div class=\"pagination-content\">";
		if($var_k > 0){
			$var_Pr=$var_k - 1;
			$pagination .= "<a href=\"/administrator/index.php".$page.$var_Pr."\" class=\"pagination\"><< Previous</a> ";
		}
		$var_i = 0;
		$var_j = 1;
		if($var_nbT > $var_item) {
			while($var_i < ($var_nbT / $var_item)){
				if($var_i != $var_k){
					$pagination .= "<a href=\"/administrator/index.php".$page.$var_i."\" class=\"pagination\">$var_j</a> ";
				} 
				else{
					$pagination .= "<span class=\"pagination\"><b>$var_j</b></span> ";
				}
				$var_i++;
				$var_j++;
			}
		}
		if($var_St + $var_item < $var_nbT){
			$var_Ne = $var_k + 1;
			$pagination .= "<a href=\"/administrator/index.php".$page.$var_Ne."\" class=\"pagination\">Next >></a>";
		}
		$pagination .= "</div>";
		return $pagination;
	}
?>