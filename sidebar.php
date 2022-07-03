<?php
echo '<?xml version="1.0"?>'."\n";
echo '<framexs:resource xmlns:framexs="urn:framexs"  xmlns="http://www.w3.org/1999/xhtml">';
echo '<ul>'."\n";
$args = array(
	'post_type' => 'post',
	'posts_per_page' => 5,
);
$the_query = new WP_Query( $args );
if (  $the_query->have_posts() ) {
	while (  $the_query->have_posts() ) : $the_query->the_post();
		echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>'."\n";
	endwhile;
	wp_reset_postdata();
}
echo '</ul>'."\n";
echo '</framexs:resource>';
?>