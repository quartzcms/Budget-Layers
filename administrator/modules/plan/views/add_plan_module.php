<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h1 class="panel-title">Add plan module</h1></div>
            <div class="panel-body">
                <form action="index.php?page=addmodule&action=post_plan" method="post" id="validator" class="form-horizontal" role="form">
                    <h2 class="h4 text-muted">Module details</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group"><label for="plan-title" class="col-sm-4 control-label">Title</label><div class="col-sm-8"><input name="title" id="plan-title" type="text" class="form-control" value="<?php echo htmlspecialchars(isset($_SESSION['populate']['title']) ? $_SESSION['populate']['title'] : '', ENT_QUOTES, 'UTF-8'); ?>" /></div></div>
                            <div class="form-group"><label class="col-sm-4 control-label">Type</label><div class="col-sm-8"><p class="form-control-static">Plan</p></div></div>
                            <div class="form-group"><label for="date" class="col-sm-4 control-label">Date</label><div class="col-sm-8"><input name="date" id="date" type="text" class="form-control" value="<?php echo htmlspecialchars(isset($_SESSION['populate']['date']) ? $_SESSION['populate']['date'] : '', ENT_QUOTES, 'UTF-8'); ?>" /></div></div>
                            <div class="form-group"><label for="time" class="col-sm-4 control-label">Time</label><div class="col-sm-8"><input name="hour" id="time" type="text" class="form-control" value="<?php echo htmlspecialchars(isset($_SESSION['populate']['hour']) ? $_SESSION['populate']['hour'] : '', ENT_QUOTES, 'UTF-8'); ?>" /></div></div>
                            <h3 class="h4 text-muted">Payment schedule</h3>
                            <?php for($i=1; $i<6; $i++){ ?>
                                <div class="form-group">
                                    <label for="plan-pay-amount-<?php echo $i; ?>" class="col-sm-4 control-label">Pay method <?php echo $i; ?></label>
                                    <div class="col-sm-4"><input name="pay_amount[]" id="plan-pay-amount-<?php echo $i; ?>" type="number" step="any" class="form-control" value="<?php echo htmlspecialchars(isset($_SESSION['populate']['pay_amount'][$i - 1]) ? $_SESSION['populate']['pay_amount'][$i - 1] : '', ENT_QUOTES, 'UTF-8'); ?>" /></div>
                                    <div class="col-sm-4">
                                        <select class="chosen-select form-control" name="pay_frequence[]">
                                            <?php foreach(array('daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly', 'yearly' => 'Yearly') as $frequency_value => $frequency_label) { ?>
                                                <option value="<?php echo $frequency_value; ?>" <?php if(isset($_SESSION['populate']['pay_frequence'][$i - 1]) && $_SESSION['populate']['pay_frequence'][$i - 1] == $frequency_value){ echo 'selected="selected"'; } ?>><?php echo $frequency_label; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label class="col-sm-5 control-label">Restricted tags</label><div class="col-sm-7"><div class="tag-selector"><?php echo add_tag($bg_connexion); ?></div></div></div>
                            <h3 class="h4 text-muted">Display options</h3>
                            <div class="form-group"><label for="plan-show-title-class" class="col-sm-5 control-label">Show title class</label><div class="col-sm-7"><select class="chosen-select form-control" id="plan-show-title-class" name="show_title_class"><option value="show_title">Show</option><option value="0">Hide</option></select></div></div>
                            <?php
                                $display_options = array('show_title' => 'Title', 'show_description' => 'Description', 'show_username' => 'Username', 'show_time' => 'Time', 'show_date' => 'Date');
                                foreach($display_options as $option_name => $option_label) {
                            ?>
                                <div class="form-group"><label for="plan-<?php echo $option_name; ?>" class="col-sm-5 control-label">Show <?php echo $option_label; ?></label><div class="col-sm-7"><select class="chosen-select form-control" id="plan-<?php echo $option_name; ?>" name="<?php echo $option_name; ?>"><option value="<?php echo $option_name; ?>">Show</option><option value="0">Hide</option></select></div></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group"><div class="col-sm-offset-2 col-sm-10"><button type="submit" class="btn btn-primary" name="post" value="Add">Add plan</button></div></div>
                </form>
            </div>
        </div>
    </div>
</div>