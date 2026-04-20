<?php
	function container ($bg_connexion) {
		$bg_id_module = (isset($_GET['id']) ? $_GET['id'] : '');
		$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_modules WHERE id = :al_id_module");
		$select1->bindParam(':al_id_module', $bg_id_module);
		$select1->execute();
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_modules = $select1->fetch();
		
		return render(array('bg_connexion' => $bg_connexion, 'bg_fetch_modules' => $bg_fetch_modules, 'bg_id_module' => $bg_id_module), 'containers', 'edit_module');
	}
	
	function container_list ($bg_connexion) {
		return render(array('bg_connexion' => $bg_connexion), 'containers', 'container_list');
	}
	
	function add_tag_name ($bg_connexion) {
		return render(array('bg_connexion' => $bg_connexion), 'containers', 'add_tag');
	}
	
	function post_add_tag($bg_connexion){
		$bg_name=encoding(explode('-', (isset($_POST['name']) ? $_POST['name'] : '')));
		$bg_id=$bg_name[0];
		$bg_name=$bg_name[1];
		$bg_name=encoding((isset($_POST['tag']) ? $_POST['tag'] : ''));
		$bg_error = array(
			"Name:input:fill:30" => $bg_name
		);
		error_message(true, $bg_error);
		
		if(empty($_SESSION['error_message'])){
			foreach($bg_name as $bg_value){
				if($bg_value && (substr_count_array($bg_value,$bg_name) == 1)){
					$bg_tag=format_tag($bg_value);
					$select1 = $bg_connexion->prepare("SELECT COUNT(*) FROM  ".HASH."_container_tags WHERE tag = :bg_tag");
					$select1->bindParam(':bg_tag', $bg_tag);
					$select1->execute(); 
					$number_of_rows = $select1->fetchColumn();
					if($number_of_rows > 1){
						$bg_tag=substr(md5($bg_value.rand(0,10000000000)), 0, 6);
					}
					
					$query = $bg_connexion->prepare("INSERT INTO ".HASH."_container_tags(id_index, name, order1, published, sub_container, tag) VALUES(:id_index, :name, :order1, :published, :sub_container, :tag)");
					$query->execute(
						array(
						':id_index'=>$bg_id,
						':name'=>$bg_value,
						':order1'=> '0',
						':published'=> '1',
						':sub_container'=> '0',
						':tag'=>$bg_tag
						)
					);
				}
			}
		}
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit();
	}
	
	function tag_container ($bg_connexion) {
		$bg_id_module = (isset($_GET['id']) ? $_GET['id'] : '');
		$bg_id_tag=decoding((isset($_GET['id_tag']) ? $_GET['id_tag'] : ''));
		$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_container_tags WHERE id = :al_id_tag");
		$select1->bindParam(':al_id_tag', $bg_id_tag);
		$select1->execute();
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_container_tags = $select1->fetch();
		
		$select2=$bg_connexion->prepare("SELECT * FROM ".HASH."_container WHERE id_module = :al_id_module");
		$select2->bindParam(':al_id_module', $bg_id_module);
		$select2->execute();
		$select2->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_container = $select2->fetch();
		
		return render(array('bg_connexion' => $bg_connexion, 'bg_fetch_tag_container' => $bg_fetch_container_tags, 'bg_fetch_container' => $bg_fetch_container), 'containers', 'edit_tag');
	}
	
	function post_container_container ($bg_connexion) {
		$bg_id_container=(isset($_GET['id']) ? $_GET['id'] : '');
		$bg_title = encoding((isset($_POST['title']) ? $_POST['title'] : ''));
		$bg_id = encoding((isset($_POST['id']) ? $_POST['id'] : ''));
		$bg_date = encoding((isset($_POST['date']) ? $_POST['date'] : ''));
		$bg_date = ($bg_date == '') ? date('Y-m-d') : $bg_date;
		$bg_hour = encoding((isset($_POST['hour']) ? $_POST['hour'] : ''));
		$bg_hour = ($bg_hour == '') ? date('H:i:s') : $bg_hour;
		$bg_class = encoding((isset($_POST['class']) ? $_POST['class'] : ''));
		$bg_tag = encoding((isset($_POST['tag']) ? $_POST['tag'] : array()));
		$bg_order = encoding((isset($_POST['order']) ? $_POST['order'] : array()));
		$bg_tag = implode(":", $bg_tag);
		if (in_array("all", $bg_tag)) {
			$bg_tag="all";
		}
		$bg_show_title_class=encoding((isset($_POST['show_title_class']) ? $_POST['show_title_class'] : ''));
		$bg_prepare_module_content="{type_container{class{".
		$bg_show_title_class."}}}";
		$bg_error = array(
			"Title:input:fill:30" => $bg_title,
			"tag:input:fill:30" => $bg_tag
		);
		error_message(true, $bg_error);

		if (empty($_SESSION['error_message'])){
			
			$update_tag = $bg_connexion->prepare("UPDATE ".HASH."_modules SET modules=?, tag=?, class=?, date=?, time=?, title=? WHERE id=?");
			$update_tag->execute(
				array(
					$bg_prepare_module_content,
					$bg_tag,
					format_tag($bg_title),
					$bg_date,
					$bg_hour,
					$bg_title,
					$bg_id_container
				)
			);
			$update_tag = $bg_connexion->prepare("UPDATE ".HASH."_class SET class=? WHERE class=?");
			$update_tag->execute(array(format_tag($bg_title),$bg_class));
			
			foreach($bg_order as $key => $value){
				$update_tag = $bg_connexion->prepare("UPDATE ".HASH."_container_tags SET order1=? WHERE id=?");
				$update_tag->execute(array($value,$key));
			}
		}
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}
	
	function post_tag_container($bg_connexion){
		$bg_tag=encoding((isset($_POST['tag']) ? $_POST['tag'] : ''));
		foreach($bg_tag as $bg_key => $bg_value){				
			if($bg_value){
				$select1 = $bg_connexion->prepare("SELECT COUNT(*) FROM  ".HASH."_container_tags WHERE tag = :al_value");
				$select1->bindParam(':al_value', format_tag($bg_value));
				$select1->execute();
				$number_of_rows = $select1->fetchColumn();
				if($number_of_rows > 1){
					$tag_tag=substr(md5($bg_value.rand(0,10000000000)), 0, 6);
				}
				else {
					$tag_tag=format_tag($bg_value);
				}
				$update_tag = $bg_connexion->prepare("UPDATE ".HASH."_container_tags SET name=?,tag=? WHERE id=?");
				$update_tag->execute(array($bg_value,$tag_tag,$bg_key));
			}
		}
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit();
	}
	
	function post_name_container($bg_connexion){
		$bg_id_name=decoding((isset($_GET['id_name']) ? $_GET['id_name'] : ''));
		$bg_title=encoding((isset($_POST['title']) ? $_POST['title'] : ''));
		$bg_tag=encoding((isset($_POST['tag']) ? $_POST['tag'] : array()));
		$bg_error = array(
			"Title:input:fill:30" => $bg_title,
			"tag:input:fill:30" => $bg_tag
		);
		error_message(true, $bg_error);
		if(empty($_SESSION['error_message'])){
			$update_tag = $bg_connexion->prepare("UPDATE ".HASH."_container_tags SET id_index=? WHERE id_index=?");
			$update_tag->execute(array('0',$bg_id_name));
						
			foreach($bg_tag as $bg_key => $bg_value){
				$update_tag = $bg_connexion->prepare("UPDATE ".HASH."_container_tags SET id_index=? WHERE tag=?");
				$update_tag->execute(array($bg_id_name,$bg_value));
			}
			$update_tag = $bg_connexion->prepare("UPDATE ".HASH."_container SET name=? WHERE id=?");
			$update_tag->execute(array($bg_title,$bg_id_name));
		}
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit();
	}
	
	function name_tag_container ($bg_connexion) {
		$bg_id_name=decoding((isset($_GET['id_name']) ? $_GET['id_name'] : ''));
		$bg_id_module=decoding((isset($_GET['id_module']) ? $_GET['id_module'] : ''));
		$select1=$bg_connexion->prepare("SELECT * FROM  ".HASH."_container WHERE id = :al_id_name");
		$select1->bindParam(':al_id_name', $bg_id_name);
		$select1->execute();
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_container = $select1->fetch();
		
		return render(array('bg_connexion' => $bg_connexion, 'bg_fetch_container' => $bg_fetch_container, 'bg_id_module' => $bg_id_module), 'containers', 'container_pages');
	}
	
	function delete_tag_container ($bg_connexion) {
		$bg_id_tag=decoding((isset($_GET['id_tag']) ? $_GET['id_tag'] : ''));
		$bg_id_index=decoding((isset($_GET['id_index']) ? $_GET['id_index'] : ''));
		$select2=$bg_connexion->prepare("SELECT * FROM ".HASH."_container_tags WHERE id = :al_id_tag AND id_index = :al_id_index");
		$select2->bindParam(':al_id_index', $bg_id_index);
		$select2->bindParam(':al_id_tag', $bg_id_tag);
		$select2->execute();
		$select2->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_container_tags = $select2->fetch();
		$bg_container_item_name = $bg_fetch_container_tags->tag;
		$select1=$bg_connexion->prepare("DELETE FROM ".HASH."_container_tags WHERE id = :al_id_tag");
		$select1->bindParam(':al_id_tag', $bg_id_tag);
		$select1->execute();
		$select3=$bg_connexion->query("SELECT * FROM ".HASH."_modules WHERE tag LIKE '%".$bg_container_item_name."%'");
		$select3->setFetchMode(PDO::FETCH_OBJ);
		while($bg_fetch_module = $select3->fetch()){
			$tag_all = explode(':',$bg_fetch_module->tag);
			$bg_id_module = $bg_fetch_module->id;
			$full_module_tag=array();
			foreach($tag_all as $key => $value){
				if($value!=$bg_container_item_name){
					$full_module_tag[]=$value;
				}				
			}
			$full_tag=implode(':',$full_module_tag);
			$update_tag = $bg_connexion->prepare("UPDATE ".HASH."_modules SET tag=? WHERE id=?");
			$update_tag->execute(array($full_tag,$bg_id_module));
		}
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit();
	}	
?>