<?php
/**
 * Framexs functions and definitions
 *
 * @package Framexs
 * @since Framexs 0.1
 */

function get_framexs($pagetype) {
	echo "<?xml version=\"1.0\"?>\n";
	echo "<?xml-stylesheet type=\"application/xml\" href=\""."/wordpress/wp-content/themes/framexs/framexs.xsl"."\"?>\n";
	echo "<?framexs.skeleton "."/template/wordpress.ftml"."?>\n";
	/*echo "<?framexs.properties /properties/".$pagetype.".properties?>\n";*/
}

function xhtml($headers){
	$headers["Content-Type"] = "application/xhtml+xml; charset=UTF-8";
	return $headers;
}
add_filter("wp_headers","xhtml");

add_theme_support( 'title-tag' );

//妥当なXHTMLが出力されるように
function xbr( $content ) {
    $content = str_replace('<br>', '<br/>', $content);
	$content = str_replace('&nbsp;', ' ', $content);
    return $content;
}
add_filter('the_content', 'xbr');