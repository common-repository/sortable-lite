		jQuery(document).ready(function(){
		jQuery('#sortable-translate-0,#sortable-translate-1,#sortable-translate-2,#sortable-translate-3,#sortable-translate-4,#sortable-translate-5,#sortable-translate-6,#sortable-translate-7,#sortable-translate-8,#sortable-translate-9,#sortable-translate-10,#sortable-translate-11,#sortable-translate-12,#sortable-translate-13,#sortable-translate-14,#sortable-translate-15').change(function(){
			var labels=''; var i =0;
			jQuery('.labels-translations input').each(function(){ 
				if(i!=0){ labels = labels+'|'+jQuery(this).val(); } else {
				labels = jQuery(this).val(); 
				}
				i++;
			});
			jQuery('#sortable-translate').val(labels);
		});
		});

	function changeShortcodeField(){
			var social_status = (jQuery('#short-social-status').val()!='1')?' social_status="'+jQuery('#short-social-status').val()+'"':'';
		var alphabetically = (jQuery('#short-alphabetically').val()!='1')?' alphabetically="'+jQuery('#short-alphabetically').val()+'"':'';
		var comments = (jQuery('#short-comments').val()!='1')?' comments="'+jQuery('#short-comments').val()+'"':'';
		var show_stats = (jQuery('#short-show-stats').val()!='0')?' show_stats="'+jQuery('#short-show-stats').val()+'"':'';
		var post_type = (jQuery('#short-post-type').val()!='post')?' post_type="'+jQuery('#short-post-type').val()+'"':'';
		var default_view = (jQuery('#short-default-view').val()!='list')?' default_view="'+jQuery('#short-default-view').val()+'"':'';		
		var per_page = (jQuery('#short-per-page').val()!='12')?' per_page="'+jQuery('#short-per-page').val()+'"':'';			
		var color = (jQuery('#short-color').val()!='#777777')?' color="'+jQuery('#short-color').val()+'"':'';		
		var include_social_media = (jQuery('#include_social_media').val()!='facebook,twitter,stumbleupon,googleplus,linkedin,pinterest')?' include_social_media="'+jQuery('#include_social_media').val()+'"':'';
		var custom = (jQuery('#short-custom').val()!='')?' custom="'+jQuery('#short-custom').val()+'"':'';
		
		var sort_social_media = (jQuery('#sort_social_media').val()!='facebook,twitter,stumbleupon,googleplus,linkedin,pinterest')?' sort_social_media="'+jQuery('#sort_social_media').val()+'"':'';
		jQuery('#sortable-short').val('[sortable '+post_type+social_status+alphabetically+comments+show_stats+default_view+per_page+color+include_social_media+sort_social_media+custom+'][/sortable]');
	
	}
	jQuery(document).ready(function(){

		jQuery('#include_social_media,#short-social-status, #short-alphabetically, #short-comments,#short-custom, #short-post-type,#short-show-stats, #short-default-view, #short-per-page').change(function(){
			changeShortcodeField();
		});
		jQuery('.include_social_media-container .short-box-in span,.include_social_media-container .short-box-out span').click(function(){
			var par = jQuery(this).parent().attr('class');
			if(par=='short-box-in'){
			jQuery('.include_social_media-container .short-box-out').append(jQuery(this));
			} else {
			jQuery('.include_social_media-container .short-box-in').append(jQuery(this));
			}
			var include = ''; var i =0;
			jQuery('.include_social_media-container .short-box-in span').each(function(){
				if(i!=0) include +=',';
				include += jQuery(this).text();
				i++;
			});
			
			jQuery('#include_social_media').val(include);
			changeShortcodeField();
		});
		
		jQuery('.sort_social_media-container .short-box-in span,.sort_social_media-container .short-box-out span').click(function(){
			var par = jQuery(this).parent().attr('class');
			if(par=='short-box-in'){
			jQuery('.sort_social_media-container .short-box-out').append(jQuery(this));
			} else {
			jQuery('.sort_social_media-container .short-box-in').append(jQuery(this));
			}
			var include = ''; var i =0;
			jQuery('.sort_social_media-container .short-box-in span').each(function(){
				if(i!=0) include +=',';
				include += jQuery(this).text();
				i++;
			});
			
			jQuery('#sort_social_media').val(include);
			changeShortcodeField();
		});
	});