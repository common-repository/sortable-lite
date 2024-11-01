<?php 
global $sortable;
get_header(); ?>
	<?php
	
	?>
	<div id="content" style="width:100%;" >
		<?php
		if(have_posts()): the_post();
		?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<div class="post-content">
			<?php echo do_shortcode(get_post_meta(get_the_ID(),'sortable',true));?>
			</div>
		
		
		</div>
		<?php endif; ?>
	</div>

<?php get_footer(); ?>