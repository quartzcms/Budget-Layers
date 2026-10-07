<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h1 class="panel-title">Add a plugin</h1></div>
            <div class="panel-body">
                <div class="alert alert-info" role="note">Make sure the modules folder has 755 or 775 permissions and the cache folder has 775 permissions before installing a plugin.</div>
                <form action="index.php?page=plugins&action=upload" method="post" enctype="multipart/form-data" id="validator" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="plugin-upload" class="col-sm-3 control-label">Plugin archive</label>
                        <div class="col-sm-9"><input type="file" class="form-control" name="upload" id="plugin-upload" /></div>
                    </div>
                    <div class="form-group"><div class="col-sm-offset-3 col-sm-9"><button type="submit" class="btn btn-primary" name="post" value="Upload">Upload plugin</button></div></div>
                </form>
            </div>
        </div>
    </div>
</div>