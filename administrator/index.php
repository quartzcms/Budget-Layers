<?php
	ini_set('display_errors', 0);
	if(file_exists('../config.php')){ include('../config.php'); }
	else{ die('The config file dosen\'t exist !'); }

	session_start();	
	header('Content-Type: text/html; charset=utf-8');
	$_SESSION['editor']=$editor;
	if(!isset($_SESSION['error_message'])) { $_SESSION['error_message'] = ''; }
	if(!isset($_SESSION['populate'])) { $_SESSION['populate'] = array(); }
	if(isset($_GET['id'])){ $bg_id = $_GET['id']; }else{ $bg_id = '0'; }
	if(isset($_GET['page'])){ $bg_page = $_GET['page']; }else{ $bg_page = '0'; }
	if(isset($_GET['action'])){ $bg_action = $_GET['action']; }else{ $bg_action = '0'; }
	include('functions/database/'.$bg_type_mysql.'.php');
	
	include('functions/load/variables.php');
	include('../libraries/view.php');
	include('../libraries/tag.php');

	if(($bg_page != 'connexion') && ($bg_page != 'verif_login') && ($bg_page != '0')){
		security();
	}
		
	include('modules/modules/init/init.php');
	include('modules/users/user.php');
	include('modules/plugins/plugins.php');
	include('modules/logins/login.php');
	include('modules/expenses/expense.php');
	include('modules/modules/addmodule/init.php');
	include('modules/containers/container.php');
	include('modules/config/config.php');
	include('modules/panel/panel.php');
	include('modules/expenses/listexpense/initlist.php');
	/* ----ADD PLUGINS----- */

	$select1=$bg_connexion->query("SELECT * FROM ".HASH."_plugins WHERE publish='1'");
	$select1->setFetchMode(PDO::FETCH_OBJ);
	
	while($bg_fetch_plugins = $select1->fetch()){
		$plugin_name=$bg_fetch_plugins->content;
		
		if(file_exists("modules/".$plugin_name."/".$plugin_name.".php")){
			include("modules/".$plugin_name."/".$plugin_name.".php");
		}
	}
		
	//----------------//
	include('functions/load/template.php');
	repopulateform($_POST);
	$bg_url = basename($_SERVER['REQUEST_URI']);
	if(substr_count($bg_url, '\?')){ detectEmptyParameter($bg_url);}
	$bg_site_title = '';
	load_template($bg_connexion, $bg_site_title, load_modules($bg_connexion, $bg_page, $bg_id, $bg_action), $bg_page);
	$_SESSION['error_message'] = '';
	
?>