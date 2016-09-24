<div id="sidebar" class="sidebar clearfix" role="complementary">

	<?php if ( is_active_sidebar( 'sidebar1' ) ) : ?>

		<?php dynamic_sidebar( 'sidebar1' ); ?>

	<?php else : ?>

		<!-- This content shows up if there are no widgets defined in the backend. -->
		
		<div class="alert help">
			<p><?php _e("Please activate some Widgets.", "primertheme");  ?></p>
		</div>

	<?php endif; ?>

</div><!-- end #sidebar -->