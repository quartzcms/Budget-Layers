<?php
	function configuration($bg_connexion) {
		$select1=$bg_connexion->query("SELECT * FROM ".HASH."_config WHERE id='1'");
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_config = $select1->fetch();
		
		return render(array('bg_fetch_config' => $bg_fetch_config, 'bg_connexion' => $bg_connexion), 'config', 'config');
	}
	
	function post_configuration($bg_connexion) {
		$bg_title = encoding((isset($_POST['title']) ? $_POST['title'] : ''));
		$bg_emailadmin = encoding((isset($_POST['emailadmin']) ? $_POST['emailadmin'] : ''));
		$bg_pause = encoding((isset($_POST['pause']) ? $_POST['pause'] : ''));
		$bg_hash2 = encoding((isset($_POST['bg_hash']) ? $_POST['bg_hash'] : ''));
		$bg_editor = encoding((isset($_POST['editor_config']) ? $_POST['editor_config'] : ''));
		$bg_host2 = encoding((isset($_POST['bg_host']) ? $_POST['bg_host'] : ''));
		$bg_user2 = encoding((isset($_POST['bg_user']) ? $_POST['bg_user'] : ''));
		$bg_password2 = encoding((isset($_POST['bg_password']) ? $_POST['bg_password'] : ''));
		$bg_db_name2 = encoding((isset($_POST['bg_db_name']) ? $_POST['bg_db_name'] : ''));

		if(empty($bg_password2)){
			include('../config.php');
			$bg_password2 = $bg_password;
		}

		$bg_error = array(
			"Email admin:input:fill:30" => $bg_emailadmin,
			"Host:input:fill:30" => $bg_host2,
			"User:input:fill:30" => $bg_user2,
			"Database:input:fill:30" => $bg_db_name2,
			"Hash:input:fill:30" => $bg_hash2,
			"Title of the site:input:fill:30" => $bg_title
		);
		error_message(true, $bg_error);
		
		if (empty($_SESSION['error_message'])){
			$update_expense = $bg_connexion->prepare("UPDATE ".HASH."_config SET title=?,emailadmin=?,pause=? WHERE id=?");
			$update_expense->execute(array($bg_title, $bg_emailadmin, $bg_pause, '1'));
			
			if(file_exists('../config.php')) {
				$bg_fp = fopen('../config.php', 'w');
			}
			else {
				$bg_fp = fopen('../config.php', 'a');
			}

			fwrite($bg_fp, '<?php '."\n");
			fwrite($bg_fp, '$bg_host = "'.$bg_host2.'"; '."\n");
			fwrite($bg_fp, '$bg_user = "'.$bg_user2.'"; '."\n");
			fwrite($bg_fp, '$bg_password = "'.$bg_password2.'"; '."\n");
			fwrite($bg_fp, '$bg_db_name = "'.$bg_db_name2.'";'."\n");
			fwrite($bg_fp, 'define("HASH", "'.$bg_hash2.'"); '."\n");
			fwrite($bg_fp, '$bg_type_mysql = "mysql"; '."\n");
			fwrite($bg_fp, '$editor = "'.$bg_editor.'"; '."\n");
			fwrite($bg_fp, '?>');
			fclose($bg_fp);
		}
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}
	
?>