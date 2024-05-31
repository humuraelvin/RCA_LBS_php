/*
Name: 			Tables / Ajax - Examples
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	1.5.2
*/

(function($) {

	'use strict';

	/* var datatableInit = function() {
		
		$('#datatable-default').dataTable();

		var $table = $('#datatable-ajax');
		$table.dataTable({
			"ajax": {
				"url": $table.data('url'),
				"data": {
					"tip": "adminKullaniciTab_Hareketler",
					"id": $table.data('id')
				},
				"type": "POST"
			}
		});
		
		$('#datatable-ajax tfoot th, #datatable-default tfoot th').each( function () {
			var title = $(this).text();
			$(this).html( '<input style="width: 60" class="form-control" type="text" placeholder="'+title+'" />' );
		} );
		
		var table = $('#datatable-ajax, #datatable-default').DataTable();
		
		table.columns().every( function () {
			var that = this;
	 
			$( 'input', this.footer() ).on( 'keyup change', function () {
				if ( that.search() !== this.value ) {
					that
						.search( this.value )
						.draw();
				}
			} );
		} );

	}; */

	$(function() {
	//	datatableInit();
	});

}).apply(this, [jQuery]);