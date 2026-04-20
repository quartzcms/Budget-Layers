<?php if(isset($_SESSION['pseudom'])){ ?>
	<p>Welcome <?php echo $_SESSION['pseudom'] ?></p>
	<p><a href="index.php?page=disconnect">Disconnect</a></p>
	<p><a href="/administrator">Administration</a></p>
<?php } else { ?>
	<form name="form1" id="connexion" method="post" action="index.php?page=verif_login" id="validator" role="form">
		<h1>Connection</h1>
		<p>Username : <input type="text" class="form-control"  name="username" size="15" /></p> 
		<p>Password : <input type="password" class="form-control" name="password" size="15" /></p> 
		<input type="submit" class="btn btn-primary" name="Submit" value="Connection" />
	</form>
<?php } ?>