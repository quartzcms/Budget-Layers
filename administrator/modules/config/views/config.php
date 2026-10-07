<?php
	$bg_title=decoding($bg_fetch_config->title);
	$bg_emailadmin=decoding($bg_fetch_config->emailadmin);
	$bg_pause=decoding($bg_fetch_config->pause);
	if($bg_pause=='0'){$pause_enable='No';}else{$pause_enable='Yes';}
	include('../config.php');
?>
<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">Configuration</h1>
            </div>
            <div class="panel-body">
                <form action="index.php?page=post_configuration" method="post" id="validator" class="form-horizontal" role="form">
                    <div class="alert alert-info" role="note">
                        Database connection settings are saved in the site configuration file. The file must be writable to update them.
                    </div>
                    <h2 class="h4 text-muted">Site settings</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="config-title" class="col-sm-4 control-label">Site title</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="config-title" name="title" value="<?php echo htmlspecialchars($bg_title, ENT_QUOTES, 'UTF-8'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="config-email" class="col-sm-4 control-label">Admin email</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" id="config-email" name="emailadmin" value="<?php echo htmlspecialchars($bg_emailadmin, ENT_QUOTES, 'UTF-8'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="config-maintenance-label" class="col-sm-4 control-label">Maintenance</label>
                                <div class="col-sm-8">
                                    <div class="btn-group radio-switch" data-toggle="buttons" role="group" aria-labelledby="config-maintenance-label">
                                        <label class="btn btn-default<?php if($bg_pause=='1'){ echo ' active'; } ?>">
                                            <input type="radio" value="1" name="pause" autocomplete="off" <?php if($bg_pause=='1'){ ?>checked="checked"<?php } ?> /> Yes
                                        </label>
                                        <label class="btn btn-default<?php if($bg_pause=='0'){ echo ' active'; } ?>">
                                            <input type="radio" value="0" name="pause" autocomplete="off" <?php if($bg_pause=='0'){ ?>checked="checked"<?php } ?> /> No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="config-editor" class="col-sm-4 control-label">Editor</label>
                                <div class="col-sm-8">
                                    <select class="chosen-select form-control" id="config-editor" name="editor_config">
                                        <option value="none">None</option>
                                        <option value="ckeditor" <?php if($editor=='ckeditor'){ ?>selected="selected"<?php } ?>>CKEditor</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2 class="h4 text-muted">Database connection</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="config-db-host" class="col-sm-4 control-label">MySQL host</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="config-db-host" name="bg_host" value="<?php echo htmlspecialchars($bg_host, ENT_QUOTES, 'UTF-8'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="config-db-user" class="col-sm-4 control-label">Database user</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="config-db-user" name="bg_user" value="<?php echo htmlspecialchars($bg_user, ENT_QUOTES, 'UTF-8'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="config-db-name" class="col-sm-4 control-label">Database name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="config-db-name" name="bg_db_name" value="<?php echo htmlspecialchars($bg_db_name, ENT_QUOTES, 'UTF-8'); ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="config-db-password" class="col-sm-4 control-label">Database password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" id="config-db-password" name="bg_password" value="" autocomplete="new-password" />
                                    <span class="help-block">Leave blank to keep the current password.</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="config-table-prefix" class="col-sm-4 control-label">Table prefix</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="config-table-prefix" name="bg_hash" value="<?php echo htmlspecialchars(HASH, ENT_QUOTES, 'UTF-8'); ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Save configuration</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>