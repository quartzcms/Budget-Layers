<?php

function add_tag ($bg_connexion){
	$content = '<ul>';
	$content .= '<li><input type="checkbox" id="select_all" /> Check all/Uncheck all</li>';
	$select2=$bg_connexion->query("SELECT * FROM ".HASH."_container");
	$select2->setFetchMode(PDO::FETCH_OBJ);
	while($bg_fetch_container = $select2->fetch()){ 
		$bg_id=decoding($bg_fetch_container->id);
		$bg_name=decoding($bg_fetch_container->name);
		$content .= '<li style="float:left; margin:20px;">'. $bg_name;
		$content .= '<ul style="padding:0px; margin:0px; list-style-type:none;">';	
		$select3=$bg_connexion->query("SELECT * FROM ".HASH."_container_tags WHERE id_index='".$bg_id."'");
		$select3->setFetchMode(PDO::FETCH_OBJ);
	
		while($bg_fetch_container_tags = $select3->fetch()){
			$bg_name=decoding($bg_fetch_container_tags->name);
			$bg_tag_unique=decoding($bg_fetch_container_tags->tag);
			$content .= '<li><input type="checkbox" name="tag[]" value="'.$bg_tag_unique.'"> '.$bg_name.'</li>';
		}
		$content .= '</ul>';
		$content .= '</li>';    	
	}
	$content .= '</ul>';
	return $content;
}

function modify_tag ($bg_connexion, $bg_tag_multiple2){
	$content = '<ul>';
	$content .= '<li><input type="checkbox" id="select_all" /> Check all/Uncheck all</li>';
	$select2=$bg_connexion->query("SELECT * FROM ".HASH."_container");
	$select2->setFetchMode(PDO::FETCH_OBJ);
	while($bg_fetch_container = $select2->fetch()){ 
		$bg_id=decoding($bg_fetch_container->id);
		$bg_name=decoding($bg_fetch_container->name);
		$content .= '<li style="float:left; margin:20px;">'. $bg_name;
		$content .= '<ul style="padding:0px; margin:0px; list-style-type:none;">';	
		$select3=$bg_connexion->query("SELECT * FROM ".HASH."_container_tags WHERE id_index='".$bg_id."'");
		$select3->setFetchMode(PDO::FETCH_OBJ);
	
		while($bg_fetch_container_tags = $select3->fetch()){
			$bg_name=decoding($bg_fetch_container_tags->name);
			$bg_tag_unique=decoding($bg_fetch_container_tags->tag);
			if(in_array($bg_tag_unique, $bg_tag_multiple2)){
				$content .= '<li><input type="checkbox" name="tag[]" value="'.$bg_tag_unique.'" checked="checked"> '.$bg_name.'</li>';
			} else {
				$content .= '<li><input type="checkbox" name="tag[]" value="'.$bg_tag_unique.'"> '.$bg_name.'</li>';
			}
		}
		$content .= '</ul>';
		$content .= '</li>';    	
	}
	$content .= '</ul>';
	return $content;
}

?>