<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<h1>MODULES</h1>
<div class="row">
	<div class="col-md-2">
        <form action="index.php" method="post" id="validator" role="form">
            <div class="panel panel-default listing-sidebar">
                <div class="panel-heading"><h2 class="panel-title">Filter modules</h2></div>
                <div class="panel-body">
                <p>
                    Keyword: <br />
                    <input type="text" class="form-control" size="12" value="<?php echo (isset($_SESSION['populate']['search_module']) ? $_SESSION['populate']['search_module'] : '') ?>" name="search_module" />
                </p>
                <p>
                    Class: <br />
                    <select class="chosen-select form-control" name="class_module">
                        <option value=""></option>
                        <option value="DESC" <?php if(isset($_SESSION['populate']['class_module']) && $_SESSION['populate']['class_module']=="DESC"){ ?>selected="selected"<?php } ?>>Descending</option>
                        <option value="ASC" <?php if(isset($_SESSION['populate']['class_module']) && $_SESSION['populate']['class_module']=="ASC"){ ?>selected="selected"<?php } ?>>Ascending</option>
                    </select>
                </p>
                <p>
                    Type: <br />
                    <select class="chosen-select form-control" name="type_module">
                        <option value=""></option>
                        <option value="type_container" <?php if(isset($_SESSION['populate']['type_module']) && $_SESSION['populate']['type_module']=="type_container"){ ?>selected="selected"<?php } ?>>Container</option>
                        <option value="type_expense" <?php if(isset($_SESSION['populate']['type_module']) && $_SESSION['populate']['type_module']=="type_expense"){ ?>selected="selected"<?php } ?>>Expense</option>
                        <?php
                            $select3=$bg_connexion->query("SELECT * FROM ".HASH."_plugins");
                            $select3->setFetchMode(PDO::FETCH_OBJ);
                            while($row = $select3->fetch()){
                                $extension = $row->content;
                                $title = $row->title;
                                $extension_full="type_".$extension;
                        ?>
                            <option value="<?php echo $extension_full ?>" <?php if(isset($_SESSION['populate']['type_module']) && $_SESSION['populate']['type_module'] == $extension_full){ ?>selected="selected"<?php } ?>><?php echo $title ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </p>
                <p>
                    Date: <br />
                    <select class="chosen-select form-control" name="date_module">
                        <option value=""></option>
                        <option value="DESC" <?php if(isset($_SESSION['populate']['date_module']) && $_SESSION['populate']['date_module']=="DESC"){ ?>selected="selected"<?php } ?>>Descending</option>
                        <option value="ASC" <?php if(isset($_SESSION['populate']['date_module']) && $_SESSION['populate']['date_module']=="ASC"){ ?>selected="selected"<?php } ?>>Ascending</option>
                    </select>
                </p>
                <p>
                    Time: <br />
                    <select class="chosen-select form-control" name="time_module">
                        <option value=""></option>		
                        <option value="DESC" <?php if(isset($_SESSION['populate']['time_module']) && $_SESSION['populate']['time_module']=="DESC"){ ?>selected="selected"<?php } ?>>Descending</option>
                        <option value="ASC" <?php if(isset($_SESSION['populate']['time_module']) && $_SESSION['populate']['time_module']=="ASC"){ ?>selected="selected"<?php } ?>>Ascending</option>
                    </select>
                </p>
                <p>
                    Order: <br />
                    <select class="chosen-select form-control" name="order_module">
                        <option value=""></option>		
                        <option value="DESC" <?php if(isset($_SESSION['populate']['order_module']) && $_SESSION['populate']['order_module']=="DESC"){ ?>selected="selected"<?php } ?>>Descending</option>
                        <option value="ASC" <?php if(isset($_SESSION['populate']['order_module']) && $_SESSION['populate']['order_module']=="ASC"){ ?>selected="selected"<?php } ?>>Ascending</option>
                    </select>
                </p>
                <p>
                    Published: <br />
                    <select class="chosen-select form-control" name="published_module">
                        <option value=""></option>		
                        <option value="yes" <?php if(isset($_SESSION['populate']['published_module']) && $_SESSION['populate']['published_module']=="yes"){ ?>selected="selected"<?php } ?>>Published</option>
                        <option value="no" <?php if(isset($_SESSION['populate']['published_module']) && $_SESSION['populate']['published_module']=="no"){ ?>selected="selected"<?php } ?>>Unpublished</option>
                    </select>
                <p>
                <p><input type="submit" class="btn btn-primary" size="20" value="Search" name="post_order_module" /><p>
                </div>
            </div>
        </form>
	</div>
    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading"><h2 class="panel-title">Modules</h2></div>
            <div class="panel-body">
        <form action="index.php?page=order_module" method="post" id="validator" role="form">
            <table class="table-striped list">
                <tr>
                    <td>Class/Title</td>
                    <td>Type</td>
                    <td>Date</td>
                    <td>Time</td>
                    <td>Order</td>
                    <td>tag</td>
                    <td>Published</td>
                    <td>Delete</td>
                    <td>Id</td>
                </tr>
        <?php
                while($bg_fetch_modules = $select1->fetch()){
                    $bg_id=decoding($bg_fetch_modules->id);
                    $bg_class=decoding($bg_fetch_modules->class);
                    $bg_modules=decoding($bg_fetch_modules->modules);
                    $bg_date=decoding($bg_fetch_modules->date);
                    $bg_time=decoding($bg_fetch_modules->time);
                    $bg_order1=decoding($bg_fetch_modules->order1);
                    $bg_title=decoding($bg_fetch_modules->title);
                    $bg_published=decoding($bg_fetch_modules->published);
                    if($bg_published=='1'){
                        $bg_published='Yes';
                        $publishImage="<span class=\"glyphicon glyphicon-ok-circle\"></span>";
                    } else {
                        $bg_published='No'; 
                        $publishImage="<span class=\"glyphicon glyphicon-ban-circle\"></span>";
                    }
                    $bg_tag_multiple=decoding($bg_fetch_modules->tag);
                    $bg_tag_multiple = explode(":",$bg_tag_multiple);
                    preg_match('/\{type_(.*?)\{/', $bg_modules, $bg_match);
                    $bg_type=$bg_match[1];
                    $bg_tag=$bg_match[1];
                    if(($bg_type!='') && ($bg_title != "hidden") && ($bg_id != 1)){
        ?>
                <tr>
                    <td><a href="index.php?page=<?php echo $bg_tag ?>&id=<?php echo $bg_id ?>" class="<?php if($bg_published == 'No') { echo 'label label-danger'; } ?>"><?php echo $bg_class ?></a></td>
                    <td><?php echo $bg_type ?></td>
                    <td><?php echo $bg_date ?></td>
                    <td><?php echo $bg_time ?></td>
                    <td><input type="text" class="form-control" style="width: 40px;" value="<?php echo $bg_order1 ?>" name="order[<?php echo $bg_id ?>]" /></td>
                    <td>
						<?php
                            for($bg_i=0; $bg_i<count($bg_tag_multiple); $bg_i++){
                        ?>
                                <label class="label label-warning"><?php echo $bg_tag_multiple[$bg_i] ?></label> 
                        <?php
                            }
                        ?>
                    </td>
                    <td><a href="index.php?page=publish_module&id=<?php echo $bg_id ?>&state=<?php echo $bg_published ?>"><?php echo $publishImage ?></a></td>
                    <td><a href="index.php?page=delete_module&action=delete&id=<?php echo $bg_id ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                    <td><?php echo $bg_id ?></td>
                </tr>
        <?php
                    }
                }
        ?>
            </table>
            <input type="submit" class="btn btn-primary" class="reorder" value="Reorder" />
        </form>
			</div>
		</div>
	</div>
</div>        
<?php echo pagination($bg_init_modules_rows); ?>