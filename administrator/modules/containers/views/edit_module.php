<?php
    $bg_id=$bg_fetch_modules->id;
    $bg_class=decoding($bg_fetch_modules->class);
    $bg_modules=decoding($bg_fetch_modules->modules);
    $bg_title=decoding($bg_fetch_modules->title);
    $bg_date=decoding($bg_fetch_modules->date);
    $bg_time=decoding($bg_fetch_modules->time);
    $bg_tag_multiple=decoding(explode(':',$bg_fetch_modules->tag));
    $bg_options2 = array();
    if(preg_match('/\{(.*?)\}$/', $bg_modules, $bg_match) && preg_match('/\{(.*?)\}$/', $bg_match[1], $bg_match2) && preg_match('/class\{(.*?)\}/', $bg_match2[1], $bg_match3)) {
        $bg_options2 = explode(':', $bg_match3[1]);
    }
?>
<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h1 class="panel-title">Edit container module</h1></div>
            <div class="panel-body container-module-editor">
                <form action="index.php?page=container&action=post_container&id=<?php echo $bg_id; ?>" method="post" id="validator" class="form-horizontal" role="form">
                    <input name="class" type="hidden" value="<?php echo htmlspecialchars($bg_class, ENT_QUOTES, 'UTF-8'); ?>" />
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($bg_id, ENT_QUOTES, 'UTF-8'); ?>" />
                    <div class="row">
                        <div class="col-sm-6">
                            <h2 class="h4 text-muted">Module details</h2>
                            <div class="form-group">
                                <label for="container-module-title" class="col-sm-4 control-label">Title</label>
                                <div class="col-sm-8"><input name="title" id="container-module-title" type="text" class="form-control" value="<?php echo htmlspecialchars($bg_title, ENT_QUOTES, 'UTF-8'); ?>" /></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Type</label>
                                <div class="col-sm-8"><p class="form-control-static">Container</p></div>
                            </div>
                            <div class="form-group">
                                <label for="date" class="col-sm-4 control-label">Date created</label>
                                <div class="col-sm-8"><input name="date" id="date" type="text" class="form-control" value="<?php echo htmlspecialchars($bg_date, ENT_QUOTES, 'UTF-8'); ?>" /></div>
                            </div>
                            <div class="form-group">
                                <label for="time" class="col-sm-4 control-label">Time created</label>
                                <div class="col-sm-8"><input name="hour" id="time" type="text" class="form-control" value="<?php echo htmlspecialchars($bg_time, ENT_QUOTES, 'UTF-8'); ?>" /></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Module ID</label>
                                <div class="col-sm-8"><p class="form-control-static"><?php echo htmlspecialchars($bg_id_module, ENT_QUOTES, 'UTF-8'); ?></p></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Tags affected</label>
                                <div class="col-sm-8"><div class="tag-selector"><?php echo modify_tag($bg_connexion, $bg_tag_multiple); ?></div></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <h2 class="h4 text-muted">Container tags</h2>
                            <?php
                                $select2=$bg_connexion->prepare("SELECT * FROM ".HASH."_container WHERE id_module = :al_id_module");
                                $select2->bindParam(':al_id_module', $bg_id_module);
                                $select2->execute();
                                $select2->setFetchMode(PDO::FETCH_OBJ);
                                while($bg_fetch_container = $select2->fetch()){
                                    $bg_name=decoding($bg_fetch_container->name);
                                    $bg_id_container=decoding($bg_fetch_container->id);
                            ?>
                                <div class="well well-sm">
                                    <p><a href="index.php?page=container&action=name_tag&id=<?php echo urlencode($bg_id); ?>&id_name=<?php echo urlencode($bg_id_container); ?>&id_module=<?php echo urlencode($bg_id_module); ?>"><?php echo htmlspecialchars($bg_name, ENT_QUOTES, 'UTF-8'); ?></a></p>
                                    <?php
                                        $select3=$bg_connexion->query("SELECT * FROM ".HASH."_container_tags WHERE id_index='".$bg_id_container."'");
                                        $select3->setFetchMode(PDO::FETCH_OBJ);
                                        while($bg_fetch_tag_container = $select3->fetch()){
                                            $bg_tag_name=decoding($bg_fetch_tag_container->name);
                                            $bg_id_tag=decoding($bg_fetch_tag_container->id);
                                            $bg_order1=decoding($bg_fetch_tag_container->order1);
                                    ?>
                                        <div class="row">
                                            <div class="col-sm-6"><a href="index.php?page=container&action=tag&id=<?php echo urlencode($bg_id); ?>&id_tag=<?php echo urlencode($bg_id_tag); ?>"><?php echo htmlspecialchars($bg_tag_name, ENT_QUOTES, 'UTF-8'); ?></a></div>
                                            <div class="col-sm-4"><label class="sr-only" for="tag-order-<?php echo $bg_id_tag; ?>">Tag order</label><input type="number" class="form-control input-sm" id="tag-order-<?php echo $bg_id_tag; ?>" name="order[<?php echo $bg_id_tag; ?>]" value="<?php echo htmlspecialchars($bg_order1, ENT_QUOTES, 'UTF-8'); ?>" /></div>
                                            <div class="col-sm-2"><a href="index.php?page=container&action=delete_tag&id_tag=<?php echo urlencode($bg_id_tag); ?>" aria-label="Delete tag"><span class="glyphicon glyphicon-remove"></span></a></div>
                                            <div class="col-sm-12"><hr ></div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if(!empty($bg_options2)) { ?>
                        <h2 class="h4 text-muted">Display options</h2>
                        <div class="form-group">
                            <label for="show-title-class" class="col-sm-2 control-label">Show title</label>
                            <div class="col-sm-4"><select class="chosen-select form-control" id="show-title-class" name="show_title_class"><option value="show_title" <?php if($bg_options2[0] == 'show_title'){ ?>selected="selected"<?php } ?>>Show</option><option value="0" <?php if($bg_options2[0] == '0'){ ?>selected="selected"<?php } ?>>Hide</option></select></div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" name="post" value="Modify">Save module</button>
                            <a href="index.php?page=container_list" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>