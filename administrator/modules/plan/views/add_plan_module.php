<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<h1>ADD PLAN MODULE</h1>
<form action="index.php?page=addmodule&action=post_plan" method="post" id="validator" role="form">
    <div class="row">
        <div class="col-md-6">
            <table class="table-striped">
                <tr>
                	<td width="20%">Title</td>
                    <td><input name="title" type="text" class="form-control" size="30" value="<?php echo isset($_SESSION['populate']['title']) ? $_SESSION['populate']['title'] : ''; ?>" /></td>
                </tr>
                <tr>
                    <td width="20%">Type of module</td>
                    <td>Plan</td>
                </tr>
				<tr>
                    <td width="20%">Date</td>
                    <td><input name="date" id="date" type="text" class="form-control" size="30" value="<?php echo isset($_SESSION['populate']['date']) ? $_SESSION['populate']['date'] : ''; ?>" /></td>
            	</tr>
				<tr>
                    <td width="20%">Hour</td>
                    <td><input name="hour" id="time" type="text" class="form-control" size="30" value="<?php echo isset($_SESSION['populate']['hour']) ? $_SESSION['populate']['hour'] : ''; ?>" /></td>
            	</tr>
				<?php for($i=1; $i<6; $i++){ ?>
				<tr class="pay_method">
                    <td width="20%">Pay method <?php echo $i; ?></td>
                    <td>
						<input name="pay_amount[]" type="text" class="form-control" size="30" value="<?php echo isset($_SESSION['populate']['pay_amount'][$i - 1]) ? $_SESSION['populate']['pay_amount'][$i - 1] : ''; ?>" style="width: 50px; display:inline-block;" />
						<select class="chosen-select form-control" name="pay_frequence[]" style="width: 50px; display:inline-block;">
							<option value="daily" <?php if(isset($_SESSION['populate']['pay_frequence'][$i - 1]) && $_SESSION['populate']['pay_frequence'][$i - 1] == 'daily'){ echo "selected='selected'"; } ?>>Daily</option>
							<option value="weekly" <?php if(isset($_SESSION['populate']['pay_frequence'][$i - 1]) && $_SESSION['populate']['pay_frequence'][$i - 1] == 'weekly'){ echo "selected='selected'"; } ?>>Weekly</option>
							<option value="monthly" <?php if(isset($_SESSION['populate']['pay_frequence'][$i - 1]) && $_SESSION['populate']['pay_frequence'][$i - 1] == 'monthly'){ echo "selected='selected'"; } ?>>Monthly</option>
							<option value="yearly" <?php if(isset($_SESSION['populate']['pay_frequence'][$i - 1]) && $_SESSION['populate']['pay_frequence'][$i - 1] == 'yearly'){ echo "selected='selected'"; } ?>>Yearly</option>
						</select>
					</td>
            	</tr>
				<?php } ?>
                <tr>
                    <td width="20%">Restricted to Tags</td>
                    <td>
                        <?php echo add_tag($bg_connexion); ?>
                    </td>
                </tr>
			</table>
		</div>
		<div class="col-md-6">
            <table class="table-striped">
                <tr>
                    <td width="20%">Class</td>
                    <td></td>
                </tr>
                <tr>
                    <td width="20%">Show Title Class</td>
                    <td>
                        <select class="chosen-select form-control" name="show_title_class">
                            <option value="show_title">Show</option>
                            <option value="0">Hide</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="20%">Plan</td>
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
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">	
            <input type="submit" class="btn btn-primary" name="post" value="Add" />
        </div>
    </div>
</form>