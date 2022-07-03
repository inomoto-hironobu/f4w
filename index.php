<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Framexs
 * @since Twenty Twenty 1.0
 */
global $pagetype;
$pagetype = "home";
get_header();
?>
<main id="main">
<?php

	if ( have_posts() ) {

		$i = 0;

		while ( have_posts() ) {
			$i++;
			if ( $i > 1 ) {
				echo '<hr class="post-separator styled-separator is-style-wide section-inner" aria-hidden="true" />';
			}
			echo "<article>";
			the_post();
			echo "<h2>";the_title();echo "</h2>";
			echo "<section>";
			the_content();
			echo "</section>";
			echo "</article>";
		}
	} else {
		?>
		ポストがありません
		<?php
	}
	?>

	<?php get_template_part( 'template-parts/pagination' ); ?>
</main>
<?php get_footer();?>