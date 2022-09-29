<?php
echo '<?xml version="1.0"?>'."\n";
echo '<!DOCTYPE framexs:resource SYSTEM "'.get_theme_file_uri('resource.dtd').'">'."\n";
echo '<framexs:resource xmlns:framexs="urn:framexs-resource" xmlns="http://www.w3.org/1999/xhtml">'."\n";

// ウィジェットエリアにウィジェットがセットされている場合。
if ( is_active_sidebar( 'sidebar1-wide' ) ) { 
	echo '<div>';
    // ウィジェットを表示。
	dynamic_sidebar( 'sidebar1-wide' );
	echo '</div>';
} 

echo '</framexs:resource>';?>