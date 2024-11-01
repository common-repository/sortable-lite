<?php
add_filter( 'page_template', 'sortable_page_template' );
function sortable_page_template( $page_template )
{
    $pages = get_pages('meta_key=sortable');
		  foreach ( $pages as $page ) {
			if(is_page($page->ID)){
			$page_template = dirname( __FILE__ ) . '/page-template.php';
			}

		  }
     /*if(get_option( 'page_for_posts' )!='0'){
		if(is_page(get_option( 'page_for_posts' ))){
		$page_template = dirname( __FILE__ ) . '/page-template.php';
		}
		}
		*/
    return $page_template;
}

function sortable_init_object(){
	$sortable = new sortable();
	if (class_exists('sortable_extend_1')) {
		$sortable = new sortable_extend_1();
	}
	if (class_exists('sortable_extend_2')) {
		$sortable = new sortable_extend_2();
	}
	if (class_exists('sortable_extend_3')) {
		$sortable = new sortable_extend_3();
	}
	if (class_exists('sortable_extend_4')) {
		$sortable = new sortable_extend_4();
	}
	if (class_exists('sortable_extend_5')) {
		$sortable = new sortable_extend_5();
	}
	if (class_exists('sortable_extend_6')) {
		$sortable = new sortable_extend_6();
	}
	if (class_exists('sortable_extend_7')) {
		$sortable = new sortable_extend_7();
	}
	if (class_exists('sortable_extend_8')) {
		$sortable = new sortable_extend_8();
	}
	if (class_exists('sortable_extend_9')) {
		$sortable = new sortable_extend_9();
	}
	return $sortable;
}

// Same handler function...
add_action( 'wp_ajax_sortable', 'sortable_callback' );
add_action( 'wp_ajax_nopriv_sortable', 'sortable_callback' );
function sortable_callback() {
	global $wpdb;
	$sortby = $_POST['sortby'];
	$post_type = $_POST['post_type'];
	$per_page = $_POST['per_page'];
	$filters = (isset($_REQUEST['filters']))?$_REQUEST['filters']:'';
	$html =''; // echo $sortby.'|'.$post_type.'|'.$per_page;
	$rand = $_POST['rand'];
	$paged = $_POST['paged'];
	$sort_social_media = $_POST['sort_social_media'];
	$custom =false;
	if($sortby=='custom')$custom=true;
	$sortable = sortable_init_object();
	$sortable->init();
	list ($htmlArr,$pagination) = $sortable->get_sortable_loop($sortby,$post_type,$per_page,$paged,$rand,$sort_social_media,$custom);
	if($htmlArr!='-'){
		foreach($htmlArr as $total=>$item){
			$html.= $item;
		}
	}else { $html = '<p>Sorry, no posts matched your criteria.</p>';}
	echo '<div class="sortable-loading">
		<span>
			<img src="'.plugins_url().'/sortable/img/loading.gif" />
		</span>
	</div>'.
	$html.$pagination;
	wp_die();
}


add_action( 'wp_ajax_sortable_count', 'sortable_count_callback' );
add_action( 'wp_ajax_nopriv_sortable_count', 'sortable_count_callback' );
function sortable_count_callback() {
	global $wpdb;
	wp_die();
}


add_action( 'wp_ajax_sortable_count_all', 'sortable_count_all_callback' );
add_action( 'wp_ajax_nopriv_sortable_count_all', 'sortable_count_all_callback' );
function sortable_count_all_callback() {
	global $wpdb;
	wp_die();
}


?>
