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
<form action="index.php?page=update_user" method="post" id="validator" role="form">
    <table class="table-striped">
        <tr>
            <td width="20%">Username</td>
            <td><input type="text" class="form-control" name="username" value="<?php echo $bg_username ?>" /></td>
        </tr>
        <tr>
            <td width="20%">First name</td>
            <td><input type="text" class="form-control" name="first_name" value="<?php echo $bg_first_name ?>" /></td>
        </tr>
        <tr>
            <td width="20%">Last name</td>
            <td><input type="text" class="form-control" name="last_name" value="<?php echo $bg_last_name ?>" /></td>
        </tr>
        <tr>
            <td width="20%">Password</td>
            <td><input type="password" class="form-control" name="password" /></td>
        </tr>
        <tr>
            <td width="20%">Email</td>
            <td><input type="text" class="form-control" name="email" value="<?php echo $bg_email ?>" /></td>
        </tr>
        <tr>
            <td width="20%">Gender</td>
            <td>
                Male : <input type="radio" name="gender" value="1" <?php if($bg_gender==1){ ?>checked="checked"<?php } ?> /> 
                Female : <input type="radio" name="gender" value="0" <?php if($bg_gender==0){ ?>checked="checked"<?php } ?> />
            </td>
        </tr>
        <tr>
            <td width="20%">City</td>
            <td><input type="text" class="form-control" name="city" value="<?php echo $bg_city ?>" /></td>
        </tr>
        <tr>
            <td width="20%">Age</td>
            <td><input type="text" class="form-control" name="age" value="<?php echo $bg_age ?>" /></td>
        </tr>
        <tr>
            <td width="20%">About</td>
            <td><textarea name="about"><?php echo $bg_about ?></textarea></td>
        </tr>
        <tr>
            <td width="20%">Country</td>
            <td><input type="text" class="form-control" name="country" value="<?php echo $bg_country ?>" /></td>
        </tr>
    </table>
    <input type="hidden" name="update" value="<?php echo $bg_id ?>" />
    <input type="submit" class="btn btn-primary" value="Modify" />
</form>