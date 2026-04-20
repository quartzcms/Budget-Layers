<?php
	$bg_title=decoding($bg_fetch_expenses->title);
	$bg_id=decoding($bg_fetch_expenses->id);
	$bg_username=decoding($bg_fetch_expenses->username);
	$bg_date=decoding($bg_fetch_expenses->date);
	$bg_time=decoding($bg_fetch_expenses->time);
	$bg_frequence=decoding($bg_fetch_expenses->frequence);
	$bg_class=decoding($bg_fetch_expenses->class);
	$bg_content=decoding_ck($bg_fetch_expenses->content);
	$bg_publish=decoding($bg_fetch_expenses->publish);
	$bg_cost=decoding($bg_fetch_expenses->cost);
	$bg_tag=decoding($bg_fetch_expenses->tag);
	$bg_modules=decoding($bg_fetch_expenses->modules);
	$bg_tag_multiple2=explode(':', decoding($bg_fetch_expenses->tag));
?>
<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>

<h1>MODIFY AN EXPENSE</h1>
<form action="index.php?page=modif_expense&action=modif&id_expense=<?php echo $bg_id; ?>" method="post" id="validator" role="form">
	<div class="row">
 	   	<div class="col-md-6">
            <input name="id_module" type="hidden" size="30" value="<?php echo $bg_id_module; ?>" />
            <table class="table-striped">
                <tr>
                    <td width="20%">Title</td>
                    <td><input name="title" type="text" class="form-control" size="30" value="<?php echo $bg_title; ?>" /></td>
                </tr>
                <tr>
                    <td width="20%">Username</td>
                    <td><?php echo $bg_username; ?></td>
                </tr>
				<tr>
                    <td width="20%">Cost</td>
                    <td><input name="cost" type="text" class="form-control" size="30" value="<?php echo $bg_cost; ?>" /></td>
                </tr>
				<tr>
					<td width="20%">Frequence</td>
					<td>
						<select class="chosen-select form-control" name="frequence">
							<option value="daily" <?php if($bg_frequence == 'daily'){ ?>selected="selected"<?php } ?>>Daily</option>
							<option value="weekly" <?php if($bg_frequence == 'weekly'){ ?>selected="selected"<?php } ?>>weekly</option>
							<option value="monthly" <?php if($bg_frequence == 'monthly'){ ?>selected="selected"<?php } ?>>Monthly</option>
							<option value="yearly" <?php if($bg_frequence == 'yearly'){ ?>selected="selected"<?php } ?>>Yearly</option>
						</select>
					</td>
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
                    <td width="20%">Class</td>
                    <td>
                		<select class="chosen-select form-control" name="class">
							<option value="0">NONE</option>
							<?php
                                $select2=$bg_connexion->query("SELECT * FROM ".HASH."_class");
                                $select2->setFetchMode(PDO::FETCH_OBJ);
                            
                                while($bg_fetch_class = $select2->fetch()){
                                    $bg_class_listing=$bg_fetch_class->class;
                                    if($bg_class==$bg_class_listing){ 
                            ?>
                                        <option value="<?php echo $bg_class_listing; ?>" selected="selected"><?php echo $bg_class_listing; ?></option>
                            <?php 
                                    } else { 
                            ?>
                                        <option value="<?php echo $bg_class_listing; ?>"><?php echo $bg_class_listing; ?></option>
                            <?php 
                                    } 
                                } 
                            ?>
						</select>
            		</td>
            	</tr>
                <tr>
                    <td width="20%">Publish</td>
                    <td>
                        <select class="chosen-select form-control" name="publish">
                            <option value="1" <?php if($bg_publish=='1'){ ?> selected="selected"<?php } ?>>published</option>
                            <option value="0" <?php if($bg_publish=='0'){ ?> selected="selected"<?php } ?>>unpublished</option>
                        </select>
                    </td>
                </tr>
				<tr>
                    <td width="20%">Tags affected</td>
                    <td>
                    	<?php echo modify_tag($bg_connexion, $bg_tag_multiple2); ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table-striped">
            <?php
                if(preg_match('/\{(.*?)\}$/', $bg_modules, $bg_match2)) {
            ?> 
                <tr>
                    <td width="20%">Expense</td>
                    <td></td>
                </tr>
            <?php
                    if(preg_match('/expense\{(.*?)\}/',$bg_match2[1],$bg_match3)) {	
                        $bg_options2 = explode(':',$bg_match3[1]);
            ?>
                <tr>
                    <td width="20%">Show title</td>
                    <td>
                        <select class="chosen-select form-control" name="show_title">
                            <option value="show_title" <?php if($bg_options2[0] == 'show_title'){ ?> selected="selected"<?php } ?>>Show</option>
                            <option value="0" <?php if($bg_options2[0] == '0'){ ?> selected="selected"<?php } ?>>Hide</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="20%">Show description</td>
                    <td>
                        <select class="chosen-select form-control" name="show_description">
                            <option value="show_description" <?php if($bg_options2[1] == 'show_description'){  ?>selected="selected"<?php } ?>>Show</option>
                            <option value="0" <?php if($bg_options2[1] == '0'){  ?>selected="selected" <?php } ?>>Hide</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="20%">Show username</td>
                    <td>
                        <select class="chosen-select form-control" name="show_username">
                            <option value="show_username" <?php if($bg_options2[2] == 'show_username'){ ?>selected="selected"<?php } ?>>Show</option>
                            <option value="0" <?php if($bg_options2[2] == '0'){ ?>selected="selected"<?php } ?>>Hide</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="20%">Show time</td>
                    <td>
                        <select class="chosen-select form-control" name="show_time">
                            <option value="show_time" <?php if($bg_options2[3] == 'show_time'){ ?>selected="selected"<?php } ?>>Show</option>
                            <option value="0" <?php if($bg_options2[3] == '0'){ ?>selected="selected"<?php } ?>>Hide</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="20%">Show Date</td>
                    <td>
                        <select class="chosen-select form-control" name="show_date">
                            <option value="show_date" <?php if($bg_options2[4] == 'show_date'){ ?>selected="selected"<?php } ?>>Show</option>
                            <option value="0" <?php if($bg_options2[4] == '0'){ ?>selected="selected"<?php } ?>>Hide</option>
                        </select>
                    </td>
                </tr>
            <?php 
                    }	
                }
            ?>
            </table>
            <textarea cols="80" id="editor" name="value" rows="10"><?php echo $bg_content; ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input type="submit" class="btn btn-primary" value="Modify" />
        </div>
    </div>
</form>