<?php
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
?>
