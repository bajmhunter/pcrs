/*
google.load("jquery", "1.4.2");
google.load("jqueryui", "1.8");
google.setOnLoadCallback( function() {
	main();
} );

*/

$(function(){ main() });

function main(){
	$("#complaints").tabs();
	//toggle_search_criteria();
	date_fields();
}

function toggle_search_criteria(){
	$('.table2').hide();
	
	$('.search-criteria-list li > a').click(function() {
		$(this).next().toggle();
		return false;
	}).next().hide();
}

function date_fields(){
	 $('.date-field').datepicker({changeMonth: true,
			changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        yearRange: '2000:'});
}

String.prototype.capitalize = function(){
   return this.replace( /(^|\s)([a-z])/g , function(m,p1,p2){ return p1+p2.toUpperCase(); } );
};