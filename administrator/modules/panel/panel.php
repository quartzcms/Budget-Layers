<?php
	function cpanel ($bg_connexion) {
		return render(array('bg_connexion' => $bg_connexion), 'panel', 'panel');
	}
?>