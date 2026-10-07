<?php if(isset($_SESSION['pseudom'])){ ?>
	<p>Welcome <?php echo $_SESSION['pseudom'] ?></p>
	<p><a href="index.php?page=disconnect">Disconnect</a></p>
	<p><a href="/administrator">Administration</a></p>
<?php } else { ?>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading"><h1 class="panel-title">Sign in</h1></div>
				<div class="panel-body">
					<form name="form1" method="post" action="index.php?page=verif_login" id="validator" class="form-horizontal" role="form">
						<div class="form-group">
							<label for="login-username" class="col-sm-12 control-label">Username</label>
							<div class="col-sm-12"><input type="text" class="form-control" id="login-username" name="username" autocomplete="username" /></div>
						</div>
						<div class="form-group">
							<label for="login-password" class="col-sm-12 control-label">Password</label>
							<div class="col-sm-12"><input type="password" class="form-control" id="login-password" name="password" autocomplete="current-password" /></div>
						</div>
						<div class="form-group"><div class="col-sm-12"><button type="submit" class="btn btn-primary" name="Submit" value="Connection">Sign in</button></div></div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php } ?>