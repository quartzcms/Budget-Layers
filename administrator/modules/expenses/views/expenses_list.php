<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<h1>EXPENSES</h1>
<div class="row">
    <div class="col-md-2">
        <form action="index.php?page=list_expense" method="post" id="validator" role="form">
            <div class="well">
                <p>
                    Keyword: <br />
                    <input type="text" class="form-control" size="20" value="<?php echo (isset($_SESSION['populate']['search_expense']) ? $_SESSION['populate']['search_expense'] : '') ?>" name="search_expense" />
                </p>
                <p>
                    Class: <br />
                    <select class="chosen-select form-control" name="class_expense">
                        <option value=""></option>
                        <option value="DESC" <?php if(isset($_SESSION['populate']['class_expense']) && $_SESSION['populate']['class_expense']=="DESC"){ ?>selected="selected"<?php } ?>>Descending</option>
                        <option value="ASC" <?php if(isset($_SESSION['populate']['class_expense']) && $_SESSION['populate']['class_expense']=="ASC"){ ?>selected="selected"<?php } ?>>Ascending</option>
                    </select>
                </p>
                <p>
                    Date: <br />
                    <select class="chosen-select form-control" name="date_expense">
                        <option value=""></option>
                        <option value="DESC" <?php if(isset($_SESSION['populate']['date_expense']) && $_SESSION['populate']['date_expense']=="DESC"){ ?>selected="selected" <?php } ?>>Descending</option>
                        <option value="ASC" <?php if(isset($_SESSION['populate']['date_expense']) && $_SESSION['populate']['date_expense']=="ASC"){ ?>selected="selected" <?php } ?>>Ascending</option>
                    </select>
                </p>
                <p>
                    Time: <br />
                    <select class="chosen-select form-control" name="time_expense">
                        <option value=""></option>		
                        <option value="DESC" <?php if(isset($_SESSION['populate']['time_expense']) && $_SESSION['populate']['time_expense']=="DESC"){ ?>selected="selected" <?php } ?>>Descending</option>
                        <option value="ASC" <?php if(isset($_SESSION['populate']['time_expense']) && $_SESSION['populate']['time_expense']=="ASC"){ ?>selected="selected" <?php } ?>>Ascending</option>
                    </select>
                </p>
                <p>
                    Order: <br />
                    <select class="chosen-select form-control" name="order_expense">
                        <option value=""></option>		
                        <option value="DESC" <?php if(isset($_SESSION['populate']['order_expense']) && $_SESSION['populate']['order_expense']=="DESC"){ ?>selected="selected" <?php } ?>>Descending</option>
                        <option value="ASC" <?php if(isset($_SESSION['populate']['order_expense']) && $_SESSION['populate']['order_expense']=="ASC"){ ?>selected="selected" <?php } ?>>Ascending</option>
                    </select>
                </p>
				<p>
                    Cost: <br />
                    <select class="chosen-select form-control" name="cost_expense">
                        <option value=""></option>		
                        <option value="DESC" <?php if(isset($_SESSION['populate']['cost_expense']) && $_SESSION['populate']['cost_expense']=="DESC"){ ?>selected="selected" <?php } ?>>Descending</option>
                        <option value="ASC" <?php if(isset($_SESSION['populate']['cost_expense']) && $_SESSION['populate']['cost_expense']=="ASC"){ ?>selected="selected" <?php } ?>>Ascending</option>
                    </select>
                </p>
				<p>
                    Frequence: <br />
                    <select class="chosen-select form-control" name="frequence_expense">
                        <option value=""></option>		
                        <option value="daily" <?php if(isset($_SESSION['populate']['frequence_expense']) && $_SESSION['populate']['frequence_expense']=="daily"){ ?>selected="selected" <?php } ?>>Daily</option>
                        <option value="monthly" <?php if(isset($_SESSION['populate']['frequence_expense']) && $_SESSION['populate']['frequence_expense']=="monthly"){ ?>selected="selected" <?php } ?>>Monthly</option>
						<option value="yearly" <?php if(isset($_SESSION['populate']['frequence_expense']) && $_SESSION['populate']['frequence_expense']=="yearly"){ ?>selected="selected" <?php } ?>>Yearly</option>
                    </select>
                </p>
                <p>
                    Published: <br />
                    <select class="chosen-select form-control" name="published_expense">
                        <option value=""></option>		
                        <option value="yes" <?php if(isset($_SESSION['populate']['published_expense']) && $_SESSION['populate']['published_expense']=="yes"){ ?>selected="selected" <?php } ?>>Published</option>
                        <option value="no" <?php if(isset($_SESSION['populate']['published_expense']) && $_SESSION['populate']['published_expense']=="no"){ ?>selected="selected" <?php } ?>>Unpublished</option>
                    </select>
                </p>
                <p><input type="submit" class="btn btn-primary" size="20" value="Search" name="post_order_expense" /></p>
            </div>
        </form>
    </div>
	<div class="col-md-10">
        <form action="index.php?page=order_expense" method="post" id="validator" role="form">
            <table class="table-striped list">
                <tr>
                    <td>Title</td>
                    <td>Class</td>
                    <td>Date</td>
                    <td>Time</td>
					<td>Frequence</td>
					<td>Cost</td>
                    <td>Reorder</td>
                    <td>tag</td>
                    <td>Published</td>
                    <td>Delete</td>
                    <td>Id</td>
                </tr>
        <?php
            while($bg_fetch_expenses = $select1->fetch()){	
                $bg_id=decoding($bg_fetch_expenses->id);
                $bg_title=decoding($bg_fetch_expenses->title);
                $bg_class=decoding($bg_fetch_expenses->class);
                $bg_date=decoding($bg_fetch_expenses->date);
                $bg_time=decoding($bg_fetch_expenses->time);
                $bg_order1=decoding($bg_fetch_expenses->order1);
                $bg_publish=decoding($bg_fetch_expenses->publish);	
				$bg_frequence=decoding($bg_fetch_expenses->frequence);
				$bg_cost=decoding($bg_fetch_expenses->cost);				
                $bg_tag_multiple=decoding($bg_fetch_expenses->tag);
                $bg_tag_multiple = explode(":",$bg_tag_multiple);
                $bg_tag=decoding($bg_fetch_expenses->tag);
                        
                if($bg_publish==1){
                    $enable='Yes';
                    $publishImage="<span class=\"glyphicon glyphicon-ok-circle\"></span>";
                } else {
                    $enable='No'; 
                    $publishImage="<span class=\"glyphicon glyphicon-ban-circle\"></span>";
                }
        ?>		
                <tr>
                    <td><a href="index.php?page=modif_expense&id_expense=<?php echo $bg_id ?>" class="<?php if($enable == 'No') { echo 'label label-danger'; } ?>"><?php echo $bg_title ?></a></td>
                    <td><?php if($bg_class == '0') { echo "None"; } else { echo $bg_class; } ?></td>
                    <td><?php echo $bg_date ?></td>
                    <td><?php echo $bg_time ?></td>
					<td><?php echo $bg_frequence ?></td>
					<td><?php echo $bg_cost ?></td>
                    <td><input type="text" class="form-control" style="width: 40px;" name="order[<?php echo $bg_id ?>]" value="<?php echo $bg_order1 ?>" /></td>
                    <td>
                        <?php
                            for($bg_i=0; $bg_i<count($bg_tag_multiple); $bg_i++){
                        ?>
                                <label class="label label-warning"><?php echo $bg_tag_multiple[$bg_i] ?></label> 
                        <?php
                            }
                        ?>
                    </td>
                    <td><a href="index.php?page=publish_expense&id=<?php echo $bg_id ?>&state=<?php echo $enable ?>"><?php echo $publishImage ?></a></td>
                    <td><a href="index.php?page=delete_expense&id=<?php echo $bg_id ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                    <td><?php echo $bg_id ?></td>
                </tr>
        <?php
                }
        ?>
            </table>
            <input type="submit" class="btn btn-primary" class="reorder" value="Reorder" />
        </form>
	</div>
</div>
<?php echo pagination($bg_init_expenses_rows); ?>