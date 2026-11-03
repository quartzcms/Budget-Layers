<?php
	function calendar_plan ($bg_connexion) {
		$data = get_plan_list_data($bg_connexion);
		return render(array('data' => $data, 'bg_connexion' => $bg_connexion), 'calendar', 'calendar_plan');
	}
?>
