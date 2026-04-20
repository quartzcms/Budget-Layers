<?php 
	$bg_id=decoding($bg_fetch_tag_container->id);
	$bg_modules=decoding($bg_fetch_tag_container->tag);
	$bg_id_container=decoding($bg_fetch_container->id);
	$bg_name=decoding($bg_fetch_container->name);
?>
<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<h1>EDIT CONTAINER TAGS</h1>
<form action="index.php?page=container&action=post_tag&id_tag=<?php echo $bg_id ?>" method="post" id="validator" role="form">
    <table class="table-striped">
        <tr>
            <td width="20%">Container</td>
            <td><?php echo $bg_name ?></td>
        </tr>
        <tr>
            <td width="20%">Tags in the container</td>
            <td>
                <div class="row">
                	<div class="col-md-3">
                        <h4>Alias</h4>
                    </div>
                    <div class="col-md-9">
                        <h4>Name</h4>
                    </div>
				</div>
                <div class="row">
					<?php 		
                        $select3=$bg_connexion->query("SELECT * FROM ".HASH."_container_tags WHERE id_index='$bg_id_container'");
                        $select3->setFetchMode(PDO::FETCH_OBJ);
                        while($bg_fetch_tag_container = $select3->fetch()){
                            $bg_name=decoding($bg_fetch_tag_container->name);
                            $bg_id_index=decoding($bg_fetch_tag_container->id_index);
                            $bg_id=decoding($bg_fetch_tag_container->id);
                            $bg_tag_unique=decoding($bg_fetch_tag_container->tag);
                    ?>
                        <div class="col-md-3">
                            <p><input name="tag_alias[<?php echo $bg_id ?>]" type="text" class="form-control" size="30" value="<?php echo $bg_tag_unique ?>" disabled="disabled" /></p>
                        </div>
                        <div class="col-md-9">
                            <p><input name="tag[<?php echo $bg_id ?>]" type="text" class="form-control" size="30" value="<?php echo $bg_name ?>" /></p>
                        </div>
                	<?php
						}
					?>
				</div>
        	</td>
        </tr>
		<tr>
        	<td width="20%"><input type="submit" class="btn btn-primary" name="post" value="Modify" /></td>
            <td></td>
        </tr>
	</table>
</form>