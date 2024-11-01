<?php


abstract class sortable_abstract {
	public $sortByText;
	public $translate_arr;
	public $addonContainerClasses = array();
	public $addonTopClasses = array();
	public $sidebars = array();
	public $rand;
	public $post_type;
	public function __construct(){
	}
	public function init($post_type){

		if($post_type!='') $this->post_type = $post_type; else $this->post_type = 'post';
		$sortable_translate = get_option('sortable_translate');
		$sortable_translate_arr = explode('|',$sortable_translate);
		$this->sortByText = $sortable_translate_arr[1];
		$this->translate_arr  = $sortable_translate_arr;
		if($this->rand!='') $this->getRand();
	}
	public function getPostType(){
		return $this->post_type;
	}
	public function getRand(){
		if($this->rand=='')
		$this->rand = rand(111111,999999);
		return $this->rand;
	}
	public function get_views($default_view){
		$defaultViewClass = ($default_view=='images')?'sortable-images-view':'sortable-list-view';
		$listViewActive = ($default_view=='list')?'active':'';
		$imagesViewActive = ($default_view=='images')?'active':'';
		return '<div class="sortable-views">
				<div class="sortable-list '.$listViewActive.'"><i class="fa fa-list"></i></div>
				<div class="sortable-images '.$imagesViewActive.'"><i class="fa fa-th-large"></i></div>
			</div>';
	}
	public function get_filters($post_type){
		return '';
	}
	public function colorStyle($rand,$color){
		return '';
	}
	public function colorStyleMobile($rand,$color){
		return '';
	}
	public function htmlStyle($rand,$color){
		return '';
	}
	public function get_other_social_media($post_type,$per_page,$include_social_media){
		global 	$sortableNetworks;
			$media = '';
		if(!empty($sortableNetworks)){
			foreach($sortableNetworks as $sortableNetwork){
				$nameArr = explode('_',$sortableNetwork);
				$name = $nameArr[1];
				$media .='<li class="sortable-media-'.$name.'"><a href="#" sort-by="social_'.$name.'" post-type="'.$post_type.'" per-page="'.$per_page.'"><i class="fa fa-'.$name.'"></i> '. ucfirst($name).' Shares</a></li>';
			}
		}
			return $media;
	}
	public function get_html($social_status,$include_social_media,$sort_social_media,$alphabetically,$comments,$post_type,$per_page,$show_stats,$default_view,$color,$custom){
		global $wpdb;
		$rand = $this->getRand(); $paged=1;
		$dropMedia =''; $sortby ='newest';
		$sortByText = 'Newest';
		$defaultViewClass = 'sortable-'.$default_view.'-view';
		$listViewActive = ($default_view=='list')?'active':'';
		$imagesViewActive = ($default_view=='images')?'active':'';


		$dropCustom ='';
		if($custom){
			$dropCustom = '<li><a href="#" sort-by="custom" post-type="'.$post_type.'" per-page="'.$per_page.'">'.get_option('sortable_custom_text').'</a></li>';
			$sortby = 'custom';
			$sortByText = get_option('sortable_custom_text');
		}
		$dropAlphabetically ='';
		if($alphabetically){
			$dropAlphabetically ='<li><a href="#" sort-by="a-z" post-type="'.$post_type.'" per-page="'.$per_page.'">'.$this->translate_arr[8].'</a></li>
					<li><a href="#" sort-by="z-a" post-type="'.$post_type.'" per-page="'.$per_page.'">'.$this->translate_arr[9].'</a></li>';
		}
		$dropComments ='';
		if($comments){
			$dropComments ='<li><a href="#" sort-by="comments" post-type="'.$post_type.'" per-page="'.$per_page.'">'.$this->translate_arr[12].'</a></li>';
		}
		$colorStyle ='';
		if($color!='#777777'){
			$colorStyle.='
			#sortableTop'.$rand.' .sortable-views div{ border:2px solid '.$color.'; color:'.$color.'; }
			#sortableTop'.$rand.' .sortable-views .sortable-list:hover,
			#sortableTop'.$rand.' .sortable-views .sortable-images:hover,
			#sortableTop'.$rand.' .sortable-views .active { background-color:'.$color.'; color:#fff;
			 -webkit-transition: background-color 0.3s ease-in-out; -moz-transition: background-color 0.3s ease-in-out;
			  -ms-transition: background-color 0.3s ease-in-out;  -o-transition: background-color 0.3s ease-in-out; transition: background-color 0.3s ease-in-out;
			}
			#sortableTop'.$rand.' .sortable-dropdown-toggle { border:2px solid '.$color.'; color:'.$color.'; }
			#sortableTop'.$rand.' .sortable-dropdown-toggle i{ color:'.$color.';}
			#sortableMenuDropdown'.$rand.' { border:2px solid '.$color.'; color:'.$color.';}
			#sortableTop'.$rand.' .dropdown-active .sortable-dropdown-toggle,
			#sortableTop'.$rand.' .sortable-dropdown-toggle:hover{ background-color:'.$color.' !important; color:#fff; }
			#sortableTop'.$rand.' .dropdown-active .sortable-dropdown-toggle i, #sortableTop'.$rand.' .sortable-dropdown-toggle:hover i { color:#fff; }
			#sortableContainer'.$rand.' .sort-image-wrap { background-color:'.$color.' !important;}
			#sortableContainer'.$rand.' .sortable-row  h2 a:hover{ color:'.$color.';}
			#sortableTop'.$rand.' ul.sortable-dropdown-ul li a:hover { background-color:'.$color.';  color:#fff; border-top:1px solid '.$color.'; }
			#sortableTop'.$rand.' ul.sortable-dropdown-ul li ul li a:hover { border-top:none; }
			'.$this->colorStyle($rand,$color).'
			@media screen and (max-width: 650px) {
				.dropdown-active #sortableMenuDropdown'.$rand.' { border:2px solid '.$color.';}
				'.$this->colorStyleMobile($rand,$color).'
			}
			';
		}
		if(!$show_stats){
			$colorStyle.= '#sortableContainer'.$rand.' .social-share-stats {display:none;}';
		}

