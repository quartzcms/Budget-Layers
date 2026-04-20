<?php
	function list_expense ($bg_connexion){
		$bg_search=encoding((isset($_POST['search_expense']) ? $_POST['search_expense'] : ''));
		$bg_class=encoding((isset($_POST['class_expense']) ? $_POST['class_expense'] : ''));
		$bg_cost=encoding((isset($_POST['cost_expense']) ? $_POST['cost_expense'] : ''));
		$bg_frequence=encoding((isset($_POST['frequence_expense']) ? $_POST['frequence_expense'] : ''));
		$bg_order=encoding((isset($_POST['order_expense']) ? $_POST['order_expense'] : ''));
		$bg_time=encoding((isset($_POST['time_expense']) ? $_POST['time_expense'] : ''));
		$bg_date=encoding((isset($_POST['date_expense']) ? $_POST['date_expense'] : ''));
		$bg_published=encoding((isset($_POST['published_expense']) ? $_POST['published_expense'] : ''));
		$bg_post_order=encoding((isset($_POST['post_order_expense']) ? $_POST['post_order_expense'] : ''));
		$buildQuery = '';
		if($bg_search || $bg_published || $bg_frequence){	
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
			if($bg_frequence){
				$order1[].=" frequence = '".$bg_frequence."'";
			}
			$buildQuery.=$order.implode(" AND ",$order1);
		}
	
		if($bg_cost || $bg_class || $bg_order || $bg_time || $bg_date){
			$order=	" ORDER BY";
			$order2=array();
			if($bg_cost){
				$order2[].=" cost ".$bg_cost;
			}
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
		if(isset($_POST['post_order_expense'])){
			$_SESSION['order_expense_query'] = $buildQuery;
		} else {
			$buildQuery = isset($_SESSION['order_expense_query']) ? $_SESSION['order_expense_query'] : '';
		}
		
		$select1=$bg_connexion->query("SELECT * FROM ".HASH."_expenses ".$buildQuery." LIMIT ".get_pagination());
		$select1->setFetchMode(PDO::FETCH_OBJ);
		
		$select2=$bg_connexion->query("SELECT * FROM ".HASH."_expenses");
		$bg_init_expenses_rows = $select2->rowCount();
		
		return render(array('select1' => $select1, 'bg_init_expenses_rows' => $bg_init_expenses_rows, 'bg_connexion' => $bg_connexion), 'expenses', 'expenses_list');
	}
	
	function order_expense ($bg_connexion){
		$bg_order=decoding((isset($_POST['order']) ? $_POST['order'] : array()));
		foreach($bg_order as $bg_key => $bg_value){
			$update_expense = $bg_connexion->prepare("UPDATE ".HASH."_expenses SET order1=? WHERE id=?");
			$update_expense->execute(array($bg_value,$bg_key));
		}
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit();
	}
	
	function delete_expense ($bg_connexion){	
		$bg_id=decoding((isset($_GET['id']) ? $_GET['id'] : ''));
		$select1=$bg_connexion->prepare("DELETE FROM ".HASH."_expenses WHERE id = :al_id");
		$select1->bindParam(':al_id', $bg_id);
		$select1->execute();
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit();
	}
	
	function publish_expense ($bg_connexion){	
		$bg_id=decoding((isset($_GET['id']) ? $_GET['id'] : ''));
		$bg_state=decoding((isset($_GET['state']) ? $_GET['state'] : ''));
		if($bg_state=='Yes'){$bg_enable=0;}else{$bg_enable=1;}
		$update_module = $bg_connexion->prepare("UPDATE ".HASH."_expenses SET publish=? WHERE id=?");
		$update_module->execute(array($bg_enable,$bg_id));
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit();
	}

?>