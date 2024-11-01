<?php
function sortable_admin_view(){
$tab = (isset($_REQUEST['tab']))?$_REQUEST['tab']:'shortcodes';
$activeShort =($tab=='' || $tab=='shortcodes')?'nav-tab-active':'';
$activeSettings = ($tab=='settings')?'nav-tab-active':'';
$activePages = ($tab=='pages')?'nav-tab-active':'';

$sortable_short = (isset($_REQUEST['sortable-short']))?$_REQUEST['sortable-short']:'';
$unset = (isset($_REQUEST['unset']))?$_REQUEST['unset']:'';
if($sortable_short!=''){
	$pageID = (isset($_REQUEST['page-dropdown']))?$_REQUEST['page-dropdown']:'';
	update_post_meta( $pageID, 'sortable', $sortable_short );
}
if($unset!=''){
	delete_post_meta( $unset, 'sortable' );
}

$save_settings = (isset($_REQUEST['save-settings']))?$_REQUEST['save-settings']:'';
	
	if($save_settings=='Save'){ 
		$disable_font_awesome = (isset($_REQUEST['disable-font-awesome']))?$_REQUEST['disable-font-awesome']:'';
	
		if ( get_option( 'disable_font_awesome' ) !== false ) {
	
		update_option( 'disable_font_awesome', $disable_font_awesome );
		} else {

		add_option( 'disable_font_awesome', $disable_font_awesome );
		}
		//sortable-cache|sortable-custom-meta|sortable-custom-order|sortable-custom-text
		$sortable_cache = (isset($_REQUEST['sortable-cache']))?$_REQUEST['sortable-cache']:'';
		if ( get_option( 'sortable_cache' ) !== false ) {
		update_option( 'sortable_cache', $sortable_cache );
		} else {
		 add_option( 'sortable_cache', $sortable_cache );
		}		

		$sortable_custom_meta = (isset($_REQUEST['sortable-custom-meta']))?$_REQUEST['sortable-custom-meta']:'';
		if ( get_option( 'sortable_custom_meta' ) !== false ) {
		update_option( 'sortable_custom_meta', $sortable_custom_meta );
		} else {
		 add_option( 'sortable_custom_meta', $sortable_custom_meta );
		}		

		$sortable_custom_order = (isset($_REQUEST['sortable-custom-order']))?$_REQUEST['sortable-custom-order']:'';
		if ( get_option( 'sortable_custom_order' ) !== false ) {
		update_option( 'sortable_custom_order', $sortable_custom_order );
		} else {
		 add_option( 'sortable_custom_order', $sortable_custom_order );
		}		

		$sortable_custom_text = (isset($_REQUEST['sortable-custom-text']))?$_REQUEST['sortable-custom-text']:'';
		if ( get_option( 'sortable_custom_text' ) !== false ) {
		update_option( 'sortable_custom_text', $sortable_custom_text );
		} else {
		 add_option( 'sortable_custom_text', $sortable_custom_text );
		}

		$sortable_premetatext = (isset($_REQUEST['sortable-premetatext']))?$_REQUEST['sortable-premetatext']:'';
		if ( get_option( 'sortable_premetatext' ) !== false ) {
		update_option( 'sortable_premetatext', $sortable_premetatext );
		} else {
		 add_option( 'sortable_premetatext', $sortable_premetatext );
		}
		
		
		$sortable_translate = (isset($_REQUEST['sortable-translate']))?$_REQUEST['sortable-translate']:'';
		if ( get_option( 'sortable_translate' ) !== false ) {
		update_option( 'sortable_translate', $sortable_translate );
		} else {
		 add_option( 'sortable_translate', $sortable_translate );
		}	

		$default_sort_option = (isset($_REQUEST['default-sort-option']))?$_REQUEST['default-sort-option']:'';
		if ( get_option( 'default-sort-option' ) !== false ) {
		update_option( 'default-sort-option', $default_sort_option );
		} else {
		 add_option( 'default-sort-option', $default_sort_option );
		}	
	}
	$output = 'objects'; // names or objects

	$post_types = get_post_types( '', $output );
	$postTypesHTML ='';
	foreach ( $post_types  as $post_type ) {

	   $postTypesHTML .= '<option value="' . $post_type->name . '">' . $post_type->name . '</option>';
	}
?>
<div class="wrap">
<h1>Sortable</h1>

<?php
	echo '<h2 class="nav-tab-wrapper">
		<a class="nav-tab '.$activeShort.'" href="admin.php?page=sortable_admin_view&tab=shortcodes">Shortcode Generator</a>
		<a class="nav-tab '.$activePages.'" href="admin.php?page=sortable_admin_view&tab=pages">My Sortable Pages</a>
		<a class="nav-tab '.$activeSettings.'" href="admin.php?page=sortable_admin_view&tab=settings">Settings</a>
	</h2>';
	if($tab=='cache'){
		?>
		<div class="building-cache">
		<h3 >Building cache..</h3>
		</div>
		<script>
		var ptn = 1;
		var all_post_types = [<?php 
		$post_types = get_post_types( '', 'names' ); 

		foreach ( $post_types as $post_type ) {

		 if($post_type!='revision' && $post_type!='attachment' && $post_type!='nav_menu_item' && $post_type!='wpcf7_contact_form')  echo '"' . $post_type . '",';
		} ?>];
		jQuery(document).ready(function(){
		
			sortable_count_all('<?php echo $_REQUEST['pt']; ?>',1);	
		});
		</script>
		<style>
		.slink { padding:3px 10px; background:#fff; border:1px solid #eee; margin-bottom:5px;  }
		.slink span {display:inline-block; padding:3px; margin-right:7px;  }
		</style>
		<div id="cache-management-feed"></div>
		
		<?php
	}
	if($tab=='pages'){
		
		?>
		
		<form method="post" action="admin.php?page=sortable_admin_view&tab=pages">
		<h3>All Sortable pages</h3>
		 <?php 
		  $pages = get_pages('meta_key=sortable'); 
		  if(!empty($pages)){
		  foreach ( $pages as $page ) {
			$option = '<div class="sortable-pages-tr">';
			$option .= $page->post_title;
			$option .= '<a href="admin.php?page=sortable_admin_view&tab=pages&unset='.$page->ID.'">Unset</a>
			</div>';
			echo $option;
		  }} else { echo '<p style="font-style:italic;">No sortable pages found..</p>';}
		 ?>
		 <h3>Set New Sortable Page</h3>
		 <ul class="sortable-pages-menu">
			<li class="active" onclick="jQuery('.sort-shortcodes-generator').hide(); jQuery('.sortable-pages-menu .active').removeClass('active'); jQuery(this).addClass('active');">Basic Options</li>
			<li  onclick="jQuery('.sort-shortcodes-generator').show(); jQuery('.sortable-pages-menu .active').removeClass('active'); jQuery(this).addClass('active');">Advanced Options</li>
		 </ul>
		<select name="page-dropdown"> 
		 <option value="">
		<?php echo esc_attr( __( 'Select page' ) ); ?></option> 
		 <?php 
		  $pages = get_pages(); 
		  foreach ( $pages as $page ) {
			$option = '<option value="' . $page->ID . '">';
			$option .= $page->post_title;
			$option .= '</option>';
			echo $option;
		  }
		 ?>
		</select>
		<style>
		.sort-shortcodes-generator { display:none;}
		.sortable-pages-tr { padding: 5px; border:1px solid #ddd; background:#fff; line-height:18px; }
		.sortable-pages-tr a {float:right; }
		.sortable-pages-menu { list-style:none; height:50px; }
		.sortable-pages-menu li{ float:left; cursor:pointer; padding:7px 10px; background:#fff; border:1px solid #ddd; color:#555; text-decoration:none; }
		.sortable-pages-menu li.active { background:#ddd; }
		</style>
		
		<?php
	}
	if($tab=='shortcodes' || $tab=='pages'){


		?>
		
		<div class="sort-shortcodes-generator">
			<div class="shortgen-bar">
				<div class="shortgen-bar-item">
					<h4>Social Status</h4>
					<select id="short-social-status"><option value="1" selected="selected">Show Social Status</option><option value="0" >Hide Social Status</option></select>	 
					<p><i class="fa fa-info-circle"></i> Show sort by social status as an option for sorting posts.</p>
				</div>
				<div class="shortgen-bar-item">
					<h4>Show Alphabetically</h4>
					<select id="short-alphabetically"><option value="1" selected="selected">Show Alphabetically</option><option value="0" >Hide Alphabetically</option></select>	 
					<p><i class="fa fa-info-circle"></i> Show sort by alphabetical order as an option for sorting posts.</p>
				</div>
				<div class="shortgen-bar-item">
					<h4>Show Most Commented</h4>
					<select id="short-comments"><option value="1" selected="selected">Show Most Commented</option><option value="0" >Hide Most Commented</option></select>	 
					<p><i class="fa fa-info-circle"></i> Show sort by most commented posts as an option for sorting posts.</p>
				</div>
					
				<div class="shortgen-bar-item">
					<h4>Hide Social Statistics</h4>
					<select id="short-show-stats"><option value="0" selected="selected">Hide Social Stats</option><option value="1" >Show Social Stats</option></select>	 
					<p><i class="fa fa-info-circle"></i> Hide statistics in the loop of posts.</p>
				</div>
					
				<div class="shortgen-bar-item">
					<h4>Default View</h4>
					<select id="short-default-view"><option value="list" selected="selected">Default View</option><option value="list" >List View</option><option value="images" >Image View</option></select>	 
					<p><i class="fa fa-info-circle"></i> Default view option selected when the page is loaded.</p>
				</div>
					
				<div class="shortgen-bar-item">
					<h4>Posts Per Page</h4>  
					<input name="short-per-page" type="text" id="short-per-page" value="12" placeholder="Posts per page (default is 12)"/>
				<p><i class="fa fa-info-circle"></i> Number of posts that will be displayed per page and according to which the pagination is built.</p>
				</div>
					
				<div class="shortgen-bar-item">
					<h4>Color</h4>  	
					<input name="short-color" type="text" id="short-color" value="#777777" />
					<p><i class="fa fa-info-circle"></i> Hex color as theme color of the style of different elements.</p>
				</div>
					
				<div class="shortgen-bar-item">
					<h4>Post Type</h4>  
					<select id="short-post-type"><option value="post" selected="selected">Select Post Type</option><?php echo $postTypesHTML; ?></select>	 
					<p><i class="fa fa-info-circle"></i> Post type like "posts" or "portfolio"</p>
				</div>
					
				<div class="shortgen-bar-item">
					<h4>Social Media Sortby Options</h4>  
				<div class="short-box-container include_social_media-container">
					<div class="short-box">
						<h5>Included social media options:</h5>
						<div class="short-box-in"><span>facebook</span><span>twitter</span><span>stumbleupon</span><span>googleplus</span><span>linkedin</span><span>pinterest</span></div>
					</div>
					<div class="short-box">
						<h5>Removed options:</h5>
						<div class="short-box-out"></div>
					</div>
				</div>
				<input name="include_social_media" type="hidden" id="include_social_media" value="facebook,twitter,stumbleupon,googleplus,linkedin,pinterest" />
				<p><i class="fa fa-info-circle"></i> Select the social media you would like to be displayed under "social status" in the Sort by dropdown.</p>
				</div>
					
				<div class="shortgen-bar-item">
					<h4>Social Status Calculation</h4>  
				<div class="short-box-container sort_social_media-container">
					<div class="short-box">
						<h5>Included in social status calculation:</h5>
						<div class="short-box-in"><span>facebook</span><span>twitter</span><span>stumbleupon</span><span>googleplus</span><span>linkedin</span><span>pinterest</span></div>
					</div>
					<div class="short-box">
						<h5>Removed options:</h5>
						<div class="short-box-out"></div>
					</div>
				</div>
				<input name="sort_social_media" type="hidden" id="sort_social_media" value="facebook,twitter,stumbleupon,googleplus,linkedin,pinterest" />
				<p><i class="fa fa-info-circle"></i> Select the social media you want to include in the "social status" calculation.</p>
				</div>

					
				<div class="shortgen-bar-item">
					<h4>Custom Sort Option</h4>  
					<select id="short-custom"><option value="" selected="selected">Hide</option><option value="1" >Show</option></select>	 
					<p><i class="fa fa-info-circle"></i> Display or hide the custom sort option set in Settings.</p>
				</div>				
			
			</div>
			
		</div>
		<?php
	}
	if($tab=='settings'){
		$disable_font_awesome = get_option('disable_font_awesome');
		$sortable_cache = get_option('sortable_cache');
		$sortable_custom_meta = get_option('sortable_custom_meta');
		$sortable_custom_order = get_option('sortable_custom_order');
		$sortable_custom_text = get_option('sortable_custom_text');
		$sortable_premetatext = get_option('sortable_premetatext');
		$sortable_translate = get_option('sortable_translate');
		$sortable_translate_arr = explode('|',$sortable_translate);
		$default_sort_option = get_option('default-sort-option');
		?>

		<form method="post" action="admin.php?page=sortable_admin_view&tab=settings">
		<br>
		<div class="shortgen-bar-item">
			<h4>Default Sort Option</h4>
			<select name="default-sort-option" id="default-sort-option">
				<option value="social_status" <?php if($default_sort_option==''){ ?>selected="selected"<?php }?> >Default (Social Status)</option>
				<option value="social_status"  <?php if($default_sort_option=='social_status' ){ ?>selected="selected"<?php }?> >Social Status</option>
				<option value="social_facebook"  <?php if($default_sort_option=='social_facebook' ){ ?>selected="selected"<?php }?> >Facebook</option>
				<option value="social_twitter"  <?php if($default_sort_option=='social_twitter' ){ ?>selected="selected"<?php }?> >Twitter</option>
				<option value="social_google_plus"  <?php if($default_sort_option=='social_google_plus' ){ ?>selected="selected"<?php }?> >Google Plus</option>
				<option value="social_stumbleupon"  <?php if($default_sort_option=='social_stumbleupon' ){ ?>selected="selected"<?php }?> >StumbleUpon</option>
				<option value="social_linkedin"  <?php if($default_sort_option=='social_linkedin' ){ ?>selected="selected"<?php }?> >LinkedIn</option>
				<option value="social_pinterest"  <?php if($default_sort_option=='social_pinterest' ){ ?>selected="selected"<?php }?> >Pinterest</option>
				<option value="a-z"  <?php if($default_sort_option=='a-z' ){ ?>selected="selected"<?php }?> >A-Z</option>
				<option value="z-a"  <?php if($default_sort_option=='z-a' ){ ?>selected="selected"<?php }?> >Z-A</option>
				<option value="newest"  <?php if($default_sort_option=='newest' ){ ?>selected="selected"<?php }?> >Newest</option>
				<option value="oldest"  <?php if($default_sort_option=='oldest' ){ ?>selected="selected"<?php }?> >Oldest</option>
				<option value="comments"  <?php if($default_sort_option=='comments' ){ ?>selected="selected"<?php }?> >Comments</option>
			</select>	 
			<p><i class="fa fa-info-circle"></i> Overwrite the default sort option.</p>
		</div>
		<div class="shortgen-bar-item">
			<h4>Disable Font Awesome</h4>
			<select name="disable-font-awesome" id="disable-font-awesome">
				<option value="no" <?php if($disable_font_awesome=='no' || $disable_font_awesome==''){ ?>selected="selected"<?php }?> >No</option>
				<option value="yes"  <?php if($disable_font_awesome=='yes' ){ ?>selected="selected"<?php }?> >Yes</option>
			</select>	 
			<p><i class="fa fa-info-circle"></i> If font-awesome script is already included by another plugin or theme you can disable it here.</p>
		</div>
		<div class="shortgen-bar-item">
			<h4>Caching</h4>
			<input name="sortable-cache" id="sortable-cache" value="<?php if($sortable_cache=='') echo '20'; else echo $sortable_cache; ?>" type="text" /> minutes.
			<p><i class="fa fa-info-circle"></i> Cache statistics from social media, improves loading times. Set 0 to disable caching.</p>
			<h5>Manual Caching</h5>
			<select id="cache-post-type">
				<option value="post" selected="selected">Select Post Type</option><?php echo $postTypesHTML; ?>
			</select>
			<a class="button button-primary button-large"  href="javascript:void(0)" onclick="window.location.assign('admin.php?page=sortable_admin_view&tab=cache&pt='+jQuery('#cache-post-type').val())">Cache Now</a>
			<p><i class="fa fa-info-circle"></i> If you have a lot of posts that don't get cached automatically because of server problems, you can use this option.</p>
		</div>		
		<div class="shortgen-bar-item">
			<h4>Custom Sort Option</h4>
			<h5>Custom Meta Key</h5>
			<input name="sortable-custom-meta" id="sortable-custom-meta" value="<?php echo $sortable_custom_meta; ?>" placeholder="Enter custom meta key here.." type="text" /> 
			<p><i class="fa fa-info-circle"></i> Custom meta key can be anything that your plugins or theme is using like "price" or "size".</p>
			<h5>Ascending/Descending Order</h5>
			<select name="sortable-custom-order" id="sortable-custom-order" >
				<option value="" <?php if($sortable_custom_order==''){ ?>selected="selected"<?php }?> >Select order</option>
				<option value="ASC" <?php if($sortable_custom_order=='ASC'){ ?>selected="selected"<?php }?> >Ascending</option>
				<option value="DESC" <?php if($sortable_custom_order=='DESC'){ ?>selected="selected"<?php }?>>Descending</option>
			</select> 
			<p><i class="fa fa-info-circle"></i> For example if price key is ascending it will show the lowest prices first.</p>
			<h5>Sort Name (Text)</h5>
			<input name="sortable-custom-text" id="sortable-custom-text" value="<?php echo $sortable_custom_text; ?>" placeholder="Enter text here.." type="text" /> 
			<p><i class="fa fa-info-circle"></i> Sort text can be anything like "Price (low to high)".</p>
			<h5>Pre-meta Text</h5>
			<input name="sortable-premetatext" id="sortable-premetatext" value="<?php echo $sortable_premetatext; ?>" type="text" />
			<p><i class="fa fa-info-circle"></i> Text displayed before the meta field, for example $ for price.</p>

		</div>	
		<input name="sortable-translate" id="sortable-translate" value="<?php echo $sortable_translate; ?>" type="hidden" /> 
		<div class="shortgen-bar-item labels-translations">
			<h4>Labels & Translations</h4>
		
			
			<h5>"Sort by:"</h5>
			<p><input name="sortable-translate-0" id="sortable-translate-0" value="<?php echo $sortable_translate_arr[0]; ?>" type="text" /> </p>
			<h5>"Social Status"</h5>
			<p><input name="sortable-translate-1" id="sortable-translate-1" value="<?php echo $sortable_translate_arr[1]; ?>" type="text" /> </p>
			<h5>"Facebook Shares"</h5>
			<p><input name="sortable-translate-2" id="sortable-translate-2" value="<?php echo $sortable_translate_arr[2]; ?>" type="text" /> </p>
			<h5>"Twitter Shares"</h5>
			<p><input name="sortable-translate-3" id="sortable-translate-3" value="<?php echo $sortable_translate_arr[3]; ?>" type="text" /> </p>
			<h5>"Google Plus Shares"</h5>
			<p><input name="sortable-translate-4" id="sortable-translate-4" value="<?php echo $sortable_translate_arr[4]; ?>" type="text" /> </p>
			<h5>"StumbeUpon Shares"</h5>
			<p><input name="sortable-translate-5" id="sortable-translate-5" value="<?php echo $sortable_translate_arr[5]; ?>" type="text" /> </p>
			<h5>"LinkedIn Shares"</h5>
			<p><input name="sortable-translate-6" id="sortable-translate-6" value="<?php echo $sortable_translate_arr[6]; ?>" type="text" /> </p>			
			<h5>"Pinterest Shares"</h5>
			<p><input name="sortable-translate-7" id="sortable-translate-7" value="<?php echo $sortable_translate_arr[7]; ?>" type="text" /> </p>		
			<h5>"A-Z Alphabetically"</h5>
			<p><input name="sortable-translate-8" id="sortable-translate-8" value="<?php echo $sortable_translate_arr[8]; ?>" type="text" /> </p>		
			<h5>"Z-A Alphabetically"</h5>
			<p><input name="sortable-translate-9" id="sortable-translate-9" value="<?php echo $sortable_translate_arr[9]; ?>" type="text" /> </p>
			<h5>"Newest"</h5>
			<p><input name="sortable-translate-10" id="sortable-translate-10" value="<?php echo $sortable_translate_arr[10]; ?>" type="text" /> </p>
			<h5>"Oldest"</h5>
			<p><input name="sortable-translate-11" id="sortable-translate-11" value="<?php echo $sortable_translate_arr[11]; ?>" type="text" /> </p>
			<h5>"Most Commented"</h5>
			<p><input name="sortable-translate-12" id="sortable-translate-12" value="<?php echo $sortable_translate_arr[12]; ?>" type="text" /> </p>
			<h5>"Read More"</h5>
			<p><input name="sortable-translate-13" id="sortable-translate-13" value="<?php echo $sortable_translate_arr[13]; ?>" type="text" /> </p>
			<h5>"Posted by"</h5>
			<p><input name="sortable-translate-14" id="sortable-translate-14" value="<?php echo $sortable_translate_arr[14]; ?>" type="text" /> </p>
			<h5>"on"</h5>
			<p><input name="sortable-translate-15" id="sortable-translate-15" value="<?php echo $sortable_translate_arr[15]; ?>" type="text" /> </p>
			
		</div>		
		<input type="submit" value="Save" class="button button-primary" name="save-settings" id="save-settings"/>
		</form>
		<?php
	}
	if($tab=='shortcodes'){
	?>
	
			<div style="clear:both"></div>
	 
			 <p>Copy/paste shortcode in your page, post or widget</p>
			 <input name="sortable-short" type="text" id="sortable-short" value="[sortable][/sortable]" onclick="jQuery(this).select();" style="width:100%;"/>
				
	<?php
	}
	if($tab=='pages'){
		
		?>
		

		 <input name="sortable-short" type="hidden" id="sortable-short" value="[sortable][/sortable]" onclick="jQuery(this).select();" style="width:100%;"/>
		<p><input type="submit" value="Set" class="button-primary button" /></p>
		</form>
		<?php
	}
	?>
</div>
<?php
}
?>