		$default_sort_option = get_option('default-sort-option');
		if($default_sort_option!=''){
			$sortby =$default_sort_option;
		}
		if($sortby=='social_status') $sortByText = $this->translate_arr[1];
		if($sortby=='social_facebook') $sortByText = $this->translate_arr[2];
		if($sortby=='social_twitter') $sortByText = $this->translate_arr[3];
		if($sortby=='social_google_plus') $sortByText = $this->translate_arr[4];
		if($sortby=='social_stumbleupon') $sortByText = $this->translate_arr[5];
		if($sortby=='social_linkedin') $sortByText = $this->translate_arr[6];
		if($sortby=='social_pinterest') $sortByText = $this->translate_arr[7];
		if($sortby=='a-z') $sortByText = $this->translate_arr[8];
		if($sortby=='z-a') $sortByText = $this->translate_arr[9];
		if($sortby=='newest') $sortByText = $this->translate_arr[10];
		if($sortby=='oldest') $sortByText = $this->translate_arr[11];
		if($sortby=='comments') $sortByText = $this->translate_arr[12];
		$sidebarsHtml='';
		if(count($this->sidebars)>0){
			$sidebarsHtml = '<div class="sortable-sidebar " color="'.$color.'" >'.implode(" ",$this->sidebars).'</div>';
		}
		$html = '
		<div class="sortable-main-wrapper">
		<style>
			'.$this->htmlStyle($rand,$color).'
			#sortableContainer'.$rand.' { padding:0px !important; }
			#sortableContainer'.$rand.' .sortable-row .more-link {
				border:2px solid '.$color.'; color:'.$color.' !important;
				-webkit-transition: background-color 0.3s ease-in-out; -moz-transition: background-color 0.3s ease-in-out;
				-ms-transition: background-color 0.3s ease-in-out;  -o-transition: background-color 0.3s ease-in-out; transition: background-color 0.3s ease-in-out;
			}
			#sortableMenuDropdown'.$rand.' { border:2px solid #ddd;}
			@media screen and (max-width: 650px) {
				#sortableMenuDropdown'.$rand.' { border:none;}
				.dropdown-active #sortableMenuDropdown'.$rand.' { border:2px solid #ddd;}
			}
			#sortableContainer'.$rand.' .sortable-row .more-link::after {
			content:none !important;
			}
			#sortableContainer'.$rand.' .sortable-row .more-link:hover{ border:2px solid '.$color.'; background-color:'.$color.' !important; color:#fff !important; }
			#sortable-pagination-'.$rand.' a{ 	color:'.$color.'; border-top:1px solid '.$color.'; border-bottom:1px solid '.$color.'; border-right:1px solid '.$color.';}
			#sortable-pagination-'.$rand.' a:hover{ opacity:0.7; }
			#sortable-pagination-'.$rand.' > li:first-child > a {  border-left:1px solid '.$color.'; }
			#sortable-pagination-'.$rand.' .active{ padding:6px 12px; display:inline-block;border:1px solid '.$color.';  background-color:'.$color.'; color:#fff; }
			'.$colorStyle.'
		</style>
		<script>
			var sortable_sortby_'.$rand.' = "'.$sortby.'";
			var sortable_posttype_'.$rand.' = "'.$post_type.'";
			var sortable_perpage_'.$rand.' = "'.$per_page.'";
			var sortable_paged_'.$rand.' = "'.$paged.'";
		</script>
		'.$this->get_header_script($post_type).'
		<div id="sortableTop'.$rand.'" class="sortable-top '.implode(" ",$this->addonTopClasses).'" rand="'.$rand.'" >
			<div class="sortable-dropdown">
				  <div class="sortable-dropdown-toggle" id="sortableMenu'.$rand.'" >
					<i class="fa fa-sort-amount-desc"></i> '.$this->translate_arr[0].' <span>'.$sortByText.'</span> <i class="fa fa-sort"></i>
				  </div>
				  <ul id="sortableMenuDropdown'.$rand.'" class="sortable-dropdown-ul" aria-labelledby="sortableMenu'.$rand.'" rand="'.$rand.'">
					'.$dropCustom.'
					
					'.$dropAlphabetically.'
					<li><a href="#" sort-by="newest" post-type="'.$post_type.'" per-page="'.$per_page.'">'.$this->translate_arr[10].'</a></li>
					<li><a href="#" sort-by="oldest" post-type="'.$post_type.'" per-page="'.$per_page.'">'.$this->translate_arr[11].'</a></li>
					'.$dropComments.'

				  </ul>
			</div>
			'.$this->get_filters($post_type).'
			'.$this->get_views($default_view).'

		</div>
		<div style="clear:both"></div>
		<div class="sortable-wrapper">
			'.$sidebarsHtml.'
			<div id="sortableContainer'.$rand.'" class="sortable-container container-fluid '.implode(" ",$this->addonContainerClasses).' '.$defaultViewClass.'">
				<div class="sortable-loading">
					<span>
						<img src="'.plugins_url().'/sortable/img/loading.gif" />
					</span>
				</div>
				';
				list ($htmlArr,$pagination) = $this->get_sortable_loop($sortby,$post_type,$per_page,$paged,$rand,$sort_social_media,$custom);
				if($htmlArr!='-' && $htmlArr!=''){
				foreach($htmlArr as $total=>$item){
					$html.= $item;
					}

				} else { $html .= '<p>Sorry, no posts matched your criteria.</p>';}

				if($pagination=='')$pagination='';
				$html .= $pagination.
			'</div>
		</div>
		</div>
		<div style="clear:both"></div>';
		wp_reset_postdata();

		return $html;

	}
	public function get_header_script($post_type){
		$script = '
		<script>
			jQuery(document).ready(function(){
				jQuery(\'.sortable-description .more-link\').html(\''.$this->translate_arr[13].'\');
				jQuery(\'.sortable-postedby\').html(\''.$this->translate_arr[14].'\');
				jQuery(\'.sortable-on\').html(\''.$this->translate_arr[15].'\');
				sortable_count_all2(\''.$post_type.'\',\'1\');
			});
		</script>';
		return $script;
	}
	public function get_query($sortby,$post_type,$per_page,$paged,$rand,$sort_social_media,$custom,$args){
		$orderby = 'date'; $order= 'DESC';
		if($sortby == 'a-z'){ $orderby='title'; $order ='ASC'; }
		if($sortby == 'z-a'){ $orderby='title'; $order ='DESC'; }
		if($sortby == 'oldest'){ $orderby='date'; $order ='ASC'; }
		if($sortby == 'comments'){ $orderby = 'comment_count'; $order = 'DESC';}
			$args = array(
					'post_type' => $post_type,
					'posts_per_page' => $per_page,
					'orderby' => $orderby,
					'order'   => $order,
					'ignore_sticky_posts'=>true,
					'paged' =>$paged,
					's' => $this->get_query_search(),
					'tax_query' => $this->get_query_taxquery(),
					'meta_query' => $this->get_query_filters($post_type)
					);
			if($sortby=='social_status' || $sortby=='social_facebook' || $sortby=='social_twitter' || $sortby=='social_pinterest' || $sortby=='social_linkedin' || $sortby=='social_stumbleupon' || $sortby=='social_google_plus' || $sortby=='custom'){
				$args = array(
					'post_type' => $post_type,
					'posts_per_page' => -1,
					'orderby' => $orderby,
					'order'   => $order,
					'ignore_sticky_posts'=>true,
					'paged' =>$paged,
					's' => $this->get_query_search(),
					'tax_query' => $this->get_query_taxquery(),
					'meta_query' => $this->get_query_filters($post_type)
					);
			}
		return new WP_Query( $args );
	}

	public function get_query_search(){
		return '';
	}
	public function get_query_filters($post_type){
		return array();
	}
	public function get_query_taxquery(){
		return array();
	}

	public function get_loop_images($post_id){
		return '';
	}
	public function get_sortable_loop($sortby,$post_type,$per_page,$paged,$rand,$sort_social_media,$custom){
		global $wpdb; global 	$sortableNetworks;
		$orderby = 'date'; $order= 'DESC';
		if($sortby == 'a-z'){ $orderby='title'; $order ='ASC'; }
		if($sortby == 'z-a'){ $orderby='title'; $order ='DESC'; }
		if($sortby == 'oldest'){ $orderby='date'; $order ='ASC'; }
		if($sortby == 'comments'){ $orderby = 'comment_count'; $order = 'DESC';}
		$args = array(
					'post_type' => $post_type,
					'posts_per_page' => $per_page,
					'orderby' => $orderby,
					'order'   => $order,
					'ignore_sticky_posts'=>true,
					'paged' =>$paged
						);
			if($sortby=='social_status' || $sortby=='social_facebook' || $sortby=='social_twitter' || $sortby=='social_pinterest'
			 || $sortby=='social_linkedin' || $sortby=='social_stumbleupon' || $sortby=='social_google_plus' || $sortby=='custom'){
			$args = array(
					'post_type' => $post_type,
					'posts_per_page' => -1,
					'orderby' => $orderby,
					'order'   => $order,
					'ignore_sticky_posts'=>true,
					'paged' =>$paged
						);
			}
		$the_query = $this->get_query($sortby,$post_type,$per_page,$paged,$rand,$sort_social_media,$custom,$args);
		$htmlArr = array();
		$total  = $the_query->found_posts;
		 if ( $the_query->have_posts() ){
		$i=0; $irev = $total;
		//$links = array('http://ikea.com','http://cc.com','http://time.mk');
			while ( $the_query->have_posts() ) : $the_query->the_post();
			//foreach($links as $link){

				$link = get_the_permalink();
				$sortable_translate = get_option('sortable_translate');
				$sortable_translate_arr = explode('|',$sortable_translate);
				$exerpt = get_the_excerpt().' <a class="more-link" href="'. $link . '">'.$sortable_translate_arr[13].'</a>';
				if($custom==true){
					$customHTML = '';
				}
				$total = 0;

				$sortable_cache_social = get_post_meta( get_the_ID(),'sortable_cache_social',true );
				$sortableNetworkCountAll = '';
				$sortableNewtworksHMTL = '';
				$snCount = array(); $snCountTotal = 0;
				if(!empty($sortableNetworks)){ $sni =6;
					foreach($sortableNetworks as $sortableNetwork){
						$sortableNetworkCountAll.= '|0';
						$nameArr = explode('_',$sortableNetwork);
						$name = $nameArr[1];
						if(!$sortable_cache_social){
							$snCount[$name] =0;
						} else {
							$sortable_cache_social_arr = explode('|',$sortable_cache_social);
							$snCount[$name] =$sortable_cache_social_arr[$sni];
							$snCountTotal = $snCountTotal + $sortable_cache_social_arr[$sni];
						}
						$sortableNewtworksHMTL .= '<strong>'.$snCount[$name].' <i class="fa fa-'.$name.'"></i></strong>';
						if(preg_match('/'.$name.'/i',$sortby)) $sortbyid = $snCount[$name].'.'.$irev;
						$sni++;
					}
				}

				$social_stats = '';
				if(preg_match('/social/i',$sortby)){

					$sortable_cache_time = get_option( 'sortable_cache_time' );
					$sortable_cache =get_option( 'sortable_cache' ) * 60;
					$time=  time();
					$time20Min = $sortable_cache_time+$sortable_cache;

					if(!$sortable_cache_social){
						$fb = 0;
						$tw = 0;
						$pin = 0;
						$lin = 0;
						$st = 0;
						$gp = 0;
						$sortable_cache_social = $fb.'|'.$tw.'|'.$pin.'|'.$lin.'|'.$st.'|'.$gp.$sortableNetworkCountAll;
						//add_post_meta(get_the_ID(),  'sortable_cache_social', $sortable_cache_social );


					} else {
						$sortable_cache_social_arr = explode('|',$sortable_cache_social);
						$fb = $sortable_cache_social_arr[0]; $tw= ($sortable_cache_social_arr[1] || 0); $pin = $sortable_cache_social_arr[2];
						$lin = $sortable_cache_social_arr[3]; $st= $sortable_cache_social_arr[4]; $gp = $sortable_cache_social_arr[5];
					}
					if(preg_match('/facebook/i',$sort_social_media))$total = $total+$fb;
					if(preg_match('/twitter/i',$sort_social_media))$total = $total+$tw;
					if(preg_match('/pinterest/i',$sort_social_media))$total = $total+$pin;
					if(preg_match('/linkedin/i',$sort_social_media))$total = $total+$lin;
					if(preg_match('/stumbleupon/i',$sort_social_media))$total = $total+$st;
					if(preg_match('/google/i',$sort_social_media))$total = $total+$gp;
					$total = $total+$snCountTotal;
					$social_stats = '
						<div class="social-share-stats">
							<h4>Social Share Stats</h4>
							<strong>'.$fb.' <i class="fa fa-facebook"></i></strong>
						 	<strong>'.$gp.' <i class="fa fa-google-plus"></i></strong>
						 	<strong>'.$st.' <i class="fa fa-stumbleupon"></i></strong>
						  	<strong>'.$pin.' <i class="fa fa-pinterest"></i></strong>
						  	<strong>'.$lin.' <i class="fa fa-linkedin"></i></strong>
							'.$sortableNewtworksHMTL.'
						</div>';
				}
				$thumbnail =wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()),'thumbnail' );
				$thumbMedium = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()),'medium' );
				$thumbLarge = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()),'large' );
				if($sortby=='social_status') $sortbyid = $total.'.'.$irev;
				if($sortby=='social_facebook') $sortbyid = $fb.'.'.$irev;
				if($sortby=='social_pinterest') $sortbyid = $pin.'.'.$irev;
				if($sortby=='social_linkedin') $sortbyid = $lin.'.'.$irev;
				if($sortby=='social_stumbleupon') $sortbyid = $st.'.'.$irev;
				if($sortby=='social_google_plus') $sortbyid = $gp.'.'.$irev;
				if($sortby=='a-z') $sortbyid = $i;
				if($sortby=='z-a') $sortbyid = $i;
				if($sortby=='newest' || $sortby=='oldest') $sortbyid = $i;
				if($sortby=='comments') $sortbyid = $i;
				$customMeta = get_post_meta(get_the_ID(),get_option('sortable_custom_meta'),true);
				if(!$customMeta || $customMeta=='' || $customMeta=='undefined') $customMeta =0;
				if($sortby=='custom') $sortbyid = $customMeta.'.'.$i;
				$customHTML ='';
				if($custom) $customHTML = '<p class="sortable-custom-text">'.get_option('sortable_custom_text').': '.get_option('sortable_premetatext').'<span>'.$customMeta.'</span></p>';
				/*$htmlArr[$sortbyid] = '<div class=" sort-image-wrap">'.$sortbyid.'|'.$link.'	<div class="social-share-stats"><h4>Social Share Stats</h4><strong>'.$fb.' <i class="fa fa-facebook"></i></strong>  <strong>'.$tw.' <i class="fa fa-twitter"></i></strong>
						 <strong>'.$gp.' <i class="fa fa-google-plus"></i></strong> <strong>'.$st.' <i class="fa fa-stumbleupon"></i></strong>
						  <strong>'.$pin.' <i class="fa fa-pinterest"></i></strong>  <strong>'.$lin.' <i class="fa fa-linkedin"></i></strong>
						</div></div><br>';
				*/
				$htmlArr[$sortbyid] =  '
						<div class="sortable-row" id="sortable_row_'.get_the_ID().'" paged="'.$paged.'" perpage="'.$per_page.'">
						<div class="sortable-col-4 sort-image-wrap" onclick="location.assign(\''.get_the_permalink().'\');"
						style="background:url('.$thumbLarge[0].') no-repeat center center #999;"
						thumbnail="'.$thumbnail[0].'"
						 medium="'.$thumbMedium[0].'"
						  large="'.$thumbLarge[0].'"
						   url="'.wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ).'">
						   <div style="display:none"><a href="'.get_the_permalink().'">'.get_the_post_thumbnail( get_the_ID(), 'medium' ).'</a></div>
						 </div>
						<div class="sortable-col-8">'.$customHTML.'
						<h2><a href="'.get_the_permalink().'">'.get_the_title().'</a></h2>
						<p class="sortable-post-meta"><span class="sortable-postedby">Posted by</span> '.  get_the_author_meta( 'nickname').' <span class="sortable-on">on</span> '.get_the_date('M d, Y').'</p>
						<div class="sortable-description">'.$exerpt.'</div>

						'.$social_stats.'
						 '.$this->get_loop_images(get_the_ID()).'
						</div>
						</div>';

				$i++; $irev = $irev-1;
			//}
			endwhile;



			if($sortby=='social_status' || $sortby=='social_facebook' || $sortby=='social_twitter' || $sortby=='social_pinterest'
			 || $sortby=='social_linkedin' || $sortby=='social_stumbleupon' || $sortby=='social_google_plus' || $sortby=='custom'){
				$countTotal = count($htmlArr)/$per_page;

				$countTotalArr = explode('.',$countTotal); $countTotalNew = $countTotalArr[0];
			   $total = number_format($countTotalNew,0);
			   if(isset($countTotalArr[0])){
					if($countTotalArr[0]>0) $total = $total+1;
			   }
			 } else {
			  $total = $the_query->max_num_pages;
			 }


			if($sortby=='social_status' || $sortby=='social_facebook' || $sortby=='social_twitter' || $sortby=='social_pinterest'
			 || $sortby=='social_linkedin' || $sortby=='social_stumbleupon' || $sortby=='social_google_plus'){
				krsort($htmlArr); $p = 1; $pi =1; $htmlArrNew =array();
				foreach($htmlArr as $htmlArrItem){
					if($p==$paged){
						$htmlArrNew[] = $htmlArrItem;
					}
					if($pi==$per_page){
						$pi=0; $p++;
					}
					$pi++;
				}
				$htmlArr = $htmlArrNew;
			}
			 if($sortby=='custom'){
			 if(get_option('sortable_custom_order')=='ASC' || get_option('sortable_custom_order')==''){ ksort($htmlArr);} else { krsort($htmlArr); }

				$p = 1; $pi =1; $htmlArrNew =array();
				foreach($htmlArr as $htmlArrItem){
					if($p==$paged){
						$htmlArrNew[] = $htmlArrItem;
					}
					if($pi==$per_page){
						$pi=0; $p++;
					}
					$pi++;
				}
				$htmlArr = $htmlArrNew;
			 }
			//pagination

			 $pagedPrev = $paged-1;
			 $pagedNext = $paged+1;
			 $pagination = '';
				$i=1;
				if($total>0){
				$pagination .= '<div style="clear:both"></div>
				  <ul id="sortable-pagination-'.$rand.'" class="sortable-pagination" rand="'.$rand.'">';
				if($pagedPrev>0) $pagination .=	'<li>
					  <a href="#" aria-label="Previous" sort-by="'.$sortby.'" post-type="'.$post_type.'" per-page="'.$per_page.'" paged="'.$pagedPrev.'" >
						<span aria-hidden="true">&laquo;</span>
					  </a>
					</li>';
				do{
				if($i==$paged) $pagination .= '<li class="active">'.$i.' <span class="sr-only">(current)</span></li>';
				else $pagination .= '<li><a href="#"  sort-by="'.$sortby.'" post-type="'.$post_type.'" per-page="'.$per_page.'" paged="'.$i.'" >'.$i.'</a></li>';
				$i++;
				}while ($i<=$total);

				if($pagedNext<=$total) $pagination .= 	'<li>
					  <a href="#" aria-label="Next" sort-by="'.$sortby.'" post-type="'.$post_type.'" per-page="'.$per_page.'" paged="'.$pagedNext.'" >
						<span aria-hidden="true">&raquo;</span>
					  </a>
					</li>';
				$pagination .=	  '</ul>';
				}
		 } else{
			$htmlArr = '-';
		 }
		if(!isset($pagination))$pagination='';
			return array($htmlArr,$pagination);
	}

}

class sortable extends sortable_abstract{

}

 ?>
