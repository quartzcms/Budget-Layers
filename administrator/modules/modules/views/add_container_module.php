<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h1 class="panel-title">Add container module</h1></div>
            <div class="panel-body">
                <form action="index.php?page=addmodule&action=post_container" method="post" id="validator" class="form-horizontal" role="form">
                    <h2 class="h4 text-muted">Module details</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group"><label for="module-title" class="col-sm-4 control-label">Title</label><div class="col-sm-8"><input name="title" id="module-title" type="text" class="form-control" value="<?php echo htmlspecialchars(isset($_SESSION['populate']['title']) ? $_SESSION['populate']['title'] : '', ENT_QUOTES, 'UTF-8'); ?>" /></div></div>
                            <div class="form-group"><label class="col-sm-4 control-label">Type</label><div class="col-sm-8"><p class="form-control-static">Container</p></div></div>
                            <div class="form-group"><label for="date" class="col-sm-4 control-label">Date</label><div class="col-sm-8"><input name="date" id="date" type="text" class="form-control" value="<?php echo htmlspecialchars(isset($_SESSION['populate']['date']) ? $_SESSION['populate']['date'] : '', ENT_QUOTES, 'UTF-8'); ?>" /></div></div>
                            <div class="form-group"><label for="time" class="col-sm-4 control-label">Time</label><div class="col-sm-8"><input name="hour" id="time" type="text" class="form-control" value="<?php echo htmlspecialchars(isset($_SESSION['populate']['hour']) ? $_SESSION['populate']['hour'] : '', ENT_QUOTES, 'UTF-8'); ?>" /></div></div>
                            <div class="form-group"><label for="module-container-name" class="col-sm-4 control-label">Container name</label><div class="col-sm-8"><input name="name" id="module-container-name" type="text" class="form-control" value="<?php echo htmlspecialchars(isset($_SESSION['populate']['name']) ? $_SESSION['populate']['name'] : '', ENT_QUOTES, 'UTF-8'); ?>" /></div></div>
                            <div class="form-group"><label for="module-show-class" class="col-sm-4 control-label">Show title class</label><div class="col-sm-8"><select class="chosen-select form-control" id="module-show-class" name="show_title_class"><option value="show_title">Show</option><option value="0">Hide</option></select></div></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label class="col-sm-4 control-label">Tags</label><div class="col-sm-8"><div class="tag-selector"><?php echo add_tag($bg_connexion); ?></div></div></div>
                        </div>
                    </div>
                    <div class="form-group"><div class="col-sm-offset-2 col-sm-10"><button type="submit" class="btn btn-primary" name="post" value="Add">Add module</button></div></div>
                </form>
            </div>
        </div>
    </div>
</div>