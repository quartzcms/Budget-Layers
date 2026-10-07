<?php
	$bg_id=decoding($bg_fetch_modules->id);
	$bg_class=decoding($bg_fetch_modules->class);
	$bg_title=decoding($bg_fetch_modules->title);
	$bg_modules=decoding($bg_fetch_modules->modules);
	$bg_date=decoding($bg_fetch_modules->date);
	$bg_time=decoding($bg_fetch_modules->time);
	$bg_tag_multiple=decoding(explode(':',$bg_fetch_modules->tag));
	$bg_tag_multiple2=decoding($bg_fetch_modules->tag);
    $bg_options1 = array();
    $bg_options2 = array();
    if(preg_match('/\{(.*?)\}$/', $bg_modules, $bg_match) && preg_match('/\{(.*?)\}$/', $bg_match[1], $bg_match2)) {
    	if(preg_match('/class\{(.*?)\}/', $bg_match2[1], $bg_match3)) { $bg_options1 = explode(':', $bg_match3[1]); }
    	if(preg_match('/expense\{(.*?)\}/', $bg_match2[1], $bg_match3)) { $bg_options2 = explode(':', $bg_match3[1]); }
    }
?>
<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h1 class="panel-title">Edit expense module</h1></div>
            <div class="panel-body">
                    <form action="index.php?page=expense&action=post_update&id=<?php echo $bg_id; ?>" method="post" id="validator" class="form-horizontal" role="form">
                        <input name="class" type="hidden" value="<?php echo htmlspecialchars($bg_class, ENT_QUOTES, 'UTF-8'); ?>" />
                        <h2 class="h4 text-muted">Module details</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label for="expense-module-title" class="col-sm-4 control-label">Title</label><div class="col-sm-8"><input name="title" id="expense-module-title" type="text" class="form-control" value="<?php echo htmlspecialchars($bg_title, ENT_QUOTES, 'UTF-8'); ?>" /></div></div>
                                <div class="form-group"><label class="col-sm-4 control-label">Type</label><div class="col-sm-8"><p class="form-control-static">Expense</p></div></div>
                                <div class="form-group"><label for="date" class="col-sm-4 control-label">Date</label><div class="col-sm-8"><input name="date" id="date" type="text" class="form-control" value="<?php echo htmlspecialchars($bg_date, ENT_QUOTES, 'UTF-8'); ?>" /></div></div>
                                <div class="form-group"><label for="time" class="col-sm-4 control-label">Time</label><div class="col-sm-8"><input name="hour" id="time" type="text" class="form-control" value="<?php echo htmlspecialchars($bg_time, ENT_QUOTES, 'UTF-8'); ?>" /></div></div>
                                <div class="form-group"><label class="col-sm-4 control-label">Module ID</label><div class="col-sm-8"><p class="form-control-static"><?php echo htmlspecialchars($bg_id_module, ENT_QUOTES, 'UTF-8'); ?></p></div></div>
                                <div class="form-group"><label class="col-sm-4 control-label">Tags affected</label><div class="col-sm-8"><div class="tag-selector"><?php echo modify_tag($bg_connexion, $bg_tag_multiple); ?></div></div></div>
                            </div>
                            <div class="col-md-6">
                                <?php if(!empty($bg_options1)) { ?>
                                    <h3 class="h4 text-muted">Class options</h3>
                                    <div class="form-group"><label for="expense-show-title-class" class="col-sm-5 control-label">Show title class</label><div class="col-sm-7"><select class="chosen-select form-control" id="expense-show-title-class" name="show_title_class"><option value="show_title" <?php if($bg_options1[0] == 'show_title'){ ?>selected="selected"<?php } ?>>Show</option><option value="0" <?php if($bg_options1[0] == '0'){ ?>selected="selected"<?php } ?>>Hide</option></select></div></div>
                                <?php } ?>
                                <?php if(!empty($bg_options2)) {
                                    $display_options = array('show_title' => 0, 'show_description' => 1, 'show_username' => 2, 'show_time' => 3, 'show_date' => 4);
                                ?>
                                    <h3 class="h4 text-muted">Expense display</h3>
                                    <?php foreach($display_options as $option_name => $option_index) { $option_label = ucwords(str_replace('show_', '', $option_name)); ?>
                                        <div class="form-group"><label for="expense-module-<?php echo $option_name; ?>" class="col-sm-5 control-label">Show <?php echo $option_label; ?></label><div class="col-sm-7"><select class="chosen-select form-control" id="expense-module-<?php echo $option_name; ?>" name="<?php echo $option_name; ?>"><option value="<?php echo $option_name; ?>" <?php if(isset($bg_options2[$option_index]) && $bg_options2[$option_index] == $option_name){ ?>selected="selected"<?php } ?>>Show</option><option value="0" <?php if(isset($bg_options2[$option_index]) && $bg_options2[$option_index] == '0'){ ?>selected="selected"<?php } ?>>Hide</option></select></div></div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group"><div class="col-sm-offset-2 col-sm-10"><button type="submit" class="btn btn-primary" name="post" value="Modify">Save module</button></div></div>
                    </form>
            </div>
        </div>
    </div>
</div>