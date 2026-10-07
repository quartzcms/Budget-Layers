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
	$bg_options2 = array();
	if(preg_match('/\{(.*?)\}$/', $bg_modules, $bg_match2) && preg_match('/expense\{(.*?)\}/', $bg_match2[1], $bg_match3)) {
		$bg_options2 = explode(':', $bg_match3[1]);
	}
?>
<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h1 class="panel-title">Modify an expense</h1></div>
            <div class="panel-body">
                <form action="index.php?page=modif_expense&action=modif&id_expense=<?php echo $bg_id; ?>" method="post" id="validator" class="form-horizontal" role="form">
                    <input type="hidden" name="id_module" value="<?php echo htmlspecialchars($bg_id_module, ENT_QUOTES, 'UTF-8'); ?>" />
                    <h2 class="h4 text-muted">Expense details</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group"><label for="expense-title" class="col-sm-4 control-label">Title</label><div class="col-sm-8"><input name="title" id="expense-title" type="text" class="form-control" value="<?php echo htmlspecialchars($bg_title, ENT_QUOTES, 'UTF-8'); ?>" /></div></div>
                            <div class="form-group"><label class="col-sm-4 control-label">Username</label><div class="col-sm-8"><p class="form-control-static"><?php echo htmlspecialchars($bg_username, ENT_QUOTES, 'UTF-8'); ?></p></div></div>
                            <div class="form-group"><label for="expense-cost" class="col-sm-4 control-label">Cost</label><div class="col-sm-8"><input name="cost" id="expense-cost" type="number" step="any" class="form-control" value="<?php echo htmlspecialchars($bg_cost, ENT_QUOTES, 'UTF-8'); ?>" /></div></div>
                            <div class="form-group"><label for="expense-frequency" class="col-sm-4 control-label">Frequency</label><div class="col-sm-8"><select class="chosen-select form-control" id="expense-frequency" name="frequence"><?php foreach(array('daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly', 'yearly' => 'Yearly') as $frequency_value => $frequency_label) { ?><option value="<?php echo $frequency_value; ?>" <?php if($bg_frequence == $frequency_value){ ?>selected="selected"<?php } ?>><?php echo $frequency_label; ?></option><?php } ?></select></div></div>
                            <div class="form-group"><label for="date" class="col-sm-4 control-label">Date</label><div class="col-sm-8"><input name="date" id="date" type="text" class="form-control" value="<?php echo htmlspecialchars($bg_date, ENT_QUOTES, 'UTF-8'); ?>" /></div></div>
                            <div class="form-group"><label for="time" class="col-sm-4 control-label">Time</label><div class="col-sm-8"><input name="hour" id="time" type="text" class="form-control" value="<?php echo htmlspecialchars($bg_time, ENT_QUOTES, 'UTF-8'); ?>" /></div></div>
                            <div class="form-group"><label for="expense-class" class="col-sm-4 control-label">Class</label><div class="col-sm-8"><select class="chosen-select form-control" id="expense-class" name="class"><option value="0">None</option><?php $select2=$bg_connexion->query("SELECT * FROM ".HASH."_class"); $select2->setFetchMode(PDO::FETCH_OBJ); while($bg_fetch_class = $select2->fetch()){ $bg_class_listing=$bg_fetch_class->class; ?><option value="<?php echo htmlspecialchars($bg_class_listing, ENT_QUOTES, 'UTF-8'); ?>" <?php if($bg_class==$bg_class_listing){ ?>selected="selected"<?php } ?>><?php echo htmlspecialchars($bg_class_listing, ENT_QUOTES, 'UTF-8'); ?></option><?php } ?></select></div></div>
                            <div class="form-group"><label for="expense-publish" class="col-sm-4 control-label">Status</label><div class="col-sm-8"><select class="chosen-select form-control" id="expense-publish" name="publish"><option value="1" <?php if($bg_publish=='1'){ ?>selected="selected"<?php } ?>>Published</option><option value="0" <?php if($bg_publish=='0'){ ?>selected="selected"<?php } ?>>Unpublished</option></select></div></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label class="col-sm-5 control-label">Tags</label><div class="col-sm-7"><div class="tag-selector"><?php echo modify_tag($bg_connexion, $bg_tag_multiple2); ?></div></div></div>
                            <?php if(!empty($bg_options2)) {
                                $display_options = array('show_title' => 0, 'show_description' => 1, 'show_username' => 2, 'show_time' => 3, 'show_date' => 4);
                            ?>
                                <h3 class="h4 text-muted">Display options</h3>
                                <?php foreach($display_options as $option_name => $option_index) { $option_label = ucwords(str_replace('show_', '', $option_name)); ?>
                                    <div class="form-group"><label for="expense-<?php echo $option_name; ?>" class="col-sm-5 control-label">Show <?php echo $option_label; ?></label><div class="col-sm-7"><select class="chosen-select form-control" id="expense-<?php echo $option_name; ?>" name="<?php echo $option_name; ?>"><option value="<?php echo $option_name; ?>" <?php if(isset($bg_options2[$option_index]) && $bg_options2[$option_index] == $option_name){ ?>selected="selected"<?php } ?>>Show</option><option value="0" <?php if(isset($bg_options2[$option_index]) && $bg_options2[$option_index] == '0'){ ?>selected="selected"<?php } ?>>Hide</option></select></div></div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group"><label for="editor" class="col-sm-2 control-label">Description</label><div class="col-sm-10"><textarea class="form-control" id="editor" name="value" rows="8"><?php echo $bg_content; ?></textarea></div></div>
                    <div class="form-group"><div class="col-sm-offset-2 col-sm-10"><button type="submit" class="btn btn-primary">Save expense</button></div></div>
                </form>
            </div>
        </div>
    </div>
</div>