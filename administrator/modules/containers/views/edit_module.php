<?php
	$bg_id=$bg_fetch_modules->id;
	$bg_class=decoding($bg_fetch_modules->class);
	$bg_modules=decoding($bg_fetch_modules->modules);
	$bg_title=decoding($bg_fetch_modules->title);
	$bg_date=decoding($bg_fetch_modules->date);
	$bg_time=decoding($bg_fetch_modules->time);
	$bg_tag_multiple=decoding(explode(':',$bg_fetch_modules->tag));
	$bg_tag_multiple2=decoding($bg_fetch_modules->tag);
?>
<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<h1>EDIT CONTAINER MODULE</h1>
<form action="index.php?page=container&action=post_container&id=<?php echo $bg_id; ?>" method="post" id="validator" role="form">
    <div class="row">
        <div class="col-md-6">
            <input name="class" type="hidden" size="30" value="<?php echo $bg_class; ?>" />
            <table class="table-striped">
                <tr>
                    <td width="20%">Title</td>
                    <td><input name="title" type="text" class="form-control" size="30" value="<?php echo $bg_title; ?>" /></td>
                </tr>
                <tr>
                    <td width="20%">Type of module</td>
                    <td>Container</td>
                </tr>		
                <tr>
                    <td width="20%">Date created</td>
                    <td><input name="date" id="date" type="text" class="form-control" size="30" value="<?php echo $bg_date; ?>" /></td>
                </tr>
                <tr>
                    <td width="20%">Hour created</td>
                    <td><input name="hour" id="time" type="text" class="form-control" size="30" value="<?php echo $bg_time; ?>" /></td>
                </tr>
                <tr>
                	<td width="20%">Tags of the container</td>
                    <td>
                    	<ul>
						<?php
                            $select2=$bg_connexion->prepare("SELECT * FROM ".HASH."_container WHERE id_module = :al_id_module");
                            $select2->bindParam(':al_id_module', $bg_id_module);
                            $select2->execute();
                            $select2->setFetchMode(PDO::FETCH_OBJ);
    
                            while($bg_fetch_container = $select2->fetch()){
                                $bg_name=decoding($bg_fetch_container->name);
                                $bg_id_container=decoding($bg_fetch_container->id);
                        ?>		
                            <li><a href="index.php?page=container&action=name_tag&id=<?php echo $bg_id ?>&id_name=<?php echo $bg_id_container ?>&id_module=<?php echo $bg_id_module ?>"><?php echo $bg_name ?></a>
                                <ul>
                                    <?php
                                        $select3=$bg_connexion->query("SELECT * FROM ".HASH."_container_tags WHERE id_index='".$bg_id_container."'");
                                        $select3->setFetchMode(PDO::FETCH_OBJ);
                                                    
                                        while($bg_fetch_tag_container = $select3->fetch()){
                                            $bg_name=decoding($bg_fetch_tag_container->name);
                                            $bg_tag_unique=decoding($bg_fetch_tag_container->tag);
                                            $bg_id_tag=decoding($bg_fetch_tag_container->id);
                                            $bg_order1=decoding($bg_fetch_tag_container->order1);
                                    ?>
                                        <li>
                                            <a href="index.php?page=container&action=tag&id=<?php echo $bg_id ?>&id_tag=<?php echo $bg_id_tag ?>"><?php echo $bg_name ?></a> 
                                            # <input type="text" class="form-control" name="order[<?php echo $bg_id_tag ?>]" value="<?php echo $bg_order1 ?>" />
											<a href="index.php?page=container&action=delete_tag&id_tag=<?php echo $bg_id_tag ?>" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a> 
                                        </li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                            </li>
						<?php 
                            } 
                        ?>
						</ul>
					</td>
				</tr>
                <tr>
                    <td width="20%">Tags affected</td>
                    <td>
                        <?php echo modify_tag($bg_connexion, $bg_tag_multiple); ?>
                    </td>
                </tr>
                <tr>
                    <td width="20%">Id of the module</td>
                    <td><?php echo $bg_id_module ?><input type="hidden" name="id" value="<?php echo $bg_id ?>" /></td>
                </tr>
			</table>
		</div>
		<div class="col-md-6">
			<table class="table-striped">
		<?php 
				if(preg_match('/\{(.*?)\}$/', $bg_modules, $bg_match)) { 
					if(preg_match('/\{(.*?)\}$/',$bg_match[1],$bg_match2)) {
		?>
				<tr>
                	<td width="20%"><h3>Class</h3></td>
                    <td></td>
                </tr>
		<?php	
				if(preg_match('/class\{(.*?)\}/',$bg_match2[1],$bg_match3)) {	
					$bg_options2 = explode(':',$bg_match3[1]);
		?>
            	<tr>
                	<td width="20%">Show title</td>
                    <td>
                        <select class="chosen-select form-control" name="show_title_class">
                            <option value="show_title" <?php if($bg_options2[0] == 'show_title'){ ?>selected="selected"<?php } ?>>Show</option>
                            <option value="0" <?php if($bg_options2[0] == '0'){ ?>selected="selected"<?php } ?>>Hide</option>
                        </select>
					</td>
				</tr>
		<?php
                }
            }
        }
        ?>
			</table>
		</div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input type="submit" class="btn btn-primary" name="post" value="Modify" />
        </div>
    </div>
</form>