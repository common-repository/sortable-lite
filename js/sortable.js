jQuery(document).ready(function() {
	
	jQuery('.sortable-list').click(function(){
		var rand = jQuery(this).parent().parent().attr('rand');
		jQuery('#sortableContainer'+rand).addClass('sortable-list-view').removeClass('sortable-images-view');
		jQuery('#sortableTop'+rand+' .sortable-list').addClass('active'); jQuery('#sortableTop'+rand+' .sortable-images').removeClass('active');
	});
	
	jQuery('.sortable-images').click(function(){
		var rand = jQuery(this).parent().parent().attr('rand');
		jQuery('#sortableContainer'+rand).addClass('sortable-images-view').removeClass('sortable-list-view');
		jQuery('#sortableTop'+rand+' .sortable-images').addClass('active'); jQuery('#sortableTop'+rand+' .sortable-list').removeClass('active');
	});
	
	jQuery('.sortable-top .sortable-dropdown').hover(function(){
		jQuery(this).addClass('dropdown-active');
	},function(){
		jQuery(this).removeClass('dropdown-active');
	});
	
	jQuery('.sortable-top .sortable-dropdown-ul a').click(function(event){
		event.preventDefault(); 
		if(jQuery(this).parent().parent().prev().hasClass('sort-social-media-link')){
		var rand = jQuery(this).parent().parent().parent().parent().attr('rand');
		} else {
		var rand = jQuery(this).parent().parent().attr('rand');
		}
		var paged = (jQuery(this).attr('paged')=='' || jQuery(this).attr('paged')==undefined)?1:jQuery(this).attr('paged');
		sortable_ajax(rand,jQuery(this).attr('sort-by'),jQuery(this).attr('post-type'),jQuery(this).attr('per-page'),paged,jQuery(this).html(),jQuery('.sort-social-media-link').attr('sort-social-media'));
	});
	
	paginationClick();
});

function sortable_count(post_type){


	var data = {
		'action': 'sortable_count',
		'post_type':post_type,
		'whatever': ajax_object.we_value      // We pass php values differently!
	};
	
	// We can also pass the url value separately from ajaxurl for front end AJAX implementations
	jQuery.ajax({
		type: 'POST',
		url: ajax_object.ajax_url,
		data: data,
		timeout: 60000,
		error: function() {  },
		success: function(response){
		jQuery('.social-share-stats:last').append('<div style="display:none">'+response+'</div>');
		
		}
		});

}
	
function sortable_ajax(rand,sortby,post_type,per_page,paged,sortbytext,sort_social_media){

if(sort_social_media==undefined){ sort_social_media ='facebook,twitter,stumbleupon,googleplus,linkedin,pinterest';}
	jQuery('#sortableContainer'+rand+' .sortable-row').animate({'opacity':'0'},300);
	jQuery('#sortableContainer'+rand+' .sortable-loading').css({'display':'table','opacity':'1'});
	var data = {
		'action': 'sortable',
		'sortby': sortby,
		'post_type':post_type,
		'per_page':per_page,
		'paged':paged,
		'rand':rand,
		'sort_social_media':sort_social_media,
		'whatever': ajax_object.we_value      // We pass php values differently!
	};
	
	// We can also pass the url value separately from ajaxurl for front end AJAX implementations
	
	jQuery.post(ajax_object.ajax_url, data, function(response) {

		jQuery("#sortableMenu"+rand+" span").html(sortbytext);
		var stNew = setTimeout(function(){ paginationClick(); },1500 );
		 jQuery('#sortableContainer'+rand).html(response);	
		jQuery('#sortableContainer'+rand).animate({'opacity':'1'},300);

		jQuery('#sortableContainer'+rand+' .sortable-loading').hide().css({'opacity':'0'});

		paginationClick();
	});

}
function paginationClick(){
	jQuery('.sortable-pagination a').click(function(event){
		event.preventDefault(); 
		var rand = jQuery(this).parent().parent().attr('rand');
		var paged = (jQuery(this).attr('paged')=='' || jQuery(this).attr('paged')==undefined)?1:jQuery(this).attr('paged');
		var sortbytext = jQuery('#sortableMenu'+rand+' span').text();
		var sortableTop = Number(jQuery("#sortableTop"+rand).offset().top)-100;
		jQuery('html, body').animate({
        scrollTop: sortableTop
		}, 1000);
		sortable_ajax(rand,jQuery(this).attr('sort-by'),jQuery(this).attr('post-type'),jQuery(this).attr('per-page'),paged,sortbytext,jQuery('.sort-social-media-link').attr('sort-social-media'));
	});
}


	function sortable_count_all(post_type,paged){

			var data = {
				'action': 'sortable_count_all',
				'post_type':post_type,
				'paged':paged,
				'whatever': ajax_object.we_value      // We pass php values differently!
			};
			
			// We can also pass the url value separately from ajaxurl for front end AJAX implementations
			jQuery.ajax({
				type: 'POST',
				url: ajax_object.ajax_url,
				data: data,
				timeout: 60000,
				error: function(){  },
				success: function(response){
					if(response!=''){
						var pagedP=paged+1;				
						sortable_count_all(post_type,pagedP);			
					}else{
					var pagedP=paged+1;		
						ptn++;
						var post_type_next = all_post_types[ptn]; 
						if(post_type_next!='' && post_type_next!=undefined){ sortable_count_all(post_type_next,1);	}
						else { jQuery('.building-cache').html('<h3>Done!</h3><p>Social cache built successfully! <a href="admin.php?page=sortable_admin_view&tab=settings">Return to Settings &raquo</a></p>'); }
					}
					jQuery('#cache-management-feed').append(response);
				}
			});

	}
		
	function sortable_count_all2(post_type,paged){

			var data = {
				'action': 'sortable_count_all',
				'post_type':post_type,
				'paged':paged,
				'whatever': ajax_object.we_value      // We pass php values differently!
			};
			
			// We can also pass the url value separately from ajaxurl for front end AJAX implementations
			jQuery.ajax({
				type: 'POST',
				url: ajax_object.ajax_url,
				data: data,
				timeout: 60000,
				error: function(){  },
				success: function(response){
					if(response!=''){
						var pagedP=paged+1;				
						sortable_count_all2(post_type,pagedP);			
					}else{
						
					}
					//jQuery('#cache-management-feed').append(response);
				}
			});

	}