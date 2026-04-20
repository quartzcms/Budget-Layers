<?php
	function index ($bg_connexion){	
		$bg_search=encoding((isset($_POST['search_module']) ? $_POST['search_module'] : ''));
		$bg_type=encoding((isset($_POST['type_module']) ? $_POST['type_module'] : ''));
		$bg_class=encoding((isset($_POST['class_module']) ? $_POST['class_module'] : ''));
		$bg_order=encoding((isset($_POST['order_module']) ? $_POST['order_module'] : ''));
		$bg_time=encoding((isset($_POST['time_module']) ? $_POST['time_module'] : ''));
		$bg_date=encoding((isset($_POST['date_module']) ? $_POST['date_module'] : ''));
		$bg_published=encoding((isset($_POST['published_module']) ? $_POST['published_module'] : ''));
		$bg_post_order=encoding((isset($_POST['post_order_module']) ? $_POST['post_order_module'] : ''));
		$buildQuery = '';
		
		if($bg_type || $bg_search || $bg_published){	
			$order="WHERE";
			$order1=array();
			if($bg_search){
				$order1[].=" class LIKE '%".$bg_search."%'";
			}
			if($bg_type){
				$order1[].=" modules LIKE '%".$bg_type."%'";
			}
			if($bg_published){
				if($bg_published=='yes'){$bg_published="1";}
				else{$bg_published="0";}
				$order1[].=" published = '".$bg_published."'";
			}
			$buildQuery.=$order.implode(" AND ",$order1);
		}
	
		if($bg_class || $bg_order || $bg_time || $bg_date){
			$order=	" ORDER BY";
			$order2=array();
			if($bg_class){
				$order2[].=" class ".$bg_class;
			}
			if($bg_order){
				$order2[].=" order1 ".$bg_order;
			}
			if($bg_time){
				$order2[].=" time ".$bg_time;
			}
			if($bg_date){
				$order2[].=" date ".$bg_date;
			}
			$buildQuery.=$order.implode(", ",$order2);
		}
		if(isset($_POST['post_order_module'])){
			$_SESSION['order_module_query'] = $buildQuery;
		} else {
			$buildQuery = isset($_SESSION['order_module_query']) ? $_SESSION['order_module_query'] : '';
		}
		$select1=$bg_connexion->query("SELECT * FROM ".HASH."_modules $buildQuery LIMIT ".get_pagination());
		$select1->setFetchMode(PDO::FETCH_OBJ);
		
		$select2=$bg_connexion->query("SELECT * FROM ".HASH."_modules");
		$bg_init_modules_rows = $select2->rowCount();
		
		return render(array('bg_connexion' => $bg_connexion, 'select1' => $select1, 'bg_init_modules_rows' => $bg_init_modules_rows), 'modules', 'modules');
	}
	
	function delete_delete_module ($bg_connexion){	
		$bg_id=decoding((isset($_GET['id']) ? $_GET['id'] : ''));
		
		$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_modules WHERE id = :al_id");
		$select1->bindParam(':al_id', $bg_id);
		$select1->execute();
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_modules = $select1->fetch();
		
		$bg_class=decoding($bg_fetch_modules->class);
		$bg_type_module=decoding($bg_fetch_modules->modules);
		$bg_id=decoding($bg_fetch_modules->id);
		
		if(substr_count($bg_type_module, 'type_expense')){
			$select1=$bg_connexion->prepare("DELETE FROM ".HASH."_expenses WHERE class='$bg_class'");
			$select1->execute();
		}
		
		if(substr_count($bg_type_module, 'type_container')){
			$select2=$bg_connexion->query("SELECT * FROM ".HASH."_container WHERE id_module='$bg_id'");
			$select2->setFetchMode(PDO::FETCH_OBJ);
			$bg_fetch_modules = $select2->fetch();
			$bg_id_container=decoding($bg_fetch_modules->id);
			$select1=$bg_connexion->prepare("DELETE FROM ".HASH."_container_tags WHERE id_index='$bg_id_container'");
			$select1->execute();
			$select1=$bg_connexion->prepare("DELETE FROM ".HASH."_container WHERE id_module='$bg_id'");
			$select1->execute();
		}
		
		if(substr_count($bg_type_module, 'type_comment')){
			$select1=$bg_connexion->prepare("DELETE FROM ".HASH."_comments WHERE id_module='$bg_id'");
			$select1->execute();
		}
		if(substr_count($bg_type_module, 'type_plan')){
			$select1=$bg_connexion->prepare("DELETE FROM ".HASH."_plans WHERE module_id='$bg_id'");
			$select1->execute();
		}
		$select1=$bg_connexion->prepare("DELETE FROM ".HASH."_class WHERE class='$bg_class'");
		$select1->execute();
		$select1=$bg_connexion->prepare("DELETE FROM ".HASH."_modules WHERE id='$bg_id'");
		$select1->execute();
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit();
	}
	
	function publish_module ($bg_connexion){	
		$bg_id=decoding((isset($_GET['id']) ? $_GET['id'] : ''));
		$bg_state=decoding((isset($_GET['state']) ? $_GET['state'] : ''));
		if($bg_state=='Yes'){$bg_enable=0;}else{$bg_enable=1;}
		$update_module = $bg_connexion->prepare("UPDATE ".HASH."_modules SET published=? WHERE id=?");
		$update_module->execute(array($bg_enable,$bg_id));
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit();
	}
	
	function order_module ($bg_connexion){
		$bg_order=decoding((isset($_POST['order']) ? $_POST['order'] : array()));
		foreach($bg_order as $bg_key => $bg_value){
			$update_module = $bg_connexion->prepare("UPDATE ".HASH."_modules SET order1=? WHERE id=?");
			$update_module->execute(array($bg_value,$bg_key));
		}
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit();
	}
	
?>