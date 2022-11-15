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
echo '<!DOCTYPE framexs:resource SYSTEM "'.get_theme_file_uri('resource.dtd')."\">\n";
$theme;
if(get_option("framexs_theme")) {
	echo "<?xml-stylesheet type=\"application/xml\" href=\"".get_theme_file_uri("framexs.xsl")."\"?>\n";
	$theme = get_option('framexs_theme');
	
	
	if(get_option("abtest") == 'on') {
		if(isset($_GET["theme"])) {//まずURLパラメータにテーマが指定されていればそれを使う
			if(in_array($_GET["theme"],get_option("abtest_theme"),true)) {
				$theme = $_GET["theme"];
			} else {
				//指定されたテーマが存在しないならランダムに選ぶ
				$len = count(get_option("abtest_theme"));
				$i = mt_rand(0,$len -1);
				$theme = get_option("abtest_theme")[$i];
				setcookie("framexs", $theme);
			}
		} else 
		//cookieに'framexs'が設定されていて
		if(isset($_COOKIE["framexs"])
		//'framexsrand'がパラメータにない
		&& !isset($_GET["framexsrand"])
		//cookieで指定されたテーマがABテスト候補の中にある
		&& in_array($_COOKIE["framexs"],get_option("abtest_theme"),true)) {
			$theme = $_COOKIE["framexs"];
		} else {
			//
			$len = count(get_option("abtest_theme"));
			$i = mt_rand(0,$len -1);
			$theme = get_option("abtest_theme")[$i];
			setcookie("framexs", $theme);
		}
	}
	echo "<?framexs.skeleton ".get_option('framexs_themes_path')."/".$theme."/main.ftml"."?>\n";
	echo "<?framexs.properties ".get_option('properties_path')."/".$pagetype.".xml?>\n";
	echo "<?framexs.resource sidebar1-wide ".esc_url( home_url( get_option("sidebar_path"), 'relative') )."?>\n";
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<?php
if($theme){
	echo "<meta property=\"framexs-theme\" content=\"".$theme."\"/>\n";
}
wp_head();?>
</head>
<body>
<main id="main">