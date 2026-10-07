<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<div class="row">
	<div class="col-md-12" style="margin-bottom: 10px;">
		<a class="btn btn-info pull-right" href="index.php?page=calendar_plan<?php if(isset($_GET['tag'])) { echo '&amp;tag='.urlencode($_GET['tag']); } ?>">View Calendar</a>
		<a class="btn btn-success pull-right" href="index.php?page=export_plan<?php if(isset($_GET['tag'])) { echo '&amp;tag='.urlencode($_GET['tag']); } ?>">Export Excel</a>
		<button class="btn btn-warning pull-right" onclick="window.print();return false;">Print Page</button>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><h2 class="panel-title">Plans</h2></div>
			<div class="panel-body" style="overflow-x: auto;">
		<?php 
			$pay_amount = array();
			$expense_amount = array();
			$start_date = 99999999999999999999999;
			$x = 0;
		?>
		<table width="100%" cellpadding="5" cellspacing="0" class="table-striped list">
			<tr>
				<td>Class</td>
				<td>Title</td>
				<td>Username</td>
				<td>Time</td>
				<td>Date</td>
				<td>Tags</td>
				<td>Pay method</td>
			</tr>
			<?php 
			if(isset($data['module'])){
				foreach($data['module'] as $key => $value) { 
					if($data['module'][$key]->published == '1'){
						$bg_modules = $data['module'][$key]->modules;
						
						if(preg_match('/\{(.*?)\}$/', $bg_modules, $bg_match)) { 
							if(preg_match('/\{(.*?)\}$/',$bg_match[1],$bg_match2)) {
								
								if(preg_match('/class\{(.*?)\}/',$bg_match2[1],$bg_match3)) {
									$bg_options1 = explode(':',$bg_match3[1]);
								}
								
								if(preg_match('/plan\{(.*?)\}/',$bg_match2[1],$bg_match3)) {	
									$bg_options2 = explode(':',$bg_match3[1]);
								}
							}
						}
					?>
					<tr>
						<td valign="top"><?php if(isset($bg_options1[0]) && $bg_options1[0] == 'show_title'){ echo $data['module'][$key]->class; } ?></td>
						<td valign="top"><?php if(isset($bg_options2[0]) && $bg_options2[0] == 'show_title'){ echo $data['module'][$key]->title; } ?></td>
						<td valign="top"><?php if(isset($bg_options2[2]) && $bg_options2[2] == 'show_username'){ echo $data['module'][$key]->username; } ?></td>
						<td valign="top"><?php if(isset($bg_options2[3]) && $bg_options2[3] == 'show_time'){ echo $data['module'][$key]->time; } ?></td>
						<td valign="top"><?php if(isset($bg_options2[4]) && $bg_options2[4] == 'show_date'){ echo $data['module'][$key]->date; } ?></td>
						<td valign="top">
						<?php
								$bg_tag_multiple = explode(':', $data['module'][$key]->tag);
								if(isset($bg_tag_multiple[0]) && $bg_tag_multiple[0] != ''){
									for($bg_i=0; $bg_i<count($bg_tag_multiple); $bg_i++){
								?>
										<label class="label label-warning"><a href="index.php?page=list_plan&tag=<?php echo $bg_tag_multiple[$bg_i] ?>"><?php echo $bg_tag_multiple[$bg_i] ?></a></label> 
								<?php
									}
								}
							?>
						</td>
						<td valign="top">
							<table width="100%" cellpadding="5" cellspacing="0">
								<?php 
									$pay = json_decode($data['plans'][$key]->pay, true);
									foreach($pay as $key2 => $value2){
								?>	
									<tr>
										<td valign="top" width="33%"><?php echo 'Pay '.$x; ?></td>
										<td valign="top" width="33%">Amount: <?php echo $pay[$key2]['amount']; ?></td>
										<td valign="top" width="33%">Period: <?php echo $pay[$key2]['frequence']; ?></td>
									</tr>
								<?php
										$date = str_replace('-', '', $data['module'][$key]->date);
										$time = str_replace(':', '', $data['module'][$key]->time);
										if(intval($date.$time) < $start_date){
											$start_date = intval($date.$time);
										}
										if($pay[$key2]['frequence'] == 'daily'){
											$pay_amount['pay ['.$x.']'] = $pay[$key2]['amount'];
										} elseif($pay[$key2]['frequence'] == 'weekly'){
											$pay_amount['pay ['.$x.']'] = ($pay[$key2]['amount'] / (365 / 52));
										} elseif($pay[$key2]['frequence'] == 'monthly'){
											$pay_amount['pay ['.$x.']'] = ($pay[$key2]['amount'] / (365 / 12));
										} elseif($pay[$key2]['frequence'] == 'yearly'){
											$pay_amount['pay ['.$x.']'] = ($pay[$key2]['amount'] / 365);
										}
										$x++;
									}
								?>
							</table>
						</td>
					</tr>
				<?php 
					}
				} 
			}
			?>
		</table>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><h2 class="panel-title">Expenses</h2></div>
			<div class="panel-body" style="overflow-x: auto;">
		<table width="100%" cellpadding="5" cellspacing="0" class="table-striped list">
			<tr>
				<td>Class</td>
				<td>Title</td>
				<td>Username</td>
				<td>Time</td>
				<td>Date</td>
				<td>Tags</td>
				<td>Cost</td>
				<td>Frequence</td>
				<td>Content</td>
			</tr>
			<?php 
			if(isset($data['expenses'])){
				foreach($data['expenses'] as $key => $value) { 
					if($data['expenses'][$key]['data']->published == '1'){
						$bg_modules = $data['expenses'][$key]['data']->modules;
						
						if(preg_match('/\{(.*?)\}$/', $bg_modules, $bg_match)) { 
							if(preg_match('/\{(.*?)\}$/',$bg_match[1],$bg_match2)) {
								
								if(preg_match('/class\{(.*?)\}/',$bg_match2[1],$bg_match3)) {
									$bg_options1 = explode(':',$bg_match3[1]);
								}
								
								if(preg_match('/expense\{(.*?)\}/',$bg_match2[1],$bg_match3)) {	
									$bg_options2 = explode(':',$bg_match3[1]);
								}
							}
						}
					?>
					<tr>
						<td><?php if(isset($bg_options1[0]) && $bg_options1[0] == 'show_title'){ echo $data['expenses'][$key]['data']->class; } ?></td>
						<td><?php if(isset($bg_options2[0]) && $bg_options2[0] == 'show_title'){ echo $data['expenses'][$key]['data']->title; } ?></td>
						<td><?php if(isset($bg_options2[2]) && $bg_options2[2] == 'show_username'){ echo $data['expenses'][$key]['data']->username; } ?></td>
						<td><?php if(isset($bg_options2[3]) && $bg_options2[3] == 'show_time'){ echo $data['expenses'][$key]['data']->time; } ?></td>
						<td><?php if(isset($bg_options2[4]) && $bg_options2[4] == 'show_date'){ echo $data['expenses'][$key]['data']->date; } ?></td>
						<td>
						<?php
								$bg_tag_multiple = explode(':', $data['expenses'][$key]['data']->tag);
								if(isset($bg_tag_multiple[0]) && $bg_tag_multiple[0] != ''){
									for($bg_i=0; $bg_i<count($bg_tag_multiple); $bg_i++){
								?>
										<label class="label label-warning"><a href="index.php?page=list_plan&tag=<?php echo $bg_tag_multiple[$bg_i] ?>"><?php echo $bg_tag_multiple[$bg_i] ?></a></label> 
								<?php
									}
								}
							?>
						</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				<?php 
						foreach($data['expenses'][$key]['expenses_item'] as $key2 => $value2) { 
						?>
						<tr>
							<td><?php if(isset($bg_options1[0]) && $bg_options1[0] == 'show_title'){ echo $data['expenses'][$key]['expenses_item'][$key2]->class; } ?></td>
							<td><?php if(isset($bg_options2[0]) && $bg_options2[0] == 'show_title'){ echo $data['expenses'][$key]['expenses_item'][$key2]->title; } ?></td>
							<td><?php if(isset($bg_options2[2]) && $bg_options2[2] == 'show_username'){ echo $data['expenses'][$key]['expenses_item'][$key2]->username; } ?></td>
							<td><?php if(isset($bg_options2[3]) && $bg_options2[3] == 'show_time'){ echo $data['expenses'][$key]['expenses_item'][$key2]->time; } ?></td>
							<td><?php if(isset($bg_options2[4]) && $bg_options2[4] == 'show_date'){ echo $data['expenses'][$key]['expenses_item'][$key2]->date; } ?></td>
							<td>
							<?php
									$bg_tag_multiple = explode(':', $data['expenses'][$key]['expenses_item'][$key2]->tag);
									for($bg_i=0; $bg_i<count($bg_tag_multiple); $bg_i++){
										if(isset($bg_tag_multiple[0]) && $bg_tag_multiple[0] != ''){
									?>
											<label class="label label-warning"><a href="index.php?page=list_plan&tag=<?php echo $bg_tag_multiple[$bg_i] ?>"><?php echo $bg_tag_multiple[$bg_i] ?></a></label> 
									<?php
										}
									}
								?>
							</td>
							<td><?php echo $data['expenses'][$key]['expenses_item'][$key2]->cost; ?></td>
							<td><?php echo $data['expenses'][$key]['expenses_item'][$key2]->frequence; ?></td>
							<td><?php if(isset($bg_options2[1]) && $bg_options2[1] == 'show_description'){ echo $data['expenses'][$key]['expenses_item'][$key2]->content; } ?></td>
						</tr>
						
						<?php	
							$date = str_replace('-', '', $data['expenses'][$key]['data']->date);
							$time = str_replace(':', '', $data['expenses'][$key]['data']->time);
							if($data['expenses'][$key]['expenses_item'][$key2]->frequence == 'daily'){
								$expense_amount[$date.$time][] = $data['expenses'][$key]['expenses_item'][$key2]->cost;
							} elseif($data['expenses'][$key]['expenses_item'][$key2]->frequence == 'weekly'){
								$expense_amount[$date.$time][] = ($data['expenses'][$key]['expenses_item'][$key2]->cost / (365 / 52));
							} elseif($data['expenses'][$key]['expenses_item'][$key2]->frequence == 'monthly'){
								$expense_amount[$date.$time][] = ($data['expenses'][$key]['expenses_item'][$key2]->cost / (365 / 12));
							} elseif($data['expenses'][$key]['expenses_item'][$key2]->frequence == 'yearly'){
								$expense_amount[$date.$time][] = ($data['expenses'][$key]['expenses_item'][$key2]->cost / 365);
							}
						}			
					}
				?>
				<tr>
					<td colspan="9" style="border-bottom: none !important; height: 40px !important; padding: 0px !important;">
					</td>
				</tr>
				<?php
				} 
			}
		?>
		</table>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><h2 class="panel-title">Other expenses</h2></div>
			<div class="panel-body" style="overflow-x: auto;">
		<table width="100%" cellpadding="5" cellspacing="0" class="table-striped list">
			<tr>
				<td>Class</td>
				<td>Title</td>
				<td>Username</td>
				<td>Time</td>
				<td>Date</td>
				<td>Tags</td>
				<td>Cost</td>
				<td>Frequence</td>
				<td>Content</td>
			</tr>
			<?php
			if(isset($data['other_expenses'])){
				foreach($data['other_expenses'] as $key => $value) { 
					if($data['other_expenses'][$key]->publish == '1'){
						$bg_modules = $data['other_expenses'][$key]->modules;
						
						if(preg_match('/\{(.*?)\}$/', $bg_modules, $bg_match)) { 
							if(preg_match('/\{(.*?)\}$/',$bg_match[1],$bg_match2)) {
								
								if(preg_match('/expense\{(.*?)\}/',$bg_match2[1],$bg_match3)) {	
									$bg_options2 = explode(':',$bg_match3[1]);
								}
							}
						}
					?>
					<tr>
						<td>No class</td>
						<td><?php if(isset($bg_options2[0]) && $bg_options2[0] == 'show_title'){ echo $data['other_expenses'][$key]->title; } ?></td>
						<td><?php if(isset($bg_options2[2]) && $bg_options2[2] == 'show_username'){ echo $data['other_expenses'][$key]->username; } ?></td>
						<td><?php if(isset($bg_options2[3]) && $bg_options2[3] == 'show_time'){ echo $data['other_expenses'][$key]->time; } ?></td>
						<td><?php if(isset($bg_options2[4]) && $bg_options2[4] == 'show_date'){ echo $data['other_expenses'][$key]->date; } ?></td>
						<td>
						<?php
								$bg_tag_multiple = explode(':', $data['other_expenses'][$key]->tag);
								for($bg_i=0; $bg_i<count($bg_tag_multiple); $bg_i++){
									if(isset($bg_tag_multiple[0]) && $bg_tag_multiple[0] != ''){
								?>
										<label class="label label-warning"><a href="index.php?page=list_plan&tag=<?php echo $bg_tag_multiple[$bg_i] ?>"><?php echo $bg_tag_multiple[$bg_i] ?></a></label> 
								<?php
									}
								}
							?>
						</td>
						<td><?php echo $data['other_expenses'][$key]->cost; ?></td>
						<td><?php echo $data['other_expenses'][$key]->frequence; ?></td>
						<td><?php if(isset($bg_options2[1]) && $bg_options2[1] == 'show_description'){ echo $data['other_expenses'][$key]->content; } ?></td>
					</tr>
				<?php 
						$date = str_replace('-', '', $data['other_expenses'][$key]->date);
						$time = str_replace(':', '', $data['other_expenses'][$key]->time);
						if($data['other_expenses'][$key]->frequence == 'daily'){
							$expense_amount[$date.$time][] = $data['other_expenses'][$key]->cost;
						} elseif($data['other_expenses'][$key]->frequence == 'weekly'){
							$expense_amount[$date.$time][] = ($data['other_expenses'][$key]->cost / (365 / 52));
						} elseif($data['other_expenses'][$key]->frequence == 'monthly'){
							$expense_amount[$date.$time][] = ($data['other_expenses'][$key]->cost / (365 / 12));
						} elseif($data['other_expenses'][$key]->frequence == 'yearly'){
							$expense_amount[$date.$time][] = ($data['other_expenses'][$key]->cost / 365);
						}			
					}
				} 
			} ?>
		</table>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><h2 class="panel-title">Total projection</h2></div>
			<div class="panel-body">
		<?php
			$monthly_rows = array();
			$monthly_totals = array();
			$w = 1;
			$m = 1;
			for($i=1; $i<366; $i++){
				$expense_amount_collect = 0;
				$pay_amount_collect = array();
				$pay_amount_collect_total = 0;
				$expense_amount_collect_daily = 0;
				$pay_amount_collect_daily = 0;
				$date_time = '';
				$date_time_expense = '';
				foreach($pay_amount as $key => $value){
					$date = substr($start_date, 0, 8);
					$year = substr($date, 0, 4);
					$month = substr($date, 4, 2);
					$day = substr($date, 6, 2);
					$time = substr($start_date, 8, 6);
					$hour = substr($time, 0, 2);
					$minute = substr($time, 2, 2);
					$second = substr($time, 4, 2);
					$date = $year.'-'.$month.'-'.$day;
					$time = $hour.':'.$minute.':'.$second;
					$date_time = $year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':'.$second;
					$pay_amount_collect[$key] = $value * $i;
					$pay_amount_collect_total += $value * $i;
					$pay_amount_collect_daily += $value;
				}
				if($date_time == ''){
					$date_time = date('Y-m-d H:i:s');
				}
				$date = date('Y-m-d', strtotime($date_time.' +'.$i.' day'));
				$week_day = date('l', strtotime($date_time.' +'.$i.' day'));
				$time = date('H:i:s', strtotime($date_time.' +'.$i.' day'));
				$date_time_expense = date('YmdHis', strtotime($date_time.' +'.$i.' day'));
				foreach($expense_amount as $key => $value){
					if(intval($key) <= intval($date_time_expense)){
						foreach($value as $key1 => $value1){
							$expense_amount_collect += $value1;
							$expense_amount_collect_daily += $value1;
						}
					}
				}
				$expense_amount_collect *= $i;
				if($week_day == 'Monday'){
					$w++;
				}
				$check_day = explode('-', $date);
				if($check_day[2] == '1'){
					$m++;
				}
				$month_key = substr($date, 0, 7);
				if(!isset($monthly_rows[$month_key])){
					$monthly_rows[$month_key] = array();
					$monthly_totals[$month_key] = array('daily_pay' => 0, 'daily_expense' => 0, 'closing_pay' => 0, 'closing_expense' => 0);
				}
				$monthly_rows[$month_key][] = array(
					'day_number' => $i,
					'week_number' => $w,
					'month_number' => $m,
					'date' => $date,
					'time' => $time,
					'daily_pay' => $pay_amount_collect_daily,
					'daily_expense' => $expense_amount_collect_daily,
					'pay_total' => $pay_amount_collect_total,
					'expense_total' => $expense_amount_collect,
					'pay_items' => $pay_amount_collect
				);
				$monthly_totals[$month_key]['daily_pay'] += $pay_amount_collect_daily;
				$monthly_totals[$month_key]['daily_expense'] += $expense_amount_collect_daily;
				$monthly_totals[$month_key]['closing_pay'] = $pay_amount_collect_total;
				$monthly_totals[$month_key]['closing_expense'] = $expense_amount_collect;
			}
			$grand_pay_total = 0;
			$grand_expense_total = 0;
			foreach($monthly_totals as $month_total){
				$grand_pay_total += $month_total['daily_pay'];
				$grand_expense_total += $month_total['daily_expense'];
			}
		?>
		<style>
			#monthly-total-tables,
			#monthly-total-tables .panel-title > a,
			#monthly-total-tables .panel-body,
			#monthly-total-tables table,
			#monthly-total-tables .info { color: #000; }
			#monthly-total-tables .label { color: #fff; }
		</style>
		<div class="panel-group" id="monthly-total-tables">
			<?php $month_index = 0; foreach($monthly_rows as $month_key => $rows){
				$month_total = $monthly_totals[$month_key];
				$month_profit = $month_total['daily_pay'] - $month_total['daily_expense'];
				$month_panel_id = 'month-'.str_replace('-', '', $month_key);
			?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#monthly-total-tables" href="#<?php echo $month_panel_id; ?>">
							<?php echo date('F Y', strtotime($month_key.'-01')); ?>
							<span class="pull-right">Month profit: <?php echo intval($month_profit); ?> <span class="caret"></span></span>
						</a>
					</h4>
				</div>
				<div id="<?php echo $month_panel_id; ?>" class="panel-collapse collapse<?php if($month_index == 0) { echo ' in'; } ?>">
					<div class="panel-body" style="overflow-x: auto;">
						<table width="100%" cellpadding="5" cellspacing="0" class="table-striped list">
							<tr>
								<td class="hide_for_print">Day</td>
								<td class="hide_for_print">Week</td>
								<td class="hide_for_print">Month</td>
								<td>Date</td>
								<td>Time</td>
								<td>Daily Pay</td>
								<td>Daily Expense</td>
								<td>Pay Total</td>
								<td>Expense Total</td>
								<td align="right">Profit</td>
							</tr>
							<?php foreach($rows as $row){ ?>
							<tr>
								<td width="6%" class="hide_for_print"><?php echo 'Day '.$row['day_number']; ?></td>
								<td width="6%" class="hide_for_print"><?php echo 'Week '.$row['week_number']; ?></td>
								<td width="6%" class="hide_for_print"><?php echo 'Month '.$row['month_number']; ?></td>
								<td width="6%"><?php echo $row['date']; ?></td>
								<td width="6%"><?php echo $row['time']; ?></td>
								<td width="10%"><?php echo $row['daily_pay']; ?></td>
								<td width="10%"><?php echo $row['daily_expense']; ?></td>
								<td width="10%"><?php echo $row['pay_total']; ?></td>
								<td width="10%"><?php echo $row['expense_total']; ?></td>
								<td width="30%" align="center">
									<?php foreach($row['pay_items'] as $key => $value){ ?>
										<span style="float: left; margin-right: 3px;" class="label label-<?php if(($value - $row['expense_total']) > 0){ echo 'success'; } else { echo 'danger'; } ?>">With <?php echo $key; ?>: <?php echo intval($value - $row['expense_total']); ?></span>
									<?php } ?>
									<span style="float: right;">Total: <?php echo intval($row['pay_total'] - $row['expense_total']); ?></span>
								</td>
							</tr>
							<?php } ?>
							<tr class="info">
								<td colspan="5" align="right"><strong>Month totals</strong></td>
								<td><strong><?php echo $month_total['daily_pay']; ?></strong></td>
								<td><strong><?php echo $month_total['daily_expense']; ?></strong></td>
								<td><?php echo $month_total['closing_pay']; ?></td>
								<td><?php echo $month_total['closing_expense']; ?></td>
								<td align="center"><strong><?php echo intval($month_profit); ?></strong></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<?php $month_index++; } ?>
		</div>
		<table width="100%" cellpadding="5" cellspacing="0" class="table-striped list total">
			<tr>
				<td align="center"><h2>TOTAL GAIN: <?php echo $grand_pay_total; ?></h2></td>
				<td align="center"><h2>TOTAL EXPENSE: -<?php echo $grand_expense_total; ?></h2></td>
				<td align="center"><h2 style="font-size: 30px; padding: 0px 10px; font-weight: lighter;" class="label label-<?php if(($grand_pay_total - $grand_expense_total) > 0) { echo 'success'; } else { echo 'danger'; } ?>">TOTAL PROFIT: <?php echo ($grand_pay_total - $grand_expense_total); ?></h2></td>
			</tr>
		</table>
		<p style="margin-bottom: 50px;"></p>
			</div>
		</div>
	</div>
</div>