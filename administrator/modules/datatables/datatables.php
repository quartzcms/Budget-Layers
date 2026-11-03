<?php
	function datatables_head () {
		return '<link rel="stylesheet" href="../modules/datatables/assets/jquery.dataTables.min.css" />'."\n".
			'<script type="text/javascript" src="../modules/datatables/assets/jquery.dataTables.min.js"></script>'."\n".
			'<script type="text/javascript">$(document).ready(function () {'.
			'$("table.list").not(".total").each(function () {'.
			'if($(this).find("thead th").length > 0){'.
			'$(this).DataTable({paging: false, info: false, autoWidth: false, order: [], columnDefs: [{targets: "no-sort", orderable: false}]});'.
			'}});});</script>'."\n";
	}
?>
