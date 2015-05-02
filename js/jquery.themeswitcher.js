/* 
## @project: Simple jQuery theme switcher
## @filename: themeswitcher.php
## @description: the jquery behind the theme switcher
## @author: PlasticBrain Media LLC | plasticbrain.net
*/


$(document).ready( function(){
	// Theme Switcher
	$("#switcher li a").click(function() {
		$("#switcher li a").removeClass( 'selected' ).removeClass( 'ui-corner-all' );
		$(this).addClass( 'selected' ).addClass( 'ui-corner-all' );
    $("link#theme_stylesheet").attr("href",$(this).attr('rel'));
    return false;
	});
});