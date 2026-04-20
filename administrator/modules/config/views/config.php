<?php
	$bg_title=decoding($bg_fetch_config->title);
	$bg_emailadmin=decoding($bg_fetch_config->emailadmin);
	$bg_pause=decoding($bg_fetch_config->pause);
	if($bg_pause=='0'){$pause_enable='No';}else{$pause_enable='Yes';}
	include('../config.php');
?>
<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<h1>CONFIGURATION</h1>
<form action="index.php?page=post_configuration" method="post" id="validator" role="form">
    <p>To modifiy the MySQL configuration add write permission on the configuration file at the root of the site. (write permission are (755 : Best solution) or 775)</p>
    <table class="table-striped list">
        <tr>
            <td>Title</td>
            <td>Email of the admin</td>
            <td>Maintenance</td>
            <td>Editor</td>
        </tr>
        <tr>
            <td><input type="text" class="form-control" value="<?php echo $bg_title ?>" name="title" /></td>
            <td><input type="text" class="form-control" value="<?php echo $bg_emailadmin ?>" name="emailadmin" /></td>
            <td>
                Yes <input type="radio" value="1" name="pause" <?php if($bg_pause=='1'){ ?>checked="checked"<?php } ?> /> 
                No <input type="radio" value="0" name="pause" <?php if($bg_pause=='0'){ ?>checked="checked"<?php } ?> />
            </td>
            <td>
                <select class="chosen-select form-control" name="editor_config">
                    <option value="none">NONE</option>
                    <option value="ckeditor" <?php if($editor=='ckeditor'){ ?>selected="selected"<?php } ?>>CKeditor</option>
                </select>
            </td>
        </tr>
    </table>
    <h2>MySQL Informations</h2>
    <table class="table-striped list">
        <tr>
            <td>MySQL Host</td>
            <td>Database User</td>
            <td>Database Password</td>
            <td>Database Name</td>
        </tr>
        <tr>
            <td><input type="text" class="form-control" name="bg_host" value="<?php echo $bg_host ?>" /></td>
            <td><input type="text" class="form-control" name="bg_user" value="<?php echo $bg_user ?>" /></td>
            <td><input type="password" class="form-control" name="bg_password" value="" /></td>
            <td><input type="text" class="form-control" name="bg_db_name" value="<?php echo $bg_db_name ?>" /></td>
        </tr>
    </table>
	<table class="table-striped list">
		<tr>
			<td>Table Prefix</td>
		</tr>
		<tr>	
			<td><input type="text" class="form-control" name="bg_hash" value="<?php echo HASH ?>" /></td>
		</tr>
	</table>
    <input type="submit" class="btn btn-primary" value="Update" />
</form>