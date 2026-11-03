<?php
$calendar_year = isset($_GET['year']) ? intval($_GET['year']) : intval(date('Y'));
$calendar_month = isset($_GET['month']) ? intval($_GET['month']) : intval(date('n'));
if($calendar_year < 1970 || $calendar_year > 9999) { $calendar_year = intval(date('Y')); }
if($calendar_month < 1 || $calendar_month > 12) { $calendar_month = intval(date('n')); }
$month_start = new DateTime(sprintf('%04d-%02d-01', $calendar_year, $calendar_month));
$month_title = $month_start->format('F Y');
$calendar_events = array();
$calendar_categories = array();
$add_calendar_event = function($date, $time, $title, $type, $category_key, $category_label, $detail) use (&$calendar_events, &$calendar_categories) {
	$date = (string)$date;
	$time = (string)$time;
	if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) { return; }
	if($time == '') { $time = '00:00:00'; }
	$timestamp = strtotime($date.' '.$time);
	if($timestamp === false || date('Y-m-d', $timestamp) != $date) { return; }
	$category_id = 'category:'.$category_key;
	$calendar_categories[$category_id] = $category_label;
	$calendar_events[] = array(
		'date' => date('Y-m-d', $timestamp),
		'time' => date('H:i', $timestamp),
		'timestamp' => $timestamp,
		'title' => $title,
		'type' => $type,
		'category_id' => $category_id,
		'category' => $category_label,
		'detail' => $detail
	);
};
$add_recurring_calendar_events = function($date, $time, $title, $type, $category_key, $category_label, $detail, $frequency) use ($add_calendar_event, $month_start) {
	$date = (string)$date;
	$time = (string)$time;
	if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) { return; }
	if($time == '') { $time = '00:00:00'; }
	$timestamp = strtotime($date.' '.$time);
	if($timestamp === false || date('Y-m-d', $timestamp) != $date) { return; }
	$frequency = strtolower((string)$frequency);
	$start = new DateTime($date.' '.$time);
	$end = clone $start;
	$end->modify('+5 years');
	$anchor_day = intval($start->format('j'));
	$month_offset = 0;
	$year_offset = 0;
	$occurrence = clone $start;
	while($occurrence->getTimestamp() <= $end->getTimestamp()) {
		if($occurrence->format('Y-m') == $month_start->format('Y-m')) {
			$add_calendar_event($occurrence->format('Y-m-d'), $occurrence->format('H:i:s'), $title, $type, $category_key, $category_label, $detail);
		}
		if($frequency == 'daily') {
			$occurrence->modify('+1 day');
		} elseif($frequency == 'weekly') {
			$occurrence->modify('+1 week');
		} elseif($frequency == 'monthly') {
			$month_offset++;
			$target_month = clone $start;
			$target_month->modify('first day of this month');
			$target_month->modify('+'.$month_offset.' months');
			$occurrence = clone $target_month;
			$occurrence->setDate(intval($target_month->format('Y')), intval($target_month->format('n')), min($anchor_day, intval($target_month->format('t'))));
			$occurrence->setTime(intval($start->format('H')), intval($start->format('i')), intval($start->format('s')));
		} elseif($frequency == 'yearly') {
			$year_offset++;
			$target_month = clone $start;
			$target_month->setDate(intval($start->format('Y')) + $year_offset, intval($start->format('n')), 1);
			$occurrence = clone $target_month;
			$occurrence->setDate(intval($target_month->format('Y')), intval($target_month->format('n')), min($anchor_day, intval($target_month->format('t'))));
			$occurrence->setTime(intval($start->format('H')), intval($start->format('i')), intval($start->format('s')));
		} else {
			break;
		}
	}
};

