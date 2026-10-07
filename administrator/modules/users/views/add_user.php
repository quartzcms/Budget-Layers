<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h1 class="panel-title">Add user profile</h1></div>
            <div class="panel-body">
                <form action="index.php?page=update_user" method="post" id="validator" class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="new-user-username" class="col-sm-4 control-label">Username</label>
                                <div class="col-sm-8"><input type="text" class="form-control" id="new-user-username" name="username" value="<?php echo htmlspecialchars(isset($_SESSION['populate']['username']) ? $_SESSION['populate']['username'] : '', ENT_QUOTES, 'UTF-8'); ?>" /></div>
                            </div>
                            <div class="form-group">
                                <label for="new-user-first-name" class="col-sm-4 control-label">First name</label>
                                <div class="col-sm-8"><input type="text" class="form-control" id="new-user-first-name" name="first_name" value="<?php echo htmlspecialchars(isset($_SESSION['populate']['first_name']) ? $_SESSION['populate']['first_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" /></div>
                            </div>
                            <div class="form-group">
                                <label for="new-user-last-name" class="col-sm-4 control-label">Last name</label>
                                <div class="col-sm-8"><input type="text" class="form-control" id="new-user-last-name" name="last_name" value="<?php echo htmlspecialchars(isset($_SESSION['populate']['last_name']) ? $_SESSION['populate']['last_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" /></div>
                            </div>
                            <div class="form-group">
                                <label for="new-user-email" class="col-sm-4 control-label">Email</label>
                                <div class="col-sm-8"><input type="email" class="form-control" id="new-user-email" name="email" value="<?php echo htmlspecialchars(isset($_SESSION['populate']['email']) ? $_SESSION['populate']['email'] : '', ENT_QUOTES, 'UTF-8'); ?>" /></div>
                            </div>
                            <div class="form-group">
                                <label for="new-user-password" class="col-sm-4 control-label">Password</label>
                                <div class="col-sm-8"><input type="password" class="form-control" id="new-user-password" name="password" autocomplete="new-password" /></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label id="new-user-gender-label" class="col-sm-4 control-label">Gender</label>
                                <div class="col-sm-8">
                                    <div class="btn-group radio-switch" data-toggle="buttons" role="group" aria-labelledby="new-user-gender-label">
                                        <label class="btn btn-default"><input type="radio" name="gender" value="1" autocomplete="off" /> Male</label>
                                        <label class="btn btn-default"><input type="radio" name="gender" value="0" autocomplete="off" /> Female</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="new-user-city" class="col-sm-4 control-label">City</label>
                                <div class="col-sm-8"><input type="text" class="form-control" id="new-user-city" name="city" value="<?php echo htmlspecialchars(isset($_SESSION['populate']['city']) ? $_SESSION['populate']['city'] : '', ENT_QUOTES, 'UTF-8'); ?>" /></div>
                            </div>
                            <div class="form-group">
                                <label for="new-user-age" class="col-sm-4 control-label">Age</label>
                                <div class="col-sm-8"><input type="text" class="form-control" id="new-user-age" name="age" value="<?php echo htmlspecialchars(isset($_SESSION['populate']['age']) ? $_SESSION['populate']['age'] : '', ENT_QUOTES, 'UTF-8'); ?>" /></div>
                            </div>
                            <div class="form-group">
                                <label for="new-user-country" class="col-sm-4 control-label">Country</label>
                                <div class="col-sm-8"><input type="text" class="form-control" id="new-user-country" name="country" value="<?php echo htmlspecialchars(isset($_SESSION['populate']['country']) ? $_SESSION['populate']['country'] : '', ENT_QUOTES, 'UTF-8'); ?>" /></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new-user-about" class="col-sm-2 control-label">About</label>
                        <div class="col-sm-10"><textarea class="form-control" id="new-user-about" name="about" rows="5"><?php echo htmlspecialchars(isset($_SESSION['populate']['about']) ? $_SESSION['populate']['about'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10"><button type="submit" class="btn btn-primary">Add user</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>