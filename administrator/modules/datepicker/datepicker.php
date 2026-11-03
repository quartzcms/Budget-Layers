<?php
	function datepicker_head () {
		return '<link rel="stylesheet" href="../modules/datepicker/assets/build/jquery.datetimepicker.min.css" />'."\n".
			'<script type="text/javascript" src="../modules/datepicker/assets/build/jquery.datetimepicker.full.min.js"></script>'."\n".
			'<script type="text/javascript">$(document).ready(function () {'.
			'if($("#date").length > 0){'.
			'$("#date").datetimepicker({format: "Y-m-d", timepicker: false});'.
			'$("#time").datetimepicker({format: "H:i:s", datepicker: false});'.
			'}});</script>'."\n";
	}
?>
