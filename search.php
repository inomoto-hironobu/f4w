<?php
/**
 * The template for displaying search results pages
 *
 * @package Framexs
 * @since Framexs 0.1
 */

get_header();

if ( have_posts() ) {
	?>

	<div class="search-result-count default-max-width">
		<?php
		printf(
			esc_html(
				/* translators: %d: The number of search results. */
				_n(
					'We found %d result for your search.',
					'We found %d results for your search.',
					(int) $wp_query->found_posts,
					'twentytwentyone'
				)
			),
			(int) $wp_query->found_posts
		);
		?>
	</div><!-- .search-result-count -->
	<?php
	// Start the Loop.
	while ( have_posts() ) {
		the_post();
//
	} // End the loop.

	// If no content, include the "No posts found" template.
} else {
	//get_template_part( 'template-parts/content/content-none' );
}

get_footer();
