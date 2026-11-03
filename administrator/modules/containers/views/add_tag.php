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
                            <div id="tag-fields">
                                <div class="input-group tag-field" style="margin-bottom:10px;">
                                    <input type="text" class="form-control" name="tag[]" placeholder="Tag name" aria-label="Tag name" />
                                    <span class="input-group-btn"><button type="button" class="btn btn-default remove-tag-field" aria-label="Remove tag" style="display:none; margin-top: 0px !important;"><span class="glyphicon glyphicon-remove" style="font-size:10px;"></span></button></span>
                                </div>
                            </div>
                            <a href="#" id="add-tag-field" style="color:#000;"><span class="glyphicon glyphicon-plus" style="font-size:10px;"></span> Add another tag</a>
                        </div>
                    </div>
                    <script type="text/javascript">
                    $(function () {
                        var $fields = $('#tag-fields');
                        function toggleRemove() {
                            $fields.find('.remove-tag-field').toggle($fields.children('.tag-field').length > 1);
                        }
                        $('#add-tag-field').on('click', function (e) {
                            e.preventDefault();
                            var $new = $fields.children('.tag-field').first().clone();
                            $new.find('input').val('');
                            $fields.append($new);
                            toggleRemove();
                            $new.find('input').focus();
                        });
                        $fields.on('click', '.remove-tag-field', function () {
                            $(this).closest('.tag-field').remove();
                            toggleRemove();
                        });
                    });
                    </script>
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