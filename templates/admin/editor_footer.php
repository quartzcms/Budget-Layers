<?php
	if($_SESSION['editor']=='ckeditor'){
?>
	<script type="text/javascript">
		$(document).ready(function() {
			$("textarea").each(function(index, element) {
				var element_id = $(element).attr('id');
				if($('#' + element_id).length > 0){
					CKEDITOR.replace(element_id, {
						skin: 'moono-lisa',
						allowedContent: true,
						protectedSource:[/<\?[\s\S]*?\?>/g],
						extraPlugins: 'filetools,popup,filebrowser',
						height: 60,
						toolbar: [
							{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
							{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Scayt' ] },
							{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
							{ name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar' ] },
							{ name: 'tools', items: [ 'Maximize' ] },
							{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source' ] },
							{ name: 'others', items: [ '-' ] },
							'/',
							{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Strike', '-', 'RemoveFormat' ] },
							{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
							{ name: 'styles', items: [ 'Styles', 'Format' ] },
							{ name: 'about', items: [ 'About' ] }
						]
					});
				}
			});
		});
	</script>
<?php 
	} 
?>
