<?php
	function plan_addmodule($bg_connexion) {
		return render(array('bg_connexion' => $bg_connexion), 'plan', 'add_plan_module');
	}
	
	function post_plan_addmodule ($bg_connexion) {
		$bg_title = encoding((isset($_POST['title']) ? $_POST['title'] : ''));
		$bg_pay_amount = encoding((isset($_POST['pay_amount']) ? $_POST['pay_amount'] : ''));
		$bg_pay_frequence = encoding((isset($_POST['pay_frequence']) ? $_POST['pay_frequence'] : ''));
		$bg_title = encoding((isset($_POST['title']) ? $_POST['title'] : ''));
		$bg_date = encoding((isset($_POST['date']) ? $_POST['date'] : ''));
		$bg_date = ($bg_date == '') ? date('Y-m-d') : $bg_date;
		$bg_hour = encoding((isset($_POST['hour']) ? $_POST['hour'] : ''));
		$bg_hour = ($bg_hour == '') ? date('H:i:s') : $bg_hour;
		$bg_tag = encoding((isset($_POST['tag']) ? $_POST['tag'] : array()));
		$bg_tag = implode(":", $bg_tag);
		if (in_array("all", $bg_tag)) {
			$bg_tag="all";
		}
		$bg_show_title_class=encoding((isset($_POST['show_title_class']) ? $_POST['show_title_class'] : ''));
		$bg_show_title=encoding((isset($_POST['show_title']) ? $_POST['show_title'] : ''));
		$bg_show_description=encoding((isset($_POST['show_description']) ? $_POST['show_description'] : ''));
		$bg_show_username=encoding((isset($_POST['show_username']) ? $_POST['show_username'] : ''));
		$bg_show_time=encoding((isset($_POST['show_time']) ? $_POST['show_time'] : ''));
		$bg_show_date=encoding((isset($_POST['show_date']) ? $_POST['show_date'] : ''));
		$bg_prepare_module_content="{type_plan{class{".
		$bg_show_title_class."}:plan{".
		$bg_show_title.":".
		$bg_show_description.":".
		$bg_show_username.":".
		$bg_show_time.":".
		$bg_show_date."}}}";
		$bg_error = array(
			"Tag:input:fill:30" => $bg_tag,
			"Title:input:fill:30" => $bg_title
		);
		
		$pay_data = array();
		foreach ($bg_pay_amount as $key => $value){
			if(!empty($bg_pay_amount[$key])){
				$pay_data[$key] = array('amount' => $bg_pay_amount[$key], 'frequence' => $bg_pay_frequence[$key]);
			}
		}
		
		error_message(true, $bg_error);
		if (empty($_SESSION['error_message'])){
			$select1=$bg_connexion->prepare("SELECT class FROM ".HASH."_modules WHERE title = :al_title");
			$select1->bindParam(':al_title', $bg_title);
			$select1->execute();
			$bg_fetch_modules = $select1->rowCount();
			if($bg_fetch_modules > 0){}
			else{
				$query = $bg_connexion->prepare("INSERT INTO ".HASH."_modules (title, class, modules, order1, date, time, tag, username, published) VALUES (:title, :class, :modules, :order1, :date, :time, :tag, :username, :published)");
				$query->execute(
					array(
					':title'=>$bg_title,
					':class'=>format_tag($bg_title),
					':modules'=>$bg_prepare_module_content,
					':order1'=>'1',
					':date'=>$bg_date,
					':time'=>$bg_hour,
					':tag'=>$bg_tag,
					':username'=>$_SESSION['pseudom'],
					':published'=>'0'
					)
				);
				
				$query = $bg_connexion->prepare("INSERT INTO ".HASH."_plans (module_id, pay) VALUES (:module_id, :pay)");
				$query->execute(
					array(
					':module_id'=> $bg_connexion->lastInsertId(),
					':pay'=> json_encode($pay_data)
					)
				);
				
				$query = $bg_connexion->prepare("INSERT INTO ".HASH."_class (class, date, time, order1) VALUES (:class, :date, :time, :order1)");
				$query->execute(
					array(
					':class'=>format_tag($bg_title),
					':date'=>$bg_date,
					':time'=>$bg_hour,
					':order1'=>'1'
					)
				);
			}
		}
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}

	function post_update_plan ($bg_connexion) {
		$bg_id = (isset($_GET['id']) ? $_GET['id'] : '');
		$bg_title = encoding((isset($_POST['title']) ? $_POST['title'] : ''));
		$bg_pay_amount = encoding((isset($_POST['pay_amount']) ? $_POST['pay_amount'] : ''));
		$bg_pay_frequence = encoding((isset($_POST['pay_frequence']) ? $_POST['pay_frequence'] : ''));
		$bg_class =  encoding((isset($_POST['class']) ? $_POST['class'] : ''));
		$bg_date = encoding((isset($_POST['date']) ? $_POST['date'] : ''));
		$bg_date = ($bg_date == '') ? date('Y-m-d') : $bg_date;
		$bg_hour = encoding((isset($_POST['hour']) ? $_POST['hour'] : ''));
		$bg_hour = ($bg_hour == '') ? date('H:i:s') : $bg_hour;
		$bg_tag = encoding((isset($_POST['tag']) ? $_POST['tag'] : array()));
		$bg_tag = implode(":", $bg_tag);
		if (in_array("all", $bg_tag)) {
			$bg_tag="all";
		}
		$bg_show_title_class=encoding((isset($_POST['show_title_class']) ? $_POST['show_title_class'] : ''));
		$bg_show_title=encoding((isset($_POST['show_title']) ? $_POST['show_title'] : ''));
		$bg_show_description=encoding((isset($_POST['show_description']) ? $_POST['show_description'] : ''));
		$bg_show_username=encoding((isset($_POST['show_username']) ? $_POST['show_username'] : ''));
		$bg_show_time=encoding((isset($_POST['show_time']) ? $_POST['show_time'] : ''));
		$bg_show_date=encoding((isset($_POST['show_date']) ? $_POST['show_date'] : ''));
		$bg_prepare_module_content="{type_plan{class{".
		$bg_show_title_class."}:plan{".
		$bg_show_title.":".
		$bg_show_description.":".
		$bg_show_username.":".
		$bg_show_time.":".
		$bg_show_date."}}}";
		$bg_error = array(
			"Title:input:fill:30" => $bg_title
		);
		error_message(true, $bg_error);
		
		$pay_data = array();
		foreach($bg_pay_amount as $key => $value){
			if(!empty($bg_pay_amount[$key])){
				$pay_data[$key] = array('amount' => $bg_pay_amount[$key], 'frequence' => $bg_pay_frequence[$key]);
			}
		}

		if (empty($_SESSION['error_message'])){
			$update_plan = $bg_connexion->prepare("UPDATE ".HASH."_class SET class=? WHERE class=?");
			$update_plan->execute(array(format_tag($bg_title),$bg_class));
			$update_plan = $bg_connexion->prepare("UPDATE ".HASH."_modules SET modules=?,tag=?,class=?,title=?,date=?,time=? WHERE id=?");
			$update_plan->execute(
				array(
					$bg_prepare_module_content,
					$bg_tag,
					format_tag($bg_title),
					$bg_title,
					$bg_date,
					$bg_hour,
					$bg_id
				)
			);
			$update_plan = $bg_connexion->prepare("UPDATE ".HASH."_plans SET pay=? WHERE module_id=?");
			$update_plan->execute(
				array(
					json_encode($pay_data),
					$bg_id
				)
			);
			
		}
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}
	
	function list_plan ($bg_connexion) {
		$bg_tag = (isset($_GET['tag']) ? $_GET['tag'] : '');
		$condition_extra = '';
		if(!empty($bg_tag) && $bg_tag != 'all'){
			$condition_extra = " AND tag LIKE '%".$bg_tag."%'";
		}
		$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_modules WHERE modules LIKE '%type_plan%'".$condition_extra);
		$select1->execute();
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_modules = $select1->fetchAll();
		
		$data = array();
		
		foreach($bg_fetch_modules as $key => $value){		
			$data['module'][$value->id] = $value;
			
			$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_plans WHERE module_id = :al_id");
			$select1->bindParam(':al_id', $value->id);
			$select1->execute();
			$select1->setFetchMode(PDO::FETCH_OBJ);
			$bg_fetch_plans = $select1->fetch();
			$data['plans'][$value->id] = $bg_fetch_plans;
		}
		
		$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_modules WHERE modules LIKE '%type_expense%'".$condition_extra);
		$select1->execute();
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_modules = $select1->fetchAll();
		
		foreach($bg_fetch_modules as $key => $value){
			$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_expenses WHERE class = '".$value->class."'".$condition_extra);
			$select1->execute();
			$select1->setFetchMode(PDO::FETCH_OBJ);
			$bg_fetch_expenses = $select1->fetchAll();
			$data['expenses'][$value->id]['data'] = $value;
			$data['expenses'][$value->id]['expenses_item'] = $bg_fetch_expenses;
		}
		
		$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_expenses WHERE class = '0'".$condition_extra);
		$select1->execute();
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_expenses = $select1->fetchAll();
		$data['other_expenses'] = $bg_fetch_expenses;
		
		return render(array('data' => $data, 'bg_connexion' => $bg_connexion), 'plan', 'list_plan');
	}

	function plan ($bg_connexion) {
		$bg_id_module=(isset($_GET['id']) ? $_GET['id'] : '');
		$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_modules WHERE id = :al_id_plan");
		$select1->bindParam(':al_id_plan', $bg_id_module);
		$select1->execute();
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_modules = $select1->fetch();
		
		$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_plans WHERE module_id = :al_id_plan");
		$select1->bindParam(':al_id_plan', $bg_id_module);
		$select1->execute();
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_plans = $select1->fetch();
		
		return render(array('bg_fetch_modules' => $bg_fetch_modules, 'bg_fetch_plans' => $bg_fetch_plans, 'bg_id_module' => $bg_id_module, 'bg_connexion' => $bg_connexion), 'plan', 'edit_plan');
	}
	
?>