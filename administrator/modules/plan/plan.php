<?php
	function plan_addmodule($bg_connexion) {
		return render(array('bg_connexion' => $bg_connexion), 'plan', 'add_plan_module');
	}
	
	function post_plan_addmodule ($bg_connexion) {
		$bg_title = encoding((isset($_POST['title']) ? $_POST['title'] : ''));
		$bg_pay_amount = encoding((isset($_POST['pay_amount']) ? $_POST['pay_amount'] : ''));
		$bg_pay_frequence = encoding((isset($_POST['pay_frequence']) ? $_POST['pay_frequence'] : ''));
		$bg_title = encoding((isset($_POST['title']) ? $_POST['title'] : ''));
		$bg_date = encoding((isset($_POST['date']) ? $_POST['date'] : ''));
		$bg_date = ($bg_date == '') ? date('Y-m-d') : $bg_date;
		$bg_hour = encoding((isset($_POST['hour']) ? $_POST['hour'] : ''));
		$bg_hour = ($bg_hour == '') ? date('H:i:s') : $bg_hour;
		$bg_tag = encoding((isset($_POST['tag']) ? $_POST['tag'] : array()));
		$bg_tag = implode(":", $bg_tag);
		if (in_array("all", $bg_tag)) {
			$bg_tag="all";
		}
		$bg_show_title_class=encoding((isset($_POST['show_title_class']) ? $_POST['show_title_class'] : ''));
		$bg_show_title=encoding((isset($_POST['show_title']) ? $_POST['show_title'] : ''));
		$bg_show_description=encoding((isset($_POST['show_description']) ? $_POST['show_description'] : ''));
		$bg_show_username=encoding((isset($_POST['show_username']) ? $_POST['show_username'] : ''));
		$bg_show_time=encoding((isset($_POST['show_time']) ? $_POST['show_time'] : ''));
		$bg_show_date=encoding((isset($_POST['show_date']) ? $_POST['show_date'] : ''));
		$bg_prepare_module_content="{type_plan{class{".
		$bg_show_title_class."}:plan{".
		$bg_show_title.":".
		$bg_show_description.":".
		$bg_show_username.":".
		$bg_show_time.":".
		$bg_show_date."}}}";
		$bg_error = array(
			"Tag:input:fill:30" => $bg_tag,
			"Title:input:fill:30" => $bg_title
		);
		
		$pay_data = array();
		foreach ($bg_pay_amount as $key => $value){
			if(!empty($bg_pay_amount[$key])){
				$pay_data[$key] = array('amount' => $bg_pay_amount[$key], 'frequence' => $bg_pay_frequence[$key]);
			}
		}
		
		error_message(true, $bg_error);
		if (empty($_SESSION['error_message'])){
			$select1=$bg_connexion->prepare("SELECT class FROM ".HASH."_modules WHERE title = :al_title");
			$select1->bindParam(':al_title', $bg_title);
			$select1->execute();
			$bg_fetch_modules = $select1->rowCount();
			if($bg_fetch_modules > 0){}
			else{
				$query = $bg_connexion->prepare("INSERT INTO ".HASH."_modules (title, class, modules, order1, date, time, tag, username, published) VALUES (:title, :class, :modules, :order1, :date, :time, :tag, :username, :published)");
				$query->execute(
					array(
					':title'=>$bg_title,
					':class'=>format_tag($bg_title),
					':modules'=>$bg_prepare_module_content,
					':order1'=>'1',
					':date'=>$bg_date,
					':time'=>$bg_hour,
					':tag'=>$bg_tag,
					':username'=>$_SESSION['pseudom'],
					':published'=>'0'
					)
				);
				
				$query = $bg_connexion->prepare("INSERT INTO ".HASH."_plans (module_id, pay) VALUES (:module_id, :pay)");
				$query->execute(
					array(
					':module_id'=> $bg_connexion->lastInsertId(),
					':pay'=> json_encode($pay_data)
					)
				);
				
				$query = $bg_connexion->prepare("INSERT INTO ".HASH."_class (class, date, time, order1) VALUES (:class, :date, :time, :order1)");
				$query->execute(
					array(
					':class'=>format_tag($bg_title),
					':date'=>$bg_date,
					':time'=>$bg_hour,
					':order1'=>'1'
					)
				);
			}
		}
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}

	function post_update_plan ($bg_connexion) {
		$bg_id = (isset($_GET['id']) ? $_GET['id'] : '');
		$bg_title = encoding((isset($_POST['title']) ? $_POST['title'] : ''));
		$bg_pay_amount = encoding((isset($_POST['pay_amount']) ? $_POST['pay_amount'] : ''));
		$bg_pay_frequence = encoding((isset($_POST['pay_frequence']) ? $_POST['pay_frequence'] : ''));
		$bg_class =  encoding((isset($_POST['class']) ? $_POST['class'] : ''));
		$bg_date = encoding((isset($_POST['date']) ? $_POST['date'] : ''));
		$bg_date = ($bg_date == '') ? date('Y-m-d') : $bg_date;
		$bg_hour = encoding((isset($_POST['hour']) ? $_POST['hour'] : ''));
		$bg_hour = ($bg_hour == '') ? date('H:i:s') : $bg_hour;
		$bg_tag = encoding((isset($_POST['tag']) ? $_POST['tag'] : array()));
		$bg_tag = implode(":", $bg_tag);
		if (in_array("all", $bg_tag)) {
			$bg_tag="all";
		}
		$bg_show_title_class=encoding((isset($_POST['show_title_class']) ? $_POST['show_title_class'] : ''));
		$bg_show_title=encoding((isset($_POST['show_title']) ? $_POST['show_title'] : ''));
		$bg_show_description=encoding((isset($_POST['show_description']) ? $_POST['show_description'] : ''));
		$bg_show_username=encoding((isset($_POST['show_username']) ? $_POST['show_username'] : ''));
		$bg_show_time=encoding((isset($_POST['show_time']) ? $_POST['show_time'] : ''));
		$bg_show_date=encoding((isset($_POST['show_date']) ? $_POST['show_date'] : ''));
		$bg_prepare_module_content="{type_plan{class{".
		$bg_show_title_class."}:plan{".
		$bg_show_title.":".
		$bg_show_description.":".
		$bg_show_username.":".
		$bg_show_time.":".
		$bg_show_date."}}}";
		$bg_error = array(
			"Title:input:fill:30" => $bg_title
		);
		error_message(true, $bg_error);
		
		$pay_data = array();
		foreach($bg_pay_amount as $key => $value){
			if(!empty($bg_pay_amount[$key])){
				$pay_data[$key] = array('amount' => $bg_pay_amount[$key], 'frequence' => $bg_pay_frequence[$key]);
			}
		}

		if (empty($_SESSION['error_message'])){
			$update_plan = $bg_connexion->prepare("UPDATE ".HASH."_class SET class=? WHERE class=?");
			$update_plan->execute(array(format_tag($bg_title),$bg_class));
			$update_plan = $bg_connexion->prepare("UPDATE ".HASH."_modules SET modules=?,tag=?,class=?,title=?,date=?,time=? WHERE id=?");
			$update_plan->execute(
				array(
					$bg_prepare_module_content,
					$bg_tag,
					format_tag($bg_title),
					$bg_title,
					$bg_date,
					$bg_hour,
					$bg_id
				)
			);
			$update_plan = $bg_connexion->prepare("UPDATE ".HASH."_plans SET pay=? WHERE module_id=?");
			$update_plan->execute(
				array(
					json_encode($pay_data),
					$bg_id
				)
			);
			
		}
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}
	
	function get_plan_list_data ($bg_connexion) {
		$bg_tag = (isset($_GET['tag']) ? $_GET['tag'] : '');
		$condition_extra = '';
		if(!empty($bg_tag) && $bg_tag != 'all'){
			$condition_extra = " AND tag LIKE '%".$bg_tag."%'";
		}
		$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_modules WHERE modules LIKE '%type_plan%'".$condition_extra);
		$select1->execute();
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_modules = $select1->fetchAll();
		
		$data = array();
		
		foreach($bg_fetch_modules as $key => $value){		
			$data['module'][$value->id] = $value;
			
			$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_plans WHERE module_id = :al_id");
			$select1->bindParam(':al_id', $value->id);
			$select1->execute();
			$select1->setFetchMode(PDO::FETCH_OBJ);
			$bg_fetch_plans = $select1->fetch();
			$data['plans'][$value->id] = $bg_fetch_plans;
		}
		
		$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_modules WHERE modules LIKE '%type_expense%'".$condition_extra);
		$select1->execute();
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_modules = $select1->fetchAll();
		
		foreach($bg_fetch_modules as $key => $value){
			$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_expenses WHERE class = '".$value->class."'".$condition_extra);
			$select1->execute();
			$select1->setFetchMode(PDO::FETCH_OBJ);
			$bg_fetch_expenses = $select1->fetchAll();
			$data['expenses'][$value->id]['data'] = $value;
			$data['expenses'][$value->id]['expenses_item'] = $bg_fetch_expenses;
		}
		
		$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_expenses WHERE class = '0'".$condition_extra);
		$select1->execute();
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_expenses = $select1->fetchAll();
		$data['other_expenses'] = $bg_fetch_expenses;
		
		return $data;
	}

	function list_plan ($bg_connexion) {
		$data = get_plan_list_data($bg_connexion);
		return render(array('data' => $data, 'bg_connexion' => $bg_connexion), 'plan', 'list_plan');
	}

	function export_plan ($bg_connexion) {
		require_once __DIR__.'/../../../vendor/autoload.php';
		$data = get_plan_list_data($bg_connexion);
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$plans_sheet = $spreadsheet->getActiveSheet();
		$expenses_sheet = $spreadsheet->createSheet();
		$other_expenses_sheet = $spreadsheet->createSheet();
		$projection_sheet = $spreadsheet->createSheet();
		$monthly_sheet = $spreadsheet->createSheet();

		$prepare_sheet = function($sheet, $title, $headers) {
			$sheet->setTitle($title);
			foreach($headers as $index => $header) {
				$cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1).'1';
				$sheet->setCellValueExplicit($cell, $header, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			}
			$last_column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($headers));
			$sheet->getStyle('A1:'.$last_column.'1')->applyFromArray(array(
				'font' => array('bold' => true, 'color' => array('rgb' => 'FFFFFF')),
				'fill' => array('fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => array('rgb' => '365F73'))
			));
			$sheet->freezePane('A2');
			return $last_column;
		};
		$append_row = function($sheet, $row) {
			$row_number = $sheet->getHighestRow() + 1;
			foreach(array_values($row) as $index => $value) {
				$cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1).$row_number;
				if(is_int($value) || is_float($value)) {
					$sheet->setCellValue($cell, $value);
				} else {
					$sheet->setCellValueExplicit($cell, (string)$value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
				}
			}
		};
		$finish_sheet = function($sheet, $last_column) {
			$last_row = max(1, $sheet->getHighestRow());
			$sheet->setAutoFilter('A1:'.$last_column.$last_row);
			for($column = 1; $column <= \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($last_column); $column++) {
				$sheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			}
		};

		$plans_headers = array('Class', 'Plan', 'Username', 'Date', 'Time', 'Tags', 'Payment Amount', 'Payment Period');
		$plans_last_column = $prepare_sheet($plans_sheet, 'Plans', $plans_headers);
		$expenses_headers = array('Category', 'Class', 'Title', 'Username', 'Date', 'Time', 'Tags', 'Cost', 'Frequency', 'Content', 'Published');
		$expenses_last_column = $prepare_sheet($expenses_sheet, 'Expenses', $expenses_headers);
		$other_headers = array('Class', 'Title', 'Username', 'Date', 'Time', 'Tags', 'Cost', 'Frequency', 'Content', 'Published');
		$other_last_column = $prepare_sheet($other_expenses_sheet, 'Other Expenses', $other_headers);
		$projection_headers = array('Day', 'Week', 'Month', 'Date', 'Time', 'Daily Pay', 'Daily Expense', 'Pay Total', 'Expense Total', 'Profit');
		$projection_last_column = $prepare_sheet($projection_sheet, 'Daily Projection', $projection_headers);
		$monthly_headers = array('Month', 'Total Pay', 'Total Expense', 'Closing Pay Total', 'Closing Expense Total', 'Month Profit');
		$monthly_last_column = $prepare_sheet($monthly_sheet, 'Monthly Totals', $monthly_headers);

		$normalize_amount = function($amount, $frequency) {
			if(!is_numeric($amount)) { return null; }
			$amount = (float)$amount;
			if($frequency == 'daily') { return $amount; }
			if($frequency == 'weekly') { return $amount / (365 / 52); }
			if($frequency == 'monthly') { return $amount / (365 / 12); }
			if($frequency == 'yearly') { return $amount / 365; }
			return null;
		};
		$pay_amount = array();
		$expense_amount = array();
		$projection_start = null;
		$pay_index = 0;
		$add_projection_expense = function($date, $time, $amount, $frequency) use (&$expense_amount, $normalize_amount) {
			$normalized_amount = $normalize_amount($amount, $frequency);
			if($normalized_amount === null) { return; }
			$date_key = str_replace('-', '', (string)$date);
			$time_key = str_replace(':', '', (string)$time);
			if($date_key == '' || $time_key == '') { return; }
			$expense_amount[$date_key.$time_key][] = $normalized_amount;
		};

		if(isset($data['module'])) {
			foreach($data['module'] as $module_id => $module) {
				if($module->published != '1') { continue; }
				$plan = isset($data['plans'][$module_id]) ? $data['plans'][$module_id] : null;
				$pay_items = ($plan && isset($plan->pay)) ? json_decode($plan->pay, true) : array();
				if(!is_array($pay_items)) { $pay_items = array(); }
				$base_row = array(
					isset($module->class) ? $module->class : '',
					isset($module->title) ? $module->title : '',
					isset($module->username) ? $module->username : '',
					isset($module->date) ? $module->date : '',
					isset($module->time) ? $module->time : '',
					isset($module->tag) ? $module->tag : ''
				);
				if(empty($pay_items)) {
					$append_row($plans_sheet, array_merge($base_row, array('', '')));
				}
				foreach($pay_items as $pay_item) {
					if(!is_array($pay_item)) { continue; }
					$frequency = isset($pay_item['frequence']) ? $pay_item['frequence'] : '';
					$amount = isset($pay_item['amount']) ? $pay_item['amount'] : '';
					$append_row($plans_sheet, array_merge($base_row, array(is_numeric($amount) ? (float)$amount : $amount, $frequency)));
					$normalized_amount = $normalize_amount($amount, $frequency);
					if($normalized_amount !== null) {
						$pay_amount['Pay ['.$pay_index.']'] = $normalized_amount;
						$plan_start = strtotime((isset($module->date) ? $module->date : '').' '.(isset($module->time) ? $module->time : ''));
						if($plan_start !== false && ($projection_start === null || $plan_start < $projection_start)) {
							$projection_start = $plan_start;
						}
					}
					$pay_index++;
				}
			}
		}

		if(isset($data['expenses'])) {
			foreach($data['expenses'] as $expense_group) {
				$module = $expense_group['data'];
				if($module->published != '1' || empty($expense_group['expenses_item'])) { continue; }
				foreach($expense_group['expenses_item'] as $expense) {
					$append_row($expenses_sheet, array(
						isset($module->title) ? $module->title : '',
						isset($expense->class) ? $expense->class : '',
						isset($expense->title) ? $expense->title : '',
						isset($expense->username) ? $expense->username : '',
						isset($expense->date) ? $expense->date : '',
						isset($expense->time) ? $expense->time : '',
						isset($expense->tag) ? $expense->tag : '',
						isset($expense->cost) && is_numeric($expense->cost) ? (float)$expense->cost : '',
						isset($expense->frequence) ? $expense->frequence : '',
						isset($expense->content) ? $expense->content : '',
						isset($expense->publish) ? $expense->publish : ''
					));
					$add_projection_expense(isset($module->date) ? $module->date : '', isset($module->time) ? $module->time : '', isset($expense->cost) ? $expense->cost : '', isset($expense->frequence) ? $expense->frequence : '');
				}
			}
		}
		if(isset($data['other_expenses'])) {
			foreach($data['other_expenses'] as $expense) {
				if($expense->publish != '1') { continue; }
				$append_row($other_expenses_sheet, array(
					'No class',
					isset($expense->title) ? $expense->title : '',
					isset($expense->username) ? $expense->username : '',
					isset($expense->date) ? $expense->date : '',
					isset($expense->time) ? $expense->time : '',
					isset($expense->tag) ? $expense->tag : '',
					isset($expense->cost) && is_numeric($expense->cost) ? (float)$expense->cost : '',
					isset($expense->frequence) ? $expense->frequence : '',
					isset($expense->content) ? $expense->content : '',
					isset($expense->publish) ? $expense->publish : ''
				));
				$add_projection_expense(isset($expense->date) ? $expense->date : '', isset($expense->time) ? $expense->time : '', isset($expense->cost) ? $expense->cost : '', isset($expense->frequence) ? $expense->frequence : '');
			}
		}

		if($projection_start === null) { $projection_start = time(); }
		$projection_start_date = date('Y-m-d H:i:s', $projection_start);
		$weekly_count = 1;
		$month_count = 1;
		$monthly_totals = array();
		$grand_pay_total = 0;
		$grand_expense_total = 0;
		for($day_number = 1; $day_number <= 365; $day_number++) {
			$timestamp = strtotime($projection_start_date.' +'.$day_number.' day');
			$date = date('Y-m-d', $timestamp);
			$time = date('H:i:s', $timestamp);
			if(date('l', $timestamp) == 'Monday') { $weekly_count++; }
			if(date('j', $timestamp) == '1') { $month_count++; }
			$daily_pay = array_sum($pay_amount);
			$pay_total = $daily_pay * $day_number;
			$daily_expense = 0;
			$expense_total = 0;
			$timestamp_key = intval(date('YmdHis', $timestamp));
			foreach($expense_amount as $expense_date_key => $amounts) {
				if(intval($expense_date_key) <= $timestamp_key) {
					$daily_expense += array_sum($amounts);
				}
			}
			$expense_total = $daily_expense * $day_number;
			$month_key = date('Y-m', $timestamp);
			$profit = $pay_total - $expense_total;
			$append_row($projection_sheet, array($day_number, $weekly_count, $month_count, $date, $time, $daily_pay, $daily_expense, $pay_total, $expense_total, $profit));
			if(!isset($monthly_totals[$month_key])) {
				$monthly_totals[$month_key] = array('pay' => 0, 'expense' => 0, 'closing_pay' => 0, 'closing_expense' => 0);
			}
			$monthly_totals[$month_key]['pay'] += $daily_pay;
			$monthly_totals[$month_key]['expense'] += $daily_expense;
			$monthly_totals[$month_key]['closing_pay'] = $pay_total;
			$monthly_totals[$month_key]['closing_expense'] = $expense_total;
			$grand_pay_total += $daily_pay;
			$grand_expense_total += $daily_expense;
		}

		foreach($monthly_totals as $month_key => $totals) {
			$month_profit = $totals['pay'] - $totals['expense'];
			$append_row($monthly_sheet, array(date('F Y', strtotime($month_key.'-01')), $totals['pay'], $totals['expense'], $totals['closing_pay'], $totals['closing_expense'], $month_profit));
		}
		$append_row($monthly_sheet, array('GRAND TOTAL', $grand_pay_total, $grand_expense_total, '', '', $grand_pay_total - $grand_expense_total));
		foreach(array(
			array($plans_sheet, $plans_last_column),
			array($expenses_sheet, $expenses_last_column),
			array($other_expenses_sheet, $other_last_column),
			array($projection_sheet, $projection_last_column),
			array($monthly_sheet, $monthly_last_column)
		) as $sheet_info) {
			$finish_sheet($sheet_info[0], $sheet_info[1]);
		}

		$filename = 'budget-layers-list-plan-'.date('Ymd-His').'.xlsx';
		while(ob_get_level() > 0) { ob_end_clean(); }
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		$spreadsheet->disconnectWorksheets();
		exit;
	}

	function calendar_plan ($bg_connexion) {
		$data = get_plan_list_data($bg_connexion);
		return render(array('data' => $data, 'bg_connexion' => $bg_connexion), 'plan', 'calendar_plan');
	}

	function plan ($bg_connexion) {
		$bg_id_module=(isset($_GET['id']) ? $_GET['id'] : '');
		$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_modules WHERE id = :al_id_plan");
		$select1->bindParam(':al_id_plan', $bg_id_module);
		$select1->execute();
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_modules = $select1->fetch();
		
		$select1=$bg_connexion->prepare("SELECT * FROM ".HASH."_plans WHERE module_id = :al_id_plan");
		$select1->bindParam(':al_id_plan', $bg_id_module);
		$select1->execute();
		$select1->setFetchMode(PDO::FETCH_OBJ);
		$bg_fetch_plans = $select1->fetch();
		
		return render(array('bg_fetch_modules' => $bg_fetch_modules, 'bg_fetch_plans' => $bg_fetch_plans, 'bg_id_module' => $bg_id_module, 'bg_connexion' => $bg_connexion), 'plan', 'edit_plan');
	}
	
?>