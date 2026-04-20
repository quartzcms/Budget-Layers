<?php
	function modif_modif_expense($bg_connexion) {
		$bg_id = decoding((isset($_GET['id_expense']) ? $_GET['id_expense'] : ''));
		$bg_title = encoding((isset($_POST['title']) ? $_POST['title'] : ''));
		$bg_class = encoding((isset($_POST['class']) ? $_POST['class'] : ''));
		$bg_publish = encoding((isset($_POST['publish']) ? $_POST['publish'] : ''));
		$bg_date = encoding((isset($_POST['date']) ? $_POST['date'] : ''));
		$bg_date = ($bg_date == '') ? date('Y-m-d') : $bg_date;
		$bg_hour = encoding((isset($_POST['hour']) ? $_POST['hour'] : ''));
		$bg_hour = ($bg_hour == '') ? date('H:i:s') : $bg_hour;
		$bg_value = encoding_ck((isset($_POST['value']) ? $_POST['value'] : ''));
		$bg_id_module = encoding((isset($_POST['id_module']) ? $_POST['id_module'] : ''));
		$bg_tag = encoding((isset($_POST['tag']) ? $_POST['tag'] : array()));
		$bg_cost = encoding((isset($_POST['cost']) ? $_POST['cost'] : array()));
		$bg_frequence = encoding((isset($_POST['frequence']) ? $_POST['frequence'] : 'daily'));
		$bg_tag = implode(":", $bg_tag);
		$bg_show_title=encoding((isset($_POST['show_title']) ? $_POST['show_title'] : ''));
		$bg_show_description=encoding((isset($_POST['show_description']) ? $_POST['show_description'] : ''));
		$bg_show_username=encoding((isset($_POST['show_username']) ? $_POST['show_username'] : ''));
		$bg_show_time=encoding((isset($_POST['show_time']) ? $_POST['show_time'] : ''));
		$bg_show_date=encoding((isset($_POST['show_date']) ? $_POST['show_date'] : ''));
		$bg_prepare_expense_content="{expense{".
		$bg_show_title.":".
		$bg_show_description.":".
		$bg_show_username.":".
		$bg_show_time.":".
		$bg_show_date."}}";
		$bg_error = array(
			"Title:input:fill:30" => $bg_title,
			"Text:textarea:fill:30" => $bg_value,
			"Cost:input:number:30" => $bg_cost
		);

		error_message(true, $bg_error);

		if (empty($_SESSION['error_message'])){			
			$update_expense = $bg_connexion->prepare("UPDATE ".HASH."_expenses SET content=?, title=?, publish=?, class=?, tag=?, modules=?, frequence=?, date=?, time=?, cost=? WHERE id=?");
			$update_expense->execute(
				array( 
					$bg_value,
					$bg_title,
					$bg_publish,
					$bg_class,
					$bg_tag,
					$bg_prepare_expense_content,
					$bg_frequence,
					$bg_date,
					$bg_hour,
					$bg_cost,
					$bg_id
				)
			);
		}
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}

	function modif_expense ($bg_connexion) {
		$bg_id_expense=decoding((isset($_GET['id_expense']) ? $_GET['id_expense'] : ''));
		$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_expenses WHERE id = :al_id_expense");
		$select1->bindParam(':al_id_expense', $bg_id_expense);
		$select1->execute();	
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_expenses = $select1->fetch();
		
		return render(array('bg_fetch_expenses' => $bg_fetch_expenses, 'bg_connexion' => $bg_connexion), 'expenses', 'mod_expense');
	}

	function post_update_expense ($bg_connexion) {
		$bg_id = (isset($_GET['id']) ? $_GET['id'] : '');
		$bg_title = encoding((isset($_POST['title']) ? $_POST['title'] : ''));
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
		$bg_prepare_module_content="{type_expense{class{".
		$bg_show_title_class."}:expense{".
		$bg_show_title.":".
		$bg_show_description.":".
		$bg_show_username.":".
		$bg_show_time.":".
		$bg_show_date."}}}";
		$bg_error = array(
			"Title:input:fill:30" => $bg_title
		);
		error_message(true, $bg_error);

		if (empty($_SESSION['error_message'])){
			$update_expense = $bg_connexion->prepare("UPDATE ".HASH."_class SET class=? WHERE class=?");
			$update_expense->execute(array(format_tag($bg_title),$bg_class));
			$update_expense = $bg_connexion->prepare("UPDATE ".HASH."_modules SET modules=?,tag=?,class=?,title=?,date=?,time=? WHERE id=?");
			$update_expense->execute(
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
		}
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}

	function post_add_expense($bg_connexion) {
		$bg_title = encoding((isset($_POST['title']) ? $_POST['title'] : ''));
		$bg_class = encoding((isset($_POST['class']) ? $_POST['class'] : ''));
		$bg_publish = encoding((isset($_POST['publish']) ? $_POST['publish'] : ''));
		$bg_cost = encoding((isset($_POST['cost']) ? $_POST['cost'] : ''));
		$bg_date = encoding((isset($_POST['date']) ? $_POST['date'] : ''));
		$bg_date = ($bg_date == '') ? date('Y-m-d') : $bg_date;
		$bg_hour = encoding((isset($_POST['hour']) ? $_POST['hour'] : ''));
		$bg_hour = ($bg_hour == '') ? date('H:i:s') : $bg_hour;
		$bg_frequence = encoding((isset($_POST['frequence']) ? $_POST['frequence'] : 'daily'));
		$bg_value = encoding_ck((isset($_POST['value']) ? $_POST['value'] : ''));
		$bg_tag = encoding((isset($_POST['tag']) ? $_POST['tag'] : array()));
		$bg_tag = implode(":", $bg_tag);
		$bg_show_title=encoding((isset($_POST['show_title']) ? $_POST['show_title'] : ''));
		$bg_show_description=encoding((isset($_POST['show_description']) ? $_POST['show_description'] : ''));
		$bg_show_username=encoding((isset($_POST['show_username']) ? $_POST['show_username'] : ''));
		$bg_show_time=encoding((isset($_POST['show_time']) ? $_POST['show_time'] : ''));
		$bg_show_date=encoding((isset($_POST['show_date']) ? $_POST['show_date'] : ''));
		$bg_prepare_expense_content="{expense{".
		$bg_show_title.":".
		$bg_show_description.":".
		$bg_show_username.":".
		$bg_show_time.":".
		$bg_show_date."}}";
		$bg_pseudo=$_SESSION['pseudom'];
		$bg_error = array(
			"Title:input:fill:30" => $bg_title,
			"Text:input:fill:30" => $bg_value,
			"Cost:input:number:30" => $bg_cost
		);
		error_message(true, $bg_error);
		
		if (empty($_SESSION['error_message'])){
			if(!empty($bg_class)){
				$query = $bg_connexion->prepare("INSERT INTO ".HASH."_expenses (title, username, class, modules, tag, date, time, frequence, order1, content, publish, cost) VALUES(:title,:username,:class,:modules,:tag,:date,:time,:frequence,:order1,:content,:publish,:cost)");
				$query->execute(
					array(
					':title'=>$bg_title,
					':username'=>$bg_pseudo,
					':class'=>$bg_class,
					':modules'=> $bg_prepare_expense_content,
					':tag'=> '',
					':date'=>$bg_date,
					':time'=>$bg_hour,
					':frequence'=>$bg_frequence,
					':order1'=>'1',
					':content'=>$bg_value,
					':publish'=>$bg_publish,
					':cost'=>$bg_cost
					)
				);
			}
			if(empty($bg_class) && !empty($bg_tag)){ 
				$query = $bg_connexion->prepare("INSERT INTO ".HASH."_expenses (title, username, modules, tag, class, date, time, frequence, order1, content, publish, cost) VALUES(:title,:username,:modules,:tag,:class,:date,:time,:frequence,:order1,:content,:publish,:cost)");
				$query->execute(
					array(
					':title'=>$bg_title,
					':username'=>$bg_pseudo,
					':modules'=>$bg_prepare_expense_content,
					':tag'=>$bg_tag,
					':class'=>'0',
					':date'=>$bg_date,
					':time'=>$bg_hour,
					':frequence'=>$bg_frequence,
					':order1'=>'1',
					':content'=>$bg_value,
					':publish'=>$bg_publish,
					':cost'=>$bg_cost
					)
				);
			}
			if(empty($bg_class) && empty($bg_tag)){ 
				$_SESSION['error_message'].='Please enter a value ! (Field Tag affected)';
			}
		}
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}

	function expense ($bg_connexion) {
		$bg_id_module=(isset($_GET['id']) ? $_GET['id'] : '');
		$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_modules WHERE id = :al_id_expense");
		$select1->bindParam(':al_id_expense', $bg_id_module);
		$select1->execute();
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_modules = $select1->fetch();
		
		return render(array('bg_fetch_modules' => $bg_fetch_modules, 'bg_id_module' => $bg_id_module, 'bg_connexion' => $bg_connexion), 'expenses', 'edit_expense');
	}
	
	function add_expense ($bg_connexion) {		
		return render(array('bg_connexion' => $bg_connexion), 'expenses', 'add_expense');
	}
	
?>