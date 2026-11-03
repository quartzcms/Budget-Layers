<?php
	function chosen_head () {
		return '<script type="text/javascript" src="../modules/chosen/assets/chosen.jquery.js"></script>'."\n".
			'<link rel="stylesheet" href="../modules/chosen/assets/chosen.css">'."\n".
			'<script type="text/javascript">$(document).ready(function () { $(\'.chosen-select\').chosen({width: \'100%\', allow_single_deselect: true }); });</script>'."\n";
	}
?>
