<?php

// Replaces the excerpt "more" text by a link
function sortable_new_excerpt($more) {
       global $post; global $wpdb;
	   	$sortable_translate = get_option('sortable_translate');
	$sortable_translate_arr = explode('|',$sortable_translate);
	return '..  <a class="more-link" href="'. get_permalink($post->ID) . '">'.$sortable_translate_arr[13].'</a>';
}
add_filter('excerpt_more', 'sortable_new_excerpt');


?>