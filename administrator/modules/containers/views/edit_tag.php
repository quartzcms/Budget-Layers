<?php 
	$bg_id=decoding($bg_fetch_tag_container->id);
	$bg_modules=decoding($bg_fetch_tag_container->tag);
	$bg_id_container=decoding($bg_fetch_container->id);
	$bg_name=decoding($bg_fetch_container->name);
?>
<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h1 class="panel-title">Edit container tags</h1></div>
            <div class="panel-body">
                <form action="index.php?page=container&action=post_tag&id_tag=<?php echo $bg_id ?>" method="post" id="validator" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Container</label>
                        <div class="col-sm-9"><p class="form-control-static"><?php echo htmlspecialchars($bg_name, ENT_QUOTES, 'UTF-8'); ?></p></div>
                    </div>
                    <h2 class="h4 text-muted">Tags in this container</h2>
                    <?php
                        $select3=$bg_connexion->query("SELECT * FROM ".HASH."_container_tags WHERE id_index='$bg_id_container'");
                        $select3->setFetchMode(PDO::FETCH_OBJ);
                        while($bg_fetch_tag_container = $select3->fetch()){
                            $bg_name=decoding($bg_fetch_tag_container->name);
                            $bg_id=decoding($bg_fetch_tag_container->id);
                            $bg_tag_unique=decoding($bg_fetch_tag_container->tag);
                    ?>
                        <div class="form-group">
                            <label for="tag-alias-<?php echo $bg_id; ?>" class="col-sm-3 control-label">Alias</label>
                            <div class="col-sm-3"><input id="tag-alias-<?php echo $bg_id; ?>" name="tag_alias[<?php echo $bg_id ?>]" type="text" class="form-control" value="<?php echo htmlspecialchars($bg_tag_unique, ENT_QUOTES, 'UTF-8'); ?>" disabled="disabled" /></div>
                            <label for="tag-name-<?php echo $bg_id; ?>" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-4"><input id="tag-name-<?php echo $bg_id; ?>" name="tag[<?php echo $bg_id ?>]" type="text" class="form-control" value="<?php echo htmlspecialchars($bg_name, ENT_QUOTES, 'UTF-8'); ?>" /></div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9"><button type="submit" class="btn btn-primary" name="post" value="Modify">Save tags</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>