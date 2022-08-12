<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package Framexs
 * @since Framexs for WordPress 0.1
 */
global $pagetype;
echo "<?xml version=\"1.0\"?>\n";
echo '<!DOCTYPE framexs:resource SYSTEM "'.get_theme_file_uri('resource.dtd').'">';
if(get_option("framexs_theme")) {
	echo "<?xml-stylesheet type=\"application/xml\" href=\"".get_theme_file_uri("framexs.xsl")."\"?>\n";
	echo "<?framexs.skeleton ".get_option('framexs_themes_path')."/".get_option('framexs_theme')."/main.ftml"."?>\n";
	echo "<?framexs.properties ".get_option('properties_path')."/".$pagetype.".xml?>\n";
	echo "<?framexs.resource sidebar ".esc_url( home_url( get_option("resource_path"), 'relative') )."?>\n";
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<title><?php echo wp_get_document_title();?></title>
<?php wp_head();?>
</head>
<body>
<main id="main">