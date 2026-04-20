<?php
	function add_plugins($bg_connexion) {
		return render(array('bg_connexion' => $bg_connexion), 'plugins', 'add_plugin');
	}
	
	function rrmdir($dir) {
		foreach(glob($dir . '/*') as $file) {
			if(is_dir($file))
				rrmdir($file);
			else
				unlink($file);
		}
		rmdir($dir);
	}
	
	function delete_plugins ($bg_connexion){
		$bg_id = decoding((isset($_GET['id_plugin']) ? $_GET['id_plugin'] : ''));
		$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_plugins WHERE id = :al_id");
		$select1->bindParam(':al_id', $bg_id);
		$select1->execute();
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_plugins = $select1->fetch();
		$plugin_name = $bg_fetch_plugins->content;
		include("modules/".$plugin_name."/links.php");
		
		foreach($tables as $key => $value){
			$select1=$bg_connexion->prepare("DROP TABLE ".$value);
			$select1->execute();
		}
		
		rrmdir("modules/".$plugin_name);
		rrmdir("../modules/".$plugin_name);
		
		$select1=$bg_connexion->prepare("DELETE FROM ".HASH."_plugins WHERE id='$bg_id'");
		$select1->execute();
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}
	
	function publish_plugins ($bg_connexion) {
		$bg_id=decoding((isset($_GET['id_plugin']) ? $_GET['id_plugin'] : ''));
		$bg_state=decoding((isset($_GET['state']) ? $_GET['state'] : ''));
		if($bg_state=='Yes'){$bg_enable=0;}else{$bg_enable=1;}
		
		$update_plugin = $bg_connexion->prepare("UPDATE ".HASH."_plugins SET publish=? WHERE id=?");
		$update_plugin->execute(array($bg_enable,$bg_id));
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit();
	}
	
	function plugins ($bg_connexion){		
		$bg_search=encoding((isset($_POST['search_plugin']) ? $_POST['search_plugin'] : ''));
		$bg_title=encoding((isset($_POST['title_plugin']) ? $_POST['title_plugin'] : ''));
		$bg_time=encoding((isset($_POST['time_plugin']) ? $_POST['time_plugin'] : ''));
		$bg_date=encoding((isset($_POST['date_plugin']) ? $_POST['date_plugin'] : ''));
		$bg_published=encoding((isset($_POST['published_plugin']) ? $_POST['published_plugin'] : ''));
		$bg_post_order=encoding((isset($_POST['post_order_plugin']) ? $_POST['post_order_plugin'] : ''));
		$buildQuery = '';
		
		if($bg_search || $bg_published){	
			$order="WHERE";
			$order1=array();
			
			if($bg_search){
				$order1[].=" title LIKE '%".$bg_search."%'";
			}
			if($bg_published){
				if($bg_published=='yes'){$bg_published="1";}
				else{$bg_published="0";}
				$order1[].=" publish = '".$bg_published."'";
			}
			$buildQuery.=$order.implode(" AND ",$order1);
		}
	
		if($bg_title || $bg_time || $bg_date){
			$order=	" ORDER BY";
			$order2=array();
			if($bg_title){
				$order2[].=" title ".$bg_title;
			}
			if($bg_time){
				$order2[].=" time ".$bg_time;
			}
			if($bg_date){
				$order2[].=" date ".$bg_date;
			}
			$buildQuery.=$order.implode(", ",$order2);
		}
		if(isset($_POST['post_order_plugin'])){
			$_SESSION['order_plugin_query'] = $buildQuery;
		} else {
			$buildQuery = isset($_SESSION['order_plugin_query']) ? $_SESSION['order_plugin_query'] : '';
		}
		$select1=$bg_connexion->query("SELECT * FROM ".HASH."_plugins $buildQuery LIMIT ".get_pagination());
		$select1->setFetchMode(PDO::FETCH_OBJ);
		
		$select2=$bg_connexion->query("SELECT * FROM ".HASH."_plugins");
		$bg_init_plugins_rows = $select2->rowCount();
		
		return render(array('bg_connexion' => $bg_connexion, 'select1' => $select1, 'bg_init_plugins_rows' => $bg_init_plugins_rows), 'plugins', 'plugins_list');
	}
		
	function cpy($source, $dest){
		if(is_dir($source)) {
			$dir_handle=opendir($source);
			while($file=readdir($dir_handle)){
				if($file!="." && $file!=".."){
					if(is_dir($source."/".$file)){
						mkdir($dest."/".$file);
						cpy($source."/".$file, $dest."/".$file);
					} else {
						copy($source."/".$file, $dest."/".$file);
					}
				}
			}
			closedir($dir_handle);
		} else {
			copy($source, $dest);
		}
	}
		
	function unzip($source, $destination) {
		@mkdir($destination, 0777, true);
		$zip = new \ZipArchive;
		if ($zip->open(str_replace("//", "/", $source)) === true) {
			$zip->extractTo($destination);
			$zip->close();
		}
	}
	
	function run_sql_file($bg_connexion,$location){
		$commands = file_get_contents($location);
		$lines = explode("\n",$commands);
		$commands = '';
		foreach($lines as $line){
			$line = trim($line);
			if( $line && !startsWith($line,'--') ){
				$commands .= $line . "\n";
			}
		}
		$commands = explode(";", $commands);
		foreach($commands as $command){
			if(trim($command)){
				$select1=$bg_connexion->prepare($command);
				$select1->execute();
			}
		}
	}

	function startsWith($haystack, $needle){
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}
	
	
	function upload_plugins ($bg_connexion){
		$bg_content_display = '';
		$bg_content_display .=buildContainer($bg_connexion);
		$temp = explode(".", $_FILES["upload"]["name"]);
		if (end($temp)=='zip') {
			$bg_content_display.="Upload: " . $_FILES["upload"]["name"] . "<br>";
			$bg_content_display.="Type: " . $_FILES["upload"]["type"] . "<br>";
			$bg_content_display.="Size: " . ($_FILES["upload"]["size"] / 1024) . " kB<br>";
			$bg_content_display.="Temp file: " . $_FILES["upload"]["tmp_name"] . "<br>";
			if (file_exists("cache/".$_FILES["upload"]["name"])){
				$bg_content_display.= $_FILES["upload"]["name"] . " already exists. ";
			}
			else{
				move_uploaded_file($_FILES["upload"]["tmp_name"],"cache/" . $_FILES["upload"]["name"]);
			}
				if(file_exists("cache/".$_FILES["upload"]["name"])){
					$bg_content_display.= "Stored in: " . "administrator/cache/" . $_FILES["upload"]["name"];
					unzip("cache/".$_FILES["upload"]["name"], "cache/".$temp[0]);	
					$bg_content_display.="<br />Copying files...";
					
					if(is_dir("cache/".$temp[0]."/".$temp[0])){
						cpy("cache/".$temp[0]."/".$temp[0]."/administrator/modules", "modules");
						cpy("cache/".$temp[0]."/".$temp[0]."/modules", "../modules");
						$file_content = "cache/".$temp[0]."/".$temp[0]."/tables.sql";
						$config_file="cache/".$temp[0]."/".$temp[0]."/config.php";
					}
					else {
						cpy("cache/".$temp[0]."/administrator/modules", "modules");
						cpy("cache/".$temp[0]."/modules", "../modules");
						$file_content = "cache/".$temp[0]."/tables.sql";
						$config_file="cache/".$temp[0]."/config.php";
					}
					
					if(is_dir("modules/".$temp[0]) && is_dir("../modules/".$temp[0])){
						if($file_content){
							run_sql_file($bg_connexion,$file_content);
							$bg_content_display.="<br />Executing SQL of table file...";
						}
						else {
							$bg_content_display.="<br />Error! did not found the tables.sql file at the root";
						}
						
						if(file_exists($config_file)){
							include($config_file);
							$bg_date = date('Y-m-d');
							$bg_time = date('H:i:s');
							
							$query1 = $bg_connexion->prepare("INSERT INTO ".HASH."_plugins (title, date, time, default_tag, content, publish) VALUES(:title, :date, :time, :default_tag, :content, :publish)");
							$query1->execute(
								array(
								':title'=>$bg_title,
								':date'=>$bg_date,
								':time'=>$bg_time,
								':default_tag'=>$bg_default_tag,
								':content'=>$bg_module_name,
								':publish'=>'1'
								)
							);
						}
						else {
							$bg_content_display.="<br />Error! did not found the config.php file at the root";
						}
					}
					else{
						$bg_content_display.="Error copying files ! : This may be because the files are in many subfolders. Verify that the files are in only one folder inside the zip file (with the same name 'without .zip extension'), OR at the root of the zip file.<br /><br />This may also be because the permission on the modules folders are not set temporarily to chmod 777";
					}
				}
				else {
					$bg_content_display.="Error uploading the zip file. This may be because the permission on the administrator/cache folder are not set to chmod 777.";
				}
		}
		
		return $bg_content_display;
	}	
?>