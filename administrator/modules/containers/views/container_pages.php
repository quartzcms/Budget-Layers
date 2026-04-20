<?php
	$bg_id=decoding($bg_fetch_container->id);
	$bg_name=decoding($bg_fetch_container->name);
	$bg_type_module=decoding($bg_fetch_container->id_module);
?>
<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<h1>CHOOSE TAGS OF CONTAINER</h1>
<form action="index.php?page=container&action=post_name&id_name=<?php echo $bg_id ?>" method="post" id="validator" role="form">
	<table class="table-striped">
		<tr>
            <td width="20%">Container</td>
            <td><input name="title" type="text" class="form-control" size="30" value="<?php echo $bg_name ?>" /></td>
        </tr>
		<tr>
        	<td width="20%">Tags in the container</td>
            <td>
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
                            <p><input type="checkbox" name="tag[]" value="<?php echo $bg_tag_unique ?>" checked="checked" /> Alias : <?php echo $bg_tag_unique ?></p>
                <?php
                        } else {
                ?>
                            <p><input type="checkbox" name="tag[]" value="<?php echo $bg_tag_unique ?>" /> Alias : <?php echo $bg_tag_unique ?></p>
                <?php
                        }
                    }
                ?>
			</td>
        </tr>
        <tr>
            <td width="20%"><input type="submit" class="btn btn-primary" name="post" value="Modify" /></td>
            <td></td>
        </tr>
    </table>
</form>