<?php
	function addmodule ($bg_connexion) {
		return render(array('bg_connexion' => $bg_connexion), 'modules', 'module_list');
	}
	
	function expense_addmodule($bg_connexion) {
		return render(array('bg_connexion' => $bg_connexion), 'modules', 'add_expense_module');
	}
	
	function container_addmodule($bg_connexion) {	
		return render(array('bg_connexion' => $bg_connexion), 'modules', 'add_container_module');
	}
	
	function post_expense_addmodule ($bg_connexion) {
		$bg_title = encoding((isset($_POST['title']) ? $_POST['title'] : ''));
		$bg_tag = encoding((isset($_POST['tag']) ? $_POST['tag'] : array()));
		$bg_date = encoding((isset($_POST['date']) ? $_POST['date'] : ''));
		$bg_date = ($bg_date == '') ? date('Y-m-d') : $bg_date;
		$bg_hour = encoding((isset($_POST['hour']) ? $_POST['hour'] : ''));
		$bg_hour = ($bg_hour == '') ? date('H:i:s') : $bg_hour;
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
			"tag:input:fill:30" => $bg_tag,
			"Title:input:fill:30" => $bg_title
		);
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
	
	function post_container_addmodule ($bg_connexion) {
		$bg_title = encoding((isset($_POST['title']) ? $_POST['title'] : ''));
		$bg_name = encoding((isset($_POST['name']) ? $_POST['name'] : ''));
		$bg_tag = encoding((isset($_POST['tag']) ? $_POST['tag'] : array()));
		$bg_date = encoding((isset($_POST['date']) ? $_POST['date'] : ''));
		$bg_date = ($bg_date == '') ? date('Y-m-d') : $bg_date;
		$bg_hour = encoding((isset($_POST['hour']) ? $_POST['hour'] : ''));
		$bg_hour = ($bg_hour == '') ? date('H:i:s') : $bg_hour;
		$bg_tag = implode(":", $bg_tag);
		if (in_array("all", $bg_tag)) {
			$bg_tag="all";
		}
		$bg_show_title_class=encoding((isset($_POST['show_title_class']) ? $_POST['show_title_class'] : ''));
		$bg_prepare_module_content="{type_container{class{".
		$bg_show_title_class."}}}";		
		$bg_error = array(
			"Title:input:fill:30" => $bg_title,
			"Pages with this container:checkbox:check:30" => $bg_tag,
			"Name:input:fill:30" => $bg_name
		);
		error_message(true, $bg_error);
		if (empty($_SESSION['error_message'])){
			$select1=$bg_connexion->prepare("SELECT class FROM ".HASH."_modules WHERE title = :al_title");
			$select1->bindParam(':al_title', $bg_title);
			$select1->execute();
			$bg_fetch_class = $select1->rowCount();
			if(($bg_fetch_class < 0) || ($bg_fetch_class == 0)){			
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
				$select3=$bg_connexion->prepare("SELECT * FROM ".HASH."_modules WHERE class = :al_title");
				$select3->bindParam(':al_title', format_tag($bg_title));
				$select3->execute();
				$select3->setFetchMode(PDO::FETCH_OBJ);
				$bg_fetch_modules = $select3->fetch();
				$bg_id=$bg_fetch_modules->id;		
				$query = $bg_connexion->prepare("INSERT INTO ".HASH."_container (name, id_module) VALUES (:name,:id_module)");
				$query->execute(
					array(
					':name'=>$bg_name,
					':id_module'=>$bg_id
					)
				);
				$query = $bg_connexion->prepare("INSERT INTO ".HASH."_class (class, date, time, order1) VALUES (:class,:date,:time,:order1)");
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
?>