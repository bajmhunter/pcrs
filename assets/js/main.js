/*
google.load("jquery", "1.4.2");
google.load("jqueryui", "1.8");
google.setOnLoadCallback( function() {
	main();
} );

*/

$(function(){ main() });

function main(){

}

//reference: will be needed for each instance
function date_fields(){
	 $('.date-field').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: '2000:'
    });
}

function showMsg(str){
  $('#body').append(str);
  setTimeout( function(){ $('#body > .message').fadeOut('fast'),3000;},3000 );
}

//Captalize prototype
String.prototype.capitalize = function(){
   return this.replace( /(^|\s)([a-z])/g , function(m,p1,p2){ return p1+p2.toUpperCase(); } );
};