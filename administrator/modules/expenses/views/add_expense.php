<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">Add expense</h1>
            </div>
            <div class="panel-body">
                <form action="index.php?page=add_expense&action=post" method="post" id="validator" class="form-horizontal add-expense-form" role="form">
                    <h2 class="h4 text-muted">Expense details</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="expense-title" class="col-sm-4 control-label">Title</label>
                                <div class="col-sm-8">
                                    <input name="title" id="expense-title" type="text" class="form-control" value="<?php echo htmlspecialchars(isset($_SESSION['populate']['title']) ? $_SESSION['populate']['title'] : '', ENT_QUOTES, 'UTF-8'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="date" class="col-sm-4 control-label">Date</label>
                                <div class="col-sm-8">
                                    <input name="date" id="date" type="text" class="form-control" value="<?php echo htmlspecialchars(isset($_SESSION['populate']['date']) ? $_SESSION['populate']['date'] : '', ENT_QUOTES, 'UTF-8'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="time" class="col-sm-4 control-label">Time</label>
                                <div class="col-sm-8">
                                    <input name="hour" id="time" type="text" class="form-control" value="<?php echo htmlspecialchars(isset($_SESSION['populate']['hour']) ? $_SESSION['populate']['hour'] : '', ENT_QUOTES, 'UTF-8'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="expense-cost" class="col-sm-4 control-label">Cost</label>
                                <div class="col-sm-8">
                                    <input name="cost" id="expense-cost" type="number" step="any" class="form-control" value="<?php echo htmlspecialchars(isset($_SESSION['populate']['cost']) ? $_SESSION['populate']['cost'] : '', ENT_QUOTES, 'UTF-8'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="expense-frequency" class="col-sm-4 control-label">Frequency</label>
                                <div class="col-sm-8">
                                    <select class="chosen-select form-control" id="expense-frequency" name="frequence">
                                        <option value="daily">Daily</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly">Monthly</option>
                                        <option value="yearly">Yearly</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="expense-class" class="col-sm-4 control-label">Attach to module</label>
                                <div class="col-sm-8">
                                    <select class="chosen-select form-control" id="expense-class" name="class">
                                        <option value="">None</option>
                                        <?php
                                            $select2=$bg_connexion->query("SELECT * FROM ".HASH."_class");
                                            $select2->setFetchMode(PDO::FETCH_OBJ);
                                            while($bg_fetch_class = $select2->fetch()){
                                                $bg_class_listing = $bg_fetch_class->class;
                                        ?>
                                            <option value="<?php echo htmlspecialchars($bg_class_listing, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($bg_class_listing, ENT_QUOTES, 'UTF-8'); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="expense-publish" class="col-sm-4 control-label">Status</label>
                                <div class="col-sm-8">
                                    <select class="chosen-select form-control" id="expense-publish" name="publish">
                                        <option value="1">Published</option>
                                        <option value="0">Unpublished</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Container tags</label>
                                <div class="col-sm-8">
                                    <p class="help-block">Choose tags when this expense is not attached to a module.</p>
                                    <div class="tag-selector"><?php echo add_tag($bg_connexion); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2 class="h4 text-muted">Display options</h2>
                    <div class="row">
                        <?php
                            $display_options = array(
                                'show_title' => 'Title',
                                'show_description' => 'Description',
                                'show_username' => 'Username',
                                'show_time' => 'Time',
                                'show_date' => 'Date'
                            );
                            foreach($display_options as $option_name => $option_label) {
                        ?>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="expense-<?php echo $option_name; ?>" class="col-sm-5 control-label">Show <?php echo $option_label; ?></label>
                                    <div class="col-sm-7">
                                        <select class="chosen-select form-control" id="expense-<?php echo $option_name; ?>" name="<?php echo $option_name; ?>">
                                            <option value="<?php echo $option_name; ?>">Show</option>
                                            <option value="0">Hide</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="form-group"><label for="editor" class="col-sm-2 control-label">Description</label><div class="col-sm-10"><textarea class="form-control" id="editor" name="value" rows="8"></textarea></div></div>
                    <div class="form-group"><div class="col-sm-offset-2 col-sm-10"><button type="submit" class="btn btn-primary">Add expense</button></div></div>
                </form>
            </div>
        </div>
    </div>
</div>
