<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<h1>ADD TAG</h1>
<form action="index.php?page=add_tag&action=post" method="post" id="validator" role="form">
    <table class="table-striped">
        <tr>
            <td width="20%">Container</td>
            <td>
                <select class="chosen-select form-control" name="name">	
            <?php	
                $select1=$bg_connexion->query("SELECT * FROM ".HASH."_container");
                $select1->setFetchMode(PDO::FETCH_OBJ);
                while($bg_fetch_container = $select1->fetch()){
                    $bg_name=decoding($bg_fetch_container->name);
                    $bg_id=decoding($bg_fetch_container->id);
			?>
                    <option value="<?php echo $bg_id ?>-<?php echo $bg_name ?>"><?php echo $bg_name ?></option>
            <?php
                }
			?>
                </select>
            </td>
        </tr>
        <tr>
            <td width="20%">New Tags</td>
            <td>
                <input type="text" class="form-control" name="tag[]" value="" size="30" /> <br />
                <input type="text" class="form-control" name="tag[]" value="" size="30" /> <br />
                <input type="text" class="form-control" name="tag[]" value="" size="30" /> <br />
                <input type="text" class="form-control" name="tag[]" value="" size="30" /> <br />
                <input type="text" class="form-control" name="tag[]" value="" size="30" /> <br />
                <input type="text" class="form-control" name="tag[]" value="" size="30" /> <br />
            </td>
        </tr>
        <tr>
            <td width="20%"><input type="submit" class="btn btn-primary" name="post" value="Modify" /></td>
            <td></td>
        </tr>
    </table>
</form>