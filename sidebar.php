<?php
echo '<?xml version="1.0"?>'."\n";
echo '<!DOCTYPE framexs:resource SYSTEM "'.get_theme_file_uri('resource.dtd').'">';
echo '<framexs:resource xmlns:framexs="urn:framexs" xmlns="http://www.w3.org/1999/xhtml">';

// ウィジェットエリアにウィジェットがセットされている場合。
if ( is_active_sidebar( 'widget-01' ) ) { 
	echo '<div id="widget-01">';
    // ウィジェットを表示。
	dynamic_sidebar( 'widget-01' );
	echo '</div>';
} 

echo '</framexs:resource>';?>