if(isset($data['module'])) {
	foreach($data['module'] as $module_id => $module) {
		if($module->published == '1' && isset($data['plans'][$module_id])) {
			$pay_items = json_decode(isset($data['plans'][$module_id]->pay) ? $data['plans'][$module_id]->pay : '', true);
			if(is_array($pay_items) && count($pay_items)) {
				$pay_number = 1;
				foreach($pay_items as $pay_item) {
					$frequency = isset($pay_item['frequence']) ? $pay_item['frequence'] : '';
					$amount = isset($pay_item['amount']) ? $pay_item['amount'] : '';
					$detail = $amount.' / '.$frequency;
					$title = $module->title.' (Pay '.$pay_number.')';
					$add_recurring_calendar_events($module->date, $module->time, $title, 'Plan', $module->class, $module->title, $detail, $frequency);
					$pay_number++;
				}
			} else {
				$add_calendar_event($module->date, $module->time, $module->title, 'Plan', $module->class, $module->title, 'Plan start');
			}
		}
	}
}
if(isset($data['expenses'])) {
	foreach($data['expenses'] as $expense_group) {
		$module = $expense_group['data'];
		if($module->published != '1' || empty($expense_group['expenses_item'])) { continue; }
		foreach($expense_group['expenses_item'] as $expense) {
			if(!isset($expense->publish) || $expense->publish != '1') { continue; }
			$date = !empty($expense->date) ? $expense->date : $module->date;
			$time = !empty($expense->time) ? $expense->time : $module->time;
			$frequency = isset($expense->frequence) ? $expense->frequence : '';
			$detail = $expense->cost.' / '.$frequency;
			$add_recurring_calendar_events($date, $time, $expense->title, 'Expense', $module->class, $module->title, $detail, $frequency);
		}
	}
}
if(isset($data['other_expenses'])) {
	foreach($data['other_expenses'] as $expense) {
		if($expense->publish != '1') { continue; }
		$tags = array_filter(explode(':', (string)$expense->tag), 'strlen');
		$category_label = count($tags) ? implode(', ', $tags) : 'Other expenses';
		$category_key = 'other:'.strtolower($category_label);
		$frequency = isset($expense->frequence) ? $expense->frequence : '';
		$detail = $expense->cost.' / '.$frequency;
		$add_recurring_calendar_events($expense->date, $expense->time, $expense->title, 'Expense', $category_key, $category_label, $detail, $frequency);
	}
}
usort($calendar_events, function($left, $right) {
	if($left['timestamp'] == $right['timestamp']) { return strcmp($left['title'], $right['title']); }
	return ($left['timestamp'] < $right['timestamp']) ? -1 : 1;
});
$events_by_date = array();
foreach($calendar_events as $event) {
	if(substr($event['date'], 0, 7) == $month_start->format('Y-m')) {
		$events_by_date[$event['date']][] = $event;
	}
}
$grid_start = clone $month_start;
$grid_start->modify('-'.($month_start->format('N') - 1).' days');
$previous_month = clone $month_start;
$previous_month->modify('-1 month');
$next_month = clone $month_start;
$next_month->modify('+1 month');
$calendar_tag_query = isset($_GET['tag']) ? '&amp;tag='.urlencode($_GET['tag']) : '';
?>
<?php echo buildContainer($bg_connexion); ?>
<style>
	.plan-calendar { width: 100%; color: #343a40; }
	.plan-calendar-layout { display: grid; grid-template-columns: 230px minmax(0, 1fr); gap: 16px; align-items: start; }
	.plan-calendar-sidebar { padding: 16px; background: #333; color: #fff; border-radius: 4px; }
	.plan-calendar-sidebar h1 { margin: 0 0 14px; color: #fff; font-size: 24px; }
	.plan-calendar-sidebar .btn { color: #fff; }
	.plan-calendar-actions { display: flex; gap: 6px; }
	.plan-calendar-actions .btn { flex: 1; padding-left: 6px; padding-right: 6px; }
	.plan-calendar-list-link { display: block; margin-top: 8px; }
	.plan-calendar-sidebar h2 { margin: 20px 0 10px; color: #fff; font-size: 16px; }
	.plan-calendar-legend { display: flex; flex-direction: column; gap: 8px; }
	.plan-calendar-legend-item { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; }
	.plan-calendar-swatch { display: inline-block; width: 11px; height: 11px; border-radius: 2px; }
	.plan-calendar-weekdays, .plan-calendar-grid { display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); }
	.plan-calendar-grid { height: calc(100vh - 250px); min-height: 720px; grid-template-rows: repeat(6, minmax(0, 1fr)); }
	.plan-calendar-weekdays, .plan-calendar-grid { background-color: #fff; color: #333; }
	.plan-calendar-weekday { padding: 9px 6px; background-color: #fff; font-weight: bold; border-bottom: 2px solid #ddd; border-right: 1px solid rgba(119,119,119,.2); }
	.plan-calendar-day { min-width: 0; min-height: 118px; padding: 6px; border: 1px solid rgba(119,119,119,.25); background-color: #fff; overflow-x: hidden; overflow-y: auto; }
	.plan-calendar-day.is-outside { background-color: #fff; }
	.plan-calendar-day.is-today { box-shadow: inset 0 0 0 2px #d18c32; }
	.plan-calendar-date { display: block; margin: 0 0 5px; font-size: 12px; font-weight: bold; }
	.plan-calendar-event { display: block; margin: 3px 0; padding: 4px 5px; border: 1px solid rgba(119,119,119,.3); border-left: 4px solid hsl(var(--category-hue), 62%, 42%); background-color: #fff; color: #333; font-size: 11px; line-height: 1.25; overflow-wrap: anywhere; }
	.plan-calendar-event-title { display: block; font-weight: bold; }
	.plan-calendar-event-meta { display: block; margin-top: 2px; font-size: 10px; }
	.plan-calendar-event-type { display: inline-block; margin-right: 3px; font-weight: normal; }
	@media (max-width: 767px) {
		.plan-calendar-layout { grid-template-columns: 1fr; }
		.plan-calendar-sidebar { padding: 12px; }
		.plan-calendar-sidebar h1 { font-size: 22px; }
		.plan-calendar-legend { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); }
		.plan-calendar-grid { height: auto; min-height: calc(100vh - 210px); grid-template-rows: repeat(6, minmax(92px, 1fr)); }
		.plan-calendar-day { min-height: 92px; padding: 3px; }
		.plan-calendar-weekday { padding: 7px 2px; font-size: 11px; }
		.plan-calendar-event { padding: 3px; font-size: 9px; border-left-width: 3px; }
		.plan-calendar-event-meta { font-size: 9px; }
	}
</style>
<div class="plan-calendar">
	<div class="plan-calendar-layout">
		<aside class="plan-calendar-sidebar">
		<h1><?php echo htmlspecialchars($month_title, ENT_QUOTES, 'UTF-8'); ?></h1>
		<div class="plan-calendar-actions">
			<a class="btn btn-primary" href="index.php?page=calendar_plan&amp;year=<?php echo $previous_month->format('Y'); ?>&amp;month=<?php echo $previous_month->format('n'); ?><?php echo $calendar_tag_query; ?>" aria-label="Previous month">&laquo;</a>
			<a class="btn btn-primary" href="index.php?page=calendar_plan&amp;year=<?php echo date('Y'); ?>&amp;month=<?php echo date('n'); ?><?php echo $calendar_tag_query; ?>">Today</a>
			<a class="btn btn-primary" href="index.php?page=calendar_plan&amp;year=<?php echo $next_month->format('Y'); ?>&amp;month=<?php echo $next_month->format('n'); ?><?php echo $calendar_tag_query; ?>" aria-label="Next month">&raquo;</a>
		</div>
		<a class="btn btn-info plan-calendar-list-link" href="index.php?page=list_plan<?php if(isset($_GET['tag'])) { echo '&amp;tag='.urlencode($_GET['tag']); } ?>">List</a>
		<h2>Categories</h2>
		<div class="plan-calendar-legend">
		<?php foreach($calendar_categories as $category_id => $category_label) {
			$category_hue = hexdec(substr(md5($category_id), 0, 6)) % 360;
		?>
			<span class="plan-calendar-legend-item"><span class="plan-calendar-swatch" style="background-color: hsl(<?php echo $category_hue; ?>, 62%, 42%);"></span><?php echo htmlspecialchars($category_label, ENT_QUOTES, 'UTF-8'); ?></span>
		<?php } ?>
		</div>
		</aside>
		<main class="plan-calendar-main">
	<div class="plan-calendar-weekdays">
		<?php foreach(array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') as $weekday) { ?>
			<div class="plan-calendar-weekday text-muted text-center"><?php echo $weekday; ?></div>
		<?php } ?>
	</div>
	<div class="plan-calendar-grid">
		<?php for($day_offset = 0; $day_offset < 42; $day_offset++) {
			$day = clone $grid_start;
			$day->modify('+'.$day_offset.' days');
			$day_key = $day->format('Y-m-d');
			$day_classes = 'plan-calendar-day';
			if($day->format('n') != $calendar_month) { $day_classes .= ' is-outside text-muted'; }
			if($day_key == date('Y-m-d')) { $day_classes .= ' is-today'; }
		?>
			<div class="<?php echo $day_classes; ?>">
				<span class="plan-calendar-date"><?php echo $day->format('j'); ?></span>
				<?php if(isset($events_by_date[$day_key])) { foreach($events_by_date[$day_key] as $event) {
					$category_hue = hexdec(substr(md5($event['category_id']), 0, 6)) % 360;
				?>
					<div class="plan-calendar-event" style="--category-hue: <?php echo $category_hue; ?>;" title="<?php echo htmlspecialchars($event['category'].' - '.$event['detail'], ENT_QUOTES, 'UTF-8'); ?>">
						<span class="plan-calendar-event-title"><span class="plan-calendar-event-type"><?php echo htmlspecialchars($event['type'], ENT_QUOTES, 'UTF-8'); ?>:</span><?php echo htmlspecialchars($event['title'], ENT_QUOTES, 'UTF-8'); ?></span>
						<span class="plan-calendar-event-meta"><?php echo htmlspecialchars($event['time'].' - '.$event['detail'], ENT_QUOTES, 'UTF-8'); ?></span>
					</div>
				<?php } } ?>
			</div>
		<?php } ?>
	</div>
		</main>
	</div>
</div>
