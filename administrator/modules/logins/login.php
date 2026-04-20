<?php
	function connexion ($bg_connexion){		
		return render(array('bg_connexion' => $bg_connexion), 'logins', 'login');
	}
	
	function verif_login ($bg_connexion){
		$bg_pseudo_membre=encoding((isset($_POST['username']) ? $_POST['username'] : ''));
		$bg_passe_membre=encoding((isset($_POST['password']) ? $_POST['password'] : ''));
		$bg_passe_membre=md5($bg_passe_membre);
		$bg_error = array(
			"Username:input:fill:30" => $bg_pseudo_membre,
			"Password:input:fill:30" => $bg_passe_membre
		);
		error_message(true, $bg_error);
		
		$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_users WHERE password = :al_passe_membre AND username = :al_pseudo_membre");
		$select1->bindParam(':al_passe_membre', $bg_passe_membre);
		$select1->bindParam(':al_pseudo_membre', $bg_pseudo_membre);
		$select1->execute();
		$bg_verif_nb = $select1->rowCount();
		
		if($bg_verif_nb==0){
			$_SESSION['error_message'].='The user does not exists';
		}
		
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_row = $select1->fetch();
		$bg_block=$bg_row->blocked;
		if($bg_block=="1"){
			if($bg_enable_blocked=='yes'){
				$_SESSION['error_message'].='Sorry  can\'t log in';
			}
		}
		if(empty($_SESSION['error_message'])){
			$bg_ip = $_SERVER['REMOTE_ADDR'];
			$update_user = $bg_connexion->prepare("UPDATE ".HASH."_users SET ip=? WHERE password=? AND username=?");
			$update_user->execute(array($bg_ip,$bg_passe_membre,$bg_pseudo_membre));
			
			$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_users WHERE username = :al_pseudo_membre");
			$select1->bindParam(':al_pseudo_membre', $bg_pseudo_membre);
			$select1->execute();
			$select1->setFetchMode(PDO::FETCH_OBJ);
			$bg_fetch_users = $select1->fetch();
			
			$bg_pseudo_session=decoding($bg_fetch_users->username);
			$_SESSION['pseudom'] = $bg_pseudo_session;
		}
		header('Location: index.php?page=cpanel');
	}
	
	function disconnect($bg_connexion) {
		session_unset();
		session_destroy();
		header('Location: index.php');
		exit;
	}
?>