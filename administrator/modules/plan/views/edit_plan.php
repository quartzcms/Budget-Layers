<?php
	$bg_id=decoding($bg_fetch_modules->id);
	$bg_class=decoding($bg_fetch_modules->class);
	$bg_title=decoding($bg_fetch_modules->title);
	$bg_modules=decoding($bg_fetch_modules->modules);
	$bg_date=decoding($bg_fetch_modules->date);
	$bg_time=decoding($bg_fetch_modules->time);
	$bg_pay=$bg_fetch_plans->pay;
	$bg_tag_multiple=decoding(explode(':',$bg_fetch_modules->tag));
	$bg_tag_multiple2=decoding($bg_fetch_modules->tag);
?>
<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
    <h1>EDIT PLAN MODULE</h1>
    <form action="index.php?page=plan&action=post_update&id=<?php echo $bg_id; ?>" method="post" id="validator" role="form">
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
                        <td>Plan</td>
                    </tr>
                    <tr>
                        <td width="20%">Date created</td>
                        <td><input name="date" id="date" type="text" class="form-control" size="30" value="<?php echo $bg_date; ?>" /></td>
                    </tr>
                    <tr>
                        <td width="20%">Hour created</td>
                        <td><input name="hour" id="time" type="text" class="form-control" size="30" value="<?php echo $bg_time; ?>" /></td>
                    </tr>
					<?php 
					$bg_pay = json_decode($bg_pay, true);
					foreach($bg_pay as $key => $value){ ?>
					<tr class="pay_method">
						<td width="20%">Pay method <?php echo (intval($key) + 1); ?></td>
						<td>
							<input name="pay_amount[]" type="text" class="form-control" size="30" value="<?php echo $bg_pay[$key]['amount']; ?>" style="width: 50px; display:inline-block;" />
							<select class="chosen-select form-control" name="pay_frequence[]" style="width: 50px; display:inline-block;">
								<option value="daily" <?php if($bg_pay[$key]['frequence'] == 'daily'){ echo "selected='selected'"; } ?>>Daily</option>
								<option value="weekly" <?php if($bg_pay[$key]['frequence'] == 'weekly'){ echo "selected='selected'"; } ?>>Weekly</option>
								<option value="monthly" <?php if($bg_pay[$key]['frequence'] == 'monthly'){ echo "selected='selected'"; } ?>>Monthly</option>
								<option value="yearly" <?php if($bg_pay[$key]['frequence'] == 'yearly'){ echo "selected='selected'"; } ?>>Yearly</option>
							</select>
						</td>
					</tr>
					<?php } ?>
					<?php for($i=1; $i<3; $i++){ ?>
					<tr class="pay_method">
						<td width="20%">Pay method</td>
						<td>
							<input name="pay_amount[]" type="text" class="form-control" size="30" value="" style="width: 50px; display:inline-block;" />
							<select class="chosen-select form-control" name="pay_frequence[]" style="width: 50px; display:inline-block;">
								<option value="daily">Daily</option>
								<option value="weekly">Weekly</option>
								<option value="monthly">Monthly</option>
								<option value="yearly">Yearly</option>
							</select>
						</td>
					</tr>
					<?php } ?>
                    <tr>
                        <td width="20%">Restricted by Tags</td>
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
                    <td width="20%">Plan</td>
                    <td></td>
                </tr>
	<?php	
				if(preg_match('/plan\{(.*?)\}/',$bg_match2[1],$bg_match3)) {	
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