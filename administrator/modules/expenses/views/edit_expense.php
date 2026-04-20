<?php
	$bg_id=decoding($bg_fetch_modules->id);
	$bg_class=decoding($bg_fetch_modules->class);
	$bg_title=decoding($bg_fetch_modules->title);
	$bg_modules=decoding($bg_fetch_modules->modules);
	$bg_date=decoding($bg_fetch_modules->date);
	$bg_time=decoding($bg_fetch_modules->time);
	$bg_tag_multiple=decoding(explode(':',$bg_fetch_modules->tag));
	$bg_tag_multiple2=decoding($bg_fetch_modules->tag);
?>
<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
    <h1>EDIT EXPENSE MODULE</h1>
    <form action="index.php?page=expense&action=post_update&id=<?php echo $bg_id; ?>" method="post" id="validator" role="form">
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
                        <td>Expense</td>
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
                        <td width="20%">Tags affected</td>
                        <td>
                        	<?php echo modify_tag($bg_connexion, $bg_tag_multiple); ?>
                        </td>
                	</tr>
                    <tr>
                    	<td width="20%">Id of the module</td>
                        <td><?php echo $bg_id_module ?></td>
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
                	<td width="20%">Class</td>
                    <td></td>
            	</tr>
	<?php
				if(preg_match('/class\{(.*?)\}/',$bg_match2[1],$bg_match3)) {
					$bg_options1 = explode(':',$bg_match3[1]);
	?>
					<tr>
                    	<td width="20%">Show Title Class</td>
                        <td>
                            <select class="chosen-select form-control" name="show_title_class">
                                <option value="show_title" <?php if($bg_options1[0] == 'show_title'){ ?>selected="selected"<?php } ?>>Show</option>
                                <option value="0" <?php if($bg_options1[0] == '0'){ ?>selected="selected"<?php } ?>>Hide</option>
                            </select>
                        </td>
					</tr>
	<?php
				}
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
                            <option value="show_title" <?php if($bg_options2[0] == 'show_title'){ ?>selected="selected"<?php } ?>>Show</option>
                            <option value="0" <?php if($bg_options2[0] == '0'){ ?>selected="selected"<?php } ?>>Hide</option>
                        </select>
					</td>
				</tr>
                <tr>
                	<td width="20%">Show description</td>
                    <td>
                        <select class="chosen-select form-control" name="show_description">
                            <option value="show_description" <?php if($bg_options2[1] == 'show_description'){ ?>selected="selected"<?php } ?>>Show</option>
                            <option value="0" <?php if($bg_options2[1] == '0'){ ?>selected="selected"<?php } ?>>Hide</option>
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