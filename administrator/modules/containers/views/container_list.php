<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<h1>CONTAINER LIST</h1>
	<div class="row">
    <?php
		$select1=$bg_connexion->query("SELECT * FROM ".HASH."_modules WHERE modules LIKE '%type_container%'");
		$select1->setFetchMode(PDO::FETCH_OBJ);
		while($bg_fetch_modules = $select1->fetch()){
			$bg_id=$bg_fetch_modules->id;
			$bg_id_module=$bg_fetch_modules->id;
			$bg_title=$bg_fetch_modules->title;
			if($bg_title != "hidden"){
				$select2=$bg_connexion->query("SELECT * FROM ".HASH."_container WHERE id_module='$bg_id'");
				$select2->setFetchMode(PDO::FETCH_OBJ);
				while($bg_fetch_container = $select2->fetch()){
					$bg_name=decoding($bg_fetch_container->name);
					$bg_id_container=decoding($bg_fetch_container->id);
	 ?>
		<div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
        			<h3 style="padding: 0px; margin: 0px; text-align:center;"><a href="index.php?page=container&action=name_tag&id=<?php echo $bg_id; ?>&id_name=<?php echo $bg_id_container; ?>&id_module=<?php echo $bg_id_module; ?>"><?php echo $bg_name; ?></a></h3>
            	</div>
                <div class="panel-body">	
     <?php 	
					$select3=$bg_connexion->query("SELECT * FROM ".HASH."_container_tags WHERE id_index='".$bg_id_container."'");
					$select3->setFetchMode(PDO::FETCH_OBJ);			
					while($bg_fetch_tag_container = $select3->fetch()){
						$bg_name=decoding($bg_fetch_tag_container->name);
						$bg_tag_unique=decoding($bg_fetch_tag_container->tag);
						$bg_id_tag=decoding($bg_fetch_tag_container->id);
	?>
                        <p>
                            <a href="index.php?page=container&action=tag&id=<?php echo $bg_id; ?>&id_tag=<?php echo $bg_id_tag; ?>"><?php echo $bg_name; ?></a> 
                            <a href="index.php?page=container&action=delete_tag&id_tag=<?php echo $bg_id_tag; ?>"><span class="glyphicon glyphicon-remove"></span></a>
                        </p>
    <?php		
					}
	?>
            	</div>
            </div>
		</div>
	<?php
				}			
			}
		}
	?>
</div>