<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<h1>ADD A PLUGIN</h1>
<div class="list">
	<p>Please make sure that before installing a plugin the modules folders have (755 : Best solution) or 775 permission and that the cache folder have 775 permission.</p>
</div>
<form action="index.php?page=plugins&action=upload" method="post" enctype="multipart/form-data" id="validator" role="form">
    <input type="file" name="upload" id="file">
    <input type="submit" class="btn btn-primary" name="post" value="Upload" />
</form>