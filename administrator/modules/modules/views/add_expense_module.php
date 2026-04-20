<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<h1>ADD EXPENSE MODULE</h1>
<form action="index.php?page=addmodule&action=post_expense" method="post" id="validator" role="form">
    <div class="row">
        <div class="col-md-6">
            <table class="table-striped">
                <tr>
                	<td width="20%">Title</td>
                    <td><input name="title" type="text" class="form-control" size="30" value="<?php echo isset($_SESSION['populate']['title']) ? $_SESSION['populate']['title'] : ''; ?>" /></td>
                </tr>
                <tr>
                    <td width="20%">Type of module</td>
                    <td>Expense</td>
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
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">	
            <input type="submit" class="btn btn-primary" name="post" value="Add" />
        </div>
    </div>
</form>