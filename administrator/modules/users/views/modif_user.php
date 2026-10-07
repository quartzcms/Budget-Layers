<?php 
	$bg_id=decoding($bg_fetch_users->id);
	$bg_username=decoding($bg_fetch_users->username);
	$bg_first_name=decoding($bg_fetch_users->first_name);
	$bg_last_name=decoding($bg_fetch_users->last_name);
	$bg_email=decoding($bg_fetch_users->email);
	$bg_gender=decoding($bg_fetch_users->gender);
	$bg_city=decoding($bg_fetch_users->city);
	$bg_age=decoding($bg_fetch_users->age);
	$bg_about=decoding($bg_fetch_users->about);
	$bg_country=decoding($bg_fetch_users->country);
?>
<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">Edit user profile</h1>
            </div>
            <div class="panel-body">
                <form action="index.php?page=update_user" method="post" id="validator" class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="user-username" class="col-sm-4 control-label">Username</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="user-username" name="username" value="<?php echo htmlspecialchars($bg_username, ENT_QUOTES, 'UTF-8'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="user-first-name" class="col-sm-4 control-label">First name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="user-first-name" name="first_name" value="<?php echo htmlspecialchars($bg_first_name, ENT_QUOTES, 'UTF-8'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="user-last-name" class="col-sm-4 control-label">Last name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="user-last-name" name="last_name" value="<?php echo htmlspecialchars($bg_last_name, ENT_QUOTES, 'UTF-8'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="user-email" class="col-sm-4 control-label">Email</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" id="user-email" name="email" value="<?php echo htmlspecialchars($bg_email, ENT_QUOTES, 'UTF-8'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="user-password" class="col-sm-4 control-label">Password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" id="user-password" name="password" autocomplete="new-password" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label id="user-gender-label" class="col-sm-4 control-label">Gender</label>
                                <div class="col-sm-8">
                                    <div class="btn-group radio-switch" data-toggle="buttons" role="group" aria-labelledby="user-gender-label">
                                        <label class="btn btn-default<?php if($bg_gender==1){ echo ' active'; } ?>">
                                            <input type="radio" id="user-gender-male" name="gender" value="1" autocomplete="off" <?php if($bg_gender==1){ ?>checked="checked"<?php } ?> /> Male
                                        </label>
                                        <label class="btn btn-default<?php if($bg_gender==0){ echo ' active'; } ?>">
                                            <input type="radio" id="user-gender-female" name="gender" value="0" autocomplete="off" <?php if($bg_gender==0){ ?>checked="checked"<?php } ?> /> Female
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="user-city" class="col-sm-4 control-label">City</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="user-city" name="city" value="<?php echo htmlspecialchars($bg_city, ENT_QUOTES, 'UTF-8'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="user-age" class="col-sm-4 control-label">Age</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="user-age" name="age" value="<?php echo htmlspecialchars($bg_age, ENT_QUOTES, 'UTF-8'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="user-country" class="col-sm-4 control-label">Country</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="user-country" name="country" value="<?php echo htmlspecialchars($bg_country, ENT_QUOTES, 'UTF-8'); ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user-about" class="col-sm-2 control-label">About</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="user-about" name="about" rows="5"><?php echo htmlspecialchars($bg_about, ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="update" value="<?php echo htmlspecialchars($bg_id, ENT_QUOTES, 'UTF-8'); ?>" />
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <a href="index.php?page=list_user" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>