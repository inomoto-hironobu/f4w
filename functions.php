<?php
/**
 * Framexs functions and definitions
 *
 * @package Framexs
 * @since Framexs 0.1
 */

function get_framexs($pagetype) {
	echo "<?xml version=\"1.0\"?>\n";
	if(get_option("framexs_theme")) {
		echo "<?xml-stylesheet type=\"application/xml\" href=\""."/wordpress/wp-content/themes/framexs/framexs.xsl"."\"?>\n";
		echo "<?framexs.skeleton /framexs/".get_option('framexs_theme')."/main.ftml"."?>\n";
		echo "<?framexs.properties /properties/".$pagetype.".properties?>\n";
	}
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

function theme_settings_page(){
	?>
	    <div class="wrap">
	    <h1>Theme Panel</h1>
	    <form method="post" action="options.php">
	        <?php
	            settings_fields("section");
	            do_settings_sections("theme-options");      
	            submit_button(); 
	        ?>          
	    </form>
		</div>
	<?php
}

function add_theme_menu_item()
{
	add_menu_page("Theme Panel", "Theme Panel", "manage_options", "theme-panel", "theme_settings_page", null, 99);
}

add_action("admin_menu", "add_theme_menu_item");

function display_theme_element()
{
	?>
    	<input type="text" name="framexs_theme" id="framexs_theme" value="<?php echo get_option('framexs_theme'); ?>" />
    <?php
}
function display_theme_panel_fields()
{
	add_settings_section("section", "All Settings", null, "theme-options");
	
    add_settings_field("framexs_theme", "Framexs theme name", "display_theme_element", "theme-options", "section");

    register_setting("section", "framexs_theme");
}

add_action("admin_init", "display_theme_panel_fields");