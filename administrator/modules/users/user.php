<?php
	function list_user ($bg_connexion) {
		$bg_search=encoding((isset($_POST['search_user']) ? $_POST['search_user'] : ''));
		$bg_username=encoding((isset($_POST['username_user']) ? $_POST['username_user'] : ''));
		$bg_first_name_search=encoding((isset($_POST['first_name_search_user']) ? $_POST['first_name_search_user'] : ''));
		$bg_first_name=encoding((isset($_POST['first_name_user']) ? $_POST['first_name_user'] : ''));
		$bg_last_name_search=encoding((isset($_POST['last_name_search_user']) ? $_POST['last_name_search_user'] : ''));
		$bg_last_name=encoding((isset($_POST['last_name_user']) ? $_POST['last_name_user'] : ''));
		$bg_email_search=encoding((isset($_POST['email_search_user']) ? $_POST['email_search_user'] : ''));
		$bg_email=encoding((isset($_POST['email_user']) ? $_POST['email_user'] : ''));
		$bg_post_order=encoding((isset($_POST['post_order_user']) ? $_POST['post_order_user'] : ''));
		$buildQuery = '';

		if($bg_search || $bg_first_name_search || $bg_last_name_search || $bg_email_search){	
			$order="WHERE";
			$order1=array();
			if($bg_search){
				$order1[].=" username LIKE '%".$bg_search."%'";
			}
			if($bg_first_name_search){
				$order1[].=" first_name LIKE '%".$bg_first_name_search."%'";
			}
			if($bg_last_name_search){
				$order1[].=" last_name LIKE '%".$bg_last_name_search."%'";
			}
			if($bg_email_search){
				$order1[].=" email LIKE '%".$bg_email_search."%'";
			}
			$buildQuery.=$order.implode(" AND ",$order1);
		}
	
		if($bg_first_name || $bg_last_name || $bg_email || $bg_username){
			$order=	" ORDER BY";
			$order2=array();
			if($bg_username){
				$order2[].=" username ".$bg_username;
			}
			if($bg_first_name){
				$order2[].=" first_name ".$bg_first_name;
			}
			if($bg_last_name){
				$order2[].=" last_name ".$bg_last_name;
			}
			if($bg_email){
				$order2[].=" email ".$bg_email;
			}
			$buildQuery.=$order.implode(", ",$order2);
		}
		
		if(isset($_POST['post_order_user'])){
			$_SESSION['order_user_query'] = $buildQuery;
		} else {
			$buildQuery = isset($_SESSION['order_user_query']) ? $_SESSION['order_user_query'] : '';
		}
		
		$select1=$bg_connexion->query("SELECT * FROM ".HASH."_users $buildQuery LIMIT ".get_pagination());
		$select1->setFetchMode(PDO::FETCH_OBJ);
		
		$select2=$bg_connexion->query("SELECT * FROM ".HASH."_users");
		$bg_init_users_rows = $select2->rowCount();
		
		return render(array('bg_connexion' => $bg_connexion, 'select1' => $select1, 'bg_init_users_rows' => $bg_init_users_rows), 'users', 'users_list');
	}
	
	function update_user ($bg_connexion) {
		$bg_username = encoding((isset($_POST['username']) ? $_POST['username'] : ''));
		$bg_first_name = encoding((isset($_POST['first_name']) ? $_POST['first_name'] : ''));
		$bg_last_name = encoding((isset($_POST['last_name']) ? $_POST['last_name'] : ''));
		$bg_password = encoding((isset($_POST['password']) ? $_POST['password'] : ''));
		$bg_email = encoding((isset($_POST['email']) ? $_POST['email'] : ''));
		$bg_gender = encoding((isset($_POST['gender']) ? $_POST['gender'] : ''));
		$bg_city = encoding((isset($_POST['city']) ? $_POST['city'] : ''));
		$bg_age = encoding((isset($_POST['age']) ? $_POST['age'] : ''));
		$bg_about = encoding((isset($_POST['about']) ? $_POST['about'] : ''));
		$bg_country = encoding((isset($_POST['country']) ? $_POST['country'] : ''));
		$bg_error = array(
			"User:input:fill:30" => $bg_username,
			"User:input:noSpecial:30" => $bg_username,
			"User:input:maxLength:50" => $bg_username,
			"First name:input:fill:30" => $bg_first_name,
			"Last name:input:fill:30" => $bg_last_name,
			"Email:input:fill:30" => $bg_email,
			"Email:input:email:30" => $bg_email,
			"City:input:fill:30" => $bg_city,
			"Age:input:fill:30" => $bg_age,
			"About:textarea:fill:30" => $bg_about,
			"Country:input:fill:30" => $bg_country
		);
		error_message(true,$bg_error);
				
		if(empty($_SESSION['error_message'])){
			$bg_password=md5($bg_password);
			
			if(isset($_POST['update'])){
				if(isset($_POST['password'])){
					$update_user = $bg_connexion->prepare("UPDATE ".HASH."_users SET username=?,password=?,email=?,gender=?,city=?,first_name=?,last_name=?,age=?,about=?,country=? WHERE id=?");
					$update_user->execute(array($bg_username,$bg_password,$bg_email,$bg_gender,$bg_city,$bg_first_name,$bg_last_name,$bg_age,$bg_about,$bg_country,$_POST['update']));
				}
				else {
					$update_user = $bg_connexion->prepare("UPDATE ".HASH."_users SET username=?,email=?,gender=?,city=?,first_name=?,last_name=?,age=?,about=?,country=? WHERE id=?");
					$update_user->execute(array($bg_username,$bg_email,$bg_gender,$bg_city,$bg_first_name,$bg_last_name,$bg_age,$bg_about,$bg_country,$_POST['update']));
				}
			}
			else {
				$query = $bg_connexion->prepare("INSERT INTO ".HASH."_users (username, password, email, gender, ip, city, first_name, last_name, age, about, country) VALUES (:username,:password, :email, :gender, :ip, :city, :first_name, :last_name, :age, :about, :country)");
				$query->execute(
					array(
					':username'=>$bg_username,
					':password'=>$bg_password,
					':email'=>$bg_email,
					':gender'=>$bg_gender,
					':ip'=>$_SERVER["REMOTE_ADDR"],
					':city'=>$bg_city,
					':first_name'=>$bg_first_name,
					':last_name'=>$bg_last_name,
					':age'=>$bg_age,
					':about'=>$bg_about,
					':country'=>$bg_country
					)
				);
			}
		}
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}
	
	function add_user ($bg_connexion) {
		return render(array('bg_connexion' => $bg_connexion), 'users', 'add_user');
	}
	
	function update_user_old ($bg_connexion) {
		$bg_id=decoding((isset($_GET['id']) ? $_GET['id'] : ''));
		$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_users WHERE id = :al_id");
		$select1->bindParam(':al_id', $bg_id);
		$select1->execute();
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_users = $select1->fetch();
		
		return render(array('bg_connexion' => $bg_connexion, 'bg_fetch_users' => $bg_fetch_users), 'users', 'modif_user');
	}
	
	function delete_user ($bg_connexion) {
		$bg_id=encoding((isset($_POST['delete']) ? $_POST['delete'] : ''));
		foreach($bg_id as $key => $value){
			if($value != '1'){
				$select1=$bg_connexion->prepare("DELETE FROM ".HASH."_users WHERE id='$value'");
				$select1->execute();
			}
		}
		
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}
?>