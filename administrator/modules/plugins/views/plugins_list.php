<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<h1>LIST OF PLUGINS</h1>
<div class="row">
	<div class="col-md-2">
        <form action="index.php?page=plugins" method="post" id="validator" role="form">
            <div class="panel panel-default listing-sidebar">
                <div class="panel-heading"><h2 class="panel-title">Filter plugins</h2></div>
                <div class="panel-body">
                <p>
                    Keyword: <br />
                    <input type="text" class="form-control" size="20" value="<?php echo (isset($_SESSION['populate']['search_plugin']) ? $_SESSION['populate']['search_plugin'] : ''); ?>" name="search_plugin" />
                </p>
                <p>
                    Title: <br />
                    <select class="chosen-select form-control" name="title_plugin">
                        <option value=""></option>
                        <option value="DESC" <?php if(isset($_SESSION['populate']['title_plugin']) && $_SESSION['populate']['title_plugin']=="DESC"){ ?>selected="selected"<?php } ?>>Descending</option>
                        <option value="ASC" <?php if(isset($_SESSION['populate']['title_plugin']) && $_SESSION['populate']['title_plugin']=="ASC"){ ?>selected="selected"<?php } ?>>Ascending</option>
                    </select>
                </p>
                <p>
                    Date: <br />
                    <select class="chosen-select form-control" name="date_plugin">
                        <option value=""></option>
                        <option value="DESC" <?php if(isset($_SESSION['populate']['date_plugin']) && $_SESSION['populate']['date_plugin']=="DESC"){ ?>selected="selected"<?php } ?>>Descending</option>
                        <option value="ASC" <?php if(isset($_SESSION['populate']['date_plugin']) && $_SESSION['populate']['date_plugin']=="ASC"){ ?>selected="selected"<?php } ?>>Ascending</option>
                    </select>
                </p>
                <p>
                    Time: <br />
                    <select class="chosen-select form-control" name="time_plugin">
                        <option value=""></option>		
                        <option value="DESC" <?php if(isset($_SESSION['populate']['time_plugin']) && $_SESSION['populate']['time_plugin']=="DESC"){ ?>selected="selected"<?php } ?>>Descending</option>
                        <option value="ASC" <?php if(isset($_SESSION['populate']['time_plugin']) && $_SESSION['populate']['time_plugin']=="ASC"){ ?>selected="selected"<?php } ?>>Ascending</option>
                    </select>
                </p>
                <p>
                    Published: <br />
                    <select class="chosen-select form-control" name="published_plugin">
                        <option value=""></option>	
                        <option value="yes" <?php if(isset($_SESSION['populate']['published_plugin']) && $_SESSION['populate']['published_plugin']=="yes"){ ?>selected="selected"<?php } ?>>Published</option>
                        <option value="no" <?php if(isset($_SESSION['populate']['published_plugin']) && $_SESSION['populate']['published_plugin']=="no"){ ?>selected="selected"<?php } ?>>Unpublished</option>
                    </select>
                <p>
                <p><input type="submit" class="btn btn-primary" size="20" value="Search" name="post_order_plugin" /></p>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading"><h2 class="panel-title">Plugins</h2></div>
            <div class="panel-body" style="overflow-x: auto;">
        <table class="table-striped list">
            <tr>
                <td>Title</td>
                <td>Date</td>
                <td>Time</td>
                <td>Published</td>
                <td>Delete</td>
            </tr>
    <?php 
            while($bg_fetch_plugins = $select1->fetch()){		
                $bg_id=decoding($bg_fetch_plugins->id);
                $bg_title=decoding($bg_fetch_plugins->title);
                $bg_date=decoding($bg_fetch_plugins->date);
                $bg_time=decoding($bg_fetch_plugins->time);
                $bg_publish=decoding($bg_fetch_plugins->publish);			
                if($bg_publish==1){
                    $enable='Yes';
                    $publishImage="<span class=\"glyphicon glyphicon-ok-circle\"></span>";
                } else {
                    $enable='No'; 
                    $publishImage="<span class=\"glyphicon glyphicon-ban-circle\"></span>";
                }
    ?>
            <tr>
                <td><?php echo $bg_title ?></td>
                <td><?php echo $bg_date ?></td>
                <td><?php echo $bg_time ?></td>
                <td><a href="index.php?page=plugins&action=publish&id_plugin=<?php echo $bg_id ?>&state=<?php echo $enable ?>"><?php echo $publishImage ?></a></td>
                <td><a href="index.php?page=plugins&action=delete&id_plugin=<?php echo $bg_id ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
            </tr>
    <?php 
            }
    ?>
        </table>
            </div>
        </div>
    </div>
</div>
<?php echo pagination($bg_init_plugins_rows); ?>