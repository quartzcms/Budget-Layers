(function ($) {
	var dragged = null;
	var skip = 'input, select, textarea, a, button, label';

	function orderInputs($tbody) {
		return $tbody.children('tr').map(function () {
			return $(this).find('input[name^="order["]').first()[0] || null;
		}).get();
	}

	function renumber($tbody, oldValues) {
		var inputs = orderInputs($tbody);
		var sorted = oldValues.slice().sort(function (a, b) { return a - b; });
		var unique = sorted.every(function (v, i) { return !isNaN(v) && (i === 0 || v !== sorted[i - 1]); });
		$.each(inputs, function (i, input) {
			$(input).val(unique ? sorted[i] : i + 1);
		});
	}

	$(document).on('mousedown', 'tr.rowdrag-row', function (e) {
		if ($(e.target).closest(skip).length === 0) {
			this.draggable = true;
		}
	}).on('mouseup', 'tr.rowdrag-row', function () {
		this.draggable = false;
	}).on('dragstart', 'tr.rowdrag-row', function (e) {
		dragged = this;
		$(this).addClass('rowdrag-moving');
		if (e.originalEvent.dataTransfer) {
			e.originalEvent.dataTransfer.effectAllowed = 'move';
			e.originalEvent.dataTransfer.setData('text/plain', '');
		}
	}).on('dragover', 'tr.rowdrag-row', function (e) {
		if (!dragged || $(this).parent()[0] !== $(dragged).parent()[0] || this === dragged) {
			return;
		}
		e.preventDefault();
		var rect = this.getBoundingClientRect();
		if (e.originalEvent.clientY < rect.top + rect.height / 2) {
			$(dragged).insertBefore(this);
		} else {
			$(dragged).insertAfter(this);
		}
	}).on('dragend', 'tr.rowdrag-row', function () {
		var $tbody = $(this).parent();
		this.draggable = false;
		$(this).removeClass('rowdrag-moving');
		if (dragged) {
			renumber($tbody, $tbody.data('rowdrag-values') || []);
			$tbody.data('rowdrag-values', orderInputs($tbody).map(function (i) { return parseInt($(i).val(), 10); }));
		}
		dragged = null;
	}).on('dragstart', 'tr.rowdrag-row', function () {
		var $tbody = $(this).parent();
		$tbody.data('rowdrag-values', orderInputs($tbody).map(function (i) { return parseInt($(i).val(), 10); }));
	});

	$(function () {
		$('table.list').not('.total').each(function () {
			var $rows = $(this).children('tbody').children('tr').filter(function () {
				return $(this).find('input[name^="order["]').length > 0;
			});
			$rows.addClass('rowdrag-row');
		});
	});
})(jQuery);
