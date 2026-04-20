<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<div class="list">
    <a href="index.php?page=addmodule&action=expense">Add module expense</a><br />
    <a href="index.php?page=addmodule&action=container">Add module container</a><br />
    <?php
        $select1=$bg_connexion->query("SELECT * FROM ".HASH."_plugins WHERE publish='1'");
        $select1->setFetchMode(PDO::FETCH_OBJ);
        while($bg_fetch_plugins = $select1->fetch()){
            $plugin_name=$bg_fetch_plugins->content;
            $plugin_title=$bg_fetch_plugins->title;
            include("modules/".$plugin_name."/links.php");
    ?>
    		<a href="<?php echo $bg_add_module_tag ?>">Add module <?php echo $plugin_title ?></a><br />
	<?php 
		} 
	?>
</div>