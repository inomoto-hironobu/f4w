<?php
/**
 * The template for displaying archive pages
 *
 * @package Framexs
 * @since Framexs for WordPress 0.1
 */
global $pagetype;
$pagetype = "category";
get_header();

$description = get_the_archive_description();
?>

<?php if ( have_posts() ) : ?>

	<header class="page-header alignwide">
		<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
		<?php if ( $description ) : ?>
			<div class="archive-description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
		<?php endif; ?>
	</header><!-- .page-header -->

	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<article>
			<h2><?php the_title();?></h2>
		
			<?php the_excerpt(); ?>
		</article>
	<?php endwhile; ?>

<?php else : ?>
	
<?php endif; ?>

<?php get_footer(); ?>
