<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">Add tags</h1>
            </div>
            <div class="panel-body">
                <form action="index.php?page=add_tag&action=post" method="post" id="validator" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="tag-container" class="col-sm-3 control-label">Container</label>
                        <div class="col-sm-9">
                            <select class="chosen-select form-control" id="tag-container" name="name">
                                <?php
                                    $select1=$bg_connexion->query("SELECT * FROM ".HASH."_container");
                                    $select1->setFetchMode(PDO::FETCH_OBJ);
                                    while($bg_fetch_container = $select1->fetch()){
                                        $bg_name=decoding($bg_fetch_container->name);
                                        $bg_id=decoding($bg_fetch_container->id);
                                ?>
                                    <option value="<?php echo htmlspecialchars($bg_id.'-'.$bg_name, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($bg_name, ENT_QUOTES, 'UTF-8'); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">New tags</label>
                        <div class="col-sm-9">
                            <div class="row-fluid">
                                <?php for($tag_slot = 1; $tag_slot <= 6; $tag_slot++) { ?>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label class="sr-only" for="new-tag-<?php echo $tag_slot; ?>">Tag <?php echo $tag_slot; ?></label>
                                            <input type="text" class="form-control" id="new-tag-<?php echo $tag_slot; ?>" name="tag[]" />
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-primary" name="post" value="Modify">Add tags</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>