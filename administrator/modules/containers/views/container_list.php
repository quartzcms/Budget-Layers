<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><h1 class="panel-title">Containers</h1></div>
			<div class="panel-body container-list">
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
					<div class="list-group">
						<a class="list-group-item" href="index.php?page=container&action=name_tag&id=<?php echo urlencode($bg_id); ?>&id_name=<?php echo urlencode($bg_id_container); ?>&id_module=<?php echo urlencode($bg_id_module); ?>">
							<strong><?php echo htmlspecialchars($bg_name, ENT_QUOTES, 'UTF-8'); ?></strong>
							<span class="pull-right" style="margin-top: -5px;">Manage tags <span class="glyphicon glyphicon-chevron-right"></span></span>
						</a>
						<?php
							$select3=$bg_connexion->query("SELECT * FROM ".HASH."_container_tags WHERE id_index='".$bg_id_container."'");
							$select3->setFetchMode(PDO::FETCH_OBJ);
							while($bg_fetch_tag_container = $select3->fetch()){
								$bg_tag_name=decoding($bg_fetch_tag_container->name);
								$bg_id_tag=decoding($bg_fetch_tag_container->id);
						?>
							<div class="list-group-item">
								<a href="index.php?page=container&action=tag&id=<?php echo urlencode($bg_id); ?>&id_tag=<?php echo urlencode($bg_id_tag); ?>"><?php echo htmlspecialchars($bg_tag_name, ENT_QUOTES, 'UTF-8'); ?></a>
								<a class="pull-right" style="margin-top: -5px;" href="index.php?page=container&action=delete_tag&id_tag=<?php echo urlencode($bg_id_tag); ?>" aria-label="Delete tag"><span class="glyphicon glyphicon-remove"></span></a>
							</div>
						<?php } ?>
					</div>
				<?php
							}
						}
					}
				?>
			</div>
		</div>
	</div>
</div>