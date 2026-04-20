<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<h1>CONTROL PANEL</h1>
<div class="cpanel">
    <div class="row">
    	<div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">
                	<h3 class="panel-title">Modules</h3>
                </div>
                <div class="panel-body" align="center">
                	<a href="index.php"><span class="glyphicon glyphicon-th"></span></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">
                	<h3 class="panel-title">Expenses</h3>
                </div>
                <div class="panel-body" align="center">
                	<a href="index.php?page=list_expense"><span class="glyphicon glyphicon-fire"></span></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">
                	<h3 class="panel-title">Users</h3>
                </div>
                <div class="panel-body" align="center">
                	<a href="index.php?page=list_user"><span class="glyphicon glyphicon-user"></span></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">
                	<h3 class="panel-title">Containers</h3>
                </div>
                <div class="panel-body" align="center">
                	<a href="index.php?page=container_list"><span class="glyphicon glyphicon-tags"></span></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">
                	<h3 class="panel-title">Configuration</h3>
                </div>
                <div class="panel-body" align="center">
                	<a href="index.php?page=configuration"><span class="glyphicon glyphicon-cog"></span></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">
                	<h3 class="panel-title">Plugins</h3>
                </div>
                <div class="panel-body" align="center">
                	<a href="index.php?page=plugins"><span class="glyphicon glyphicon-wrench"></span></a>
                </div>
            </div>
        </div>
    </div>
    <p class="footer">Version 1.0 - Budget-Layers</p>
</div>