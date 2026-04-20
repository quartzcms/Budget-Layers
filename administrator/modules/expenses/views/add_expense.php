<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<h1>ADD EXPENSE</h1>
<form action="index.php?page=add_expense&action=post" method="post" id="validator" role="form">
    <div class="row">
        <div class="col-md-6">
            <table class="table-striped">
            	<tr>
                    <td width="20%">Title</td>
                    <td><input name="title" type="text" class="form-control" size="30" value="<?php echo isset($_SESSION['populate']['title']) ? $_SESSION['populate']['title'] : ''; ?>" /></td>
            	</tr>
				<tr>
                    <td width="20%">Date</td>
                    <td><input name="date" id="date" type="text" class="form-control" size="30" value="<?php echo isset($_SESSION['populate']['date']) ? $_SESSION['populate']['date'] : ''; ?>" /></td>
            	</tr>
				<tr>
                    <td width="20%">Hour</td>
                    <td><input name="hour" id="time" type="text" class="form-control" size="30" value="<?php echo isset($_SESSION['populate']['hour']) ? $_SESSION['populate']['hour'] : ''; ?>" /></td>
            	</tr>
				<tr>
                    <td width="20%">Cost</td>
                    <td><input name="cost" type="text" class="form-control" size="30" value="<?php echo isset($_SESSION['populate']['cost']) ? $_SESSION['populate']['cost'] : ''; ?>" /></td>
            	</tr>
				<tr>
					<td width="20%">Frequence</td>
					<td>
						<select class="chosen-select form-control" name="frequence">
							<option value="daily">Daily</option>
							<option value="weekly">Weekly</option>
							<option value="monthly">Monthly</option>
							<option value="yearly">Yearly</option>
						</select>
					</td>
				</tr>
                <tr>
                    <td width="20%">Attach to module</td>
                    <td>
                        <select class="chosen-select form-control" name="class">
                            <option value="">-NONE-</option>
                            <?php
                                $select2=$bg_connexion->query("SELECT * FROM ".HASH."_class");
                                $select2->setFetchMode(PDO::FETCH_OBJ);
                            
                                while($bg_fetch_class = $select2->fetch()){
                                    $bg_class_listing = $bg_fetch_class->class;
                            ?>
                                <option value="<?php echo $bg_class_listing; ?>"><?php echo $bg_class_listing; ?></option>
                            <?php
                                } 
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                	<td width="20%">Publish</td>
                    <td>
                    	<select class="chosen-select form-control" name="publish">
                            <option value="1">published</option>
                            <option value="0">unpublished</option>
                        </select>
                	</td>
                </tr>
                <tr>
                    <td colspan="2"><h3>If not attach to a module <br />(container, display options)</h3></td>
                </tr>
                <tr>
                    <td width="20%">Tags affected</td>
                    <td>
                    	<?php echo add_tag($bg_connexion); ?>
                    </td>
                </tr>
            </table>
		</div>
        <div class="col-md-6">
            <table class="table-striped">
                <tr>
                    <td width="20%">Expense</td>
                    <td></td>
                </tr>
                <tr>
                    <td width="20%">Show title</td>
                    <td>
                        <select class="chosen-select form-control" name="show_title">
                            <option value="show_title">Show</option>
                            <option value="0">Hide</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="20%">Show description</td>
                    <td>
                        <select class="chosen-select form-control" name="show_description">
                            <option value="show_description">Show</option>
                            <option value="0">Hide</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="20%">Show username</td>
                    <td>
                        <select class="chosen-select form-control" name="show_username">
                            <option value="show_username">Show</option>
                            <option value="0">Hide</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="20%">Show time</td>
                    <td>
                        <select class="chosen-select form-control" name="show_time">
                            <option value="show_time">Show</option>
                            <option value="0">Hide</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="20%">Show Date</td>
                    <td>
                        <select class="chosen-select form-control" name="show_date">
                            <option value="show_date">Show</option>
                            <option value="0">Hide</option>
                        </select>
                    </td>
                </tr>
            </table>
            <textarea cols="80" id="editor" name="value" rows="10"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input type="submit" class="btn btn-primary" name="post" value="Modify" />
        </div>
    </div>
</form>