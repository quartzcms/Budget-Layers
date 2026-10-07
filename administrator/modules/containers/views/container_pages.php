<?php
	$bg_id=decoding($bg_fetch_container->id);
	$bg_name=decoding($bg_fetch_container->name);
	$bg_type_module=decoding($bg_fetch_container->id_module);
?>
<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h1 class="panel-title">Container tags</h1></div>
            <div class="panel-body">
                <form action="index.php?page=container&action=post_name&id_name=<?php echo $bg_id ?>" method="post" id="validator" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="container-title" class="col-sm-3 control-label">Container</label>
                        <div class="col-sm-9"><input name="title" id="container-title" type="text" class="form-control" value="<?php echo htmlspecialchars($bg_name, ENT_QUOTES, 'UTF-8'); ?>" /></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3"><h2 class="h4 text-muted">Tags in this container</h2></div>
                        <div class="col-sm-9">
			   <?php 
                    $select2=$bg_connexion->prepare("SELECT * FROM ".HASH."_container WHERE id_module = :al_id_module");
                    $select2->bindParam(':al_id_module', $bg_id_module);
                    $select2->execute();
                    $select2->setFetchMode(PDO::FETCH_OBJ);
                    $bg_fetch_container = $select2->fetch();
                    $bg_id_container=decoding($bg_fetch_container->id);
                    $select3=$bg_connexion->query("SELECT * FROM ".HASH."_container_tags WHERE id_index='$bg_id_container' OR id_index=''");
                    $select3->setFetchMode(PDO::FETCH_OBJ);
                    while($bg_fetch_tag_container = $select3->fetch()){
                        $bg_name=decoding($bg_fetch_tag_container->name);
                        $bg_id_index=decoding($bg_fetch_tag_container->id_index);
                        $bg_tag_unique=decoding($bg_fetch_tag_container->tag);
                        if($bg_id_index == $bg_id_container){
                ?>
                            <p><label class="checkbox-inline"><input type="checkbox" name="tag[]" value="<?php echo htmlspecialchars($bg_tag_unique, ENT_QUOTES, 'UTF-8'); ?>" checked="checked" /> Alias: <?php echo htmlspecialchars($bg_tag_unique, ENT_QUOTES, 'UTF-8'); ?></label></p>
                <?php
                        } else {
                ?>
                            <p><label class="checkbox-inline"><input type="checkbox" name="tag[]" value="<?php echo htmlspecialchars($bg_tag_unique, ENT_QUOTES, 'UTF-8'); ?>" /> Alias: <?php echo htmlspecialchars($bg_tag_unique, ENT_QUOTES, 'UTF-8'); ?></label></p>
                <?php
                        }
                    }
                ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9"><button type="submit" class="btn btn-primary" name="post" value="Modify">Save tags</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>