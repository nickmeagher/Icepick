<?php get_header(); ?>


  <div class="container">
  	<div class="row">
  		<div class="col-lg-9">
    		
    		<?php if (is_category()) { ?>
			    <h1 class="archive-title h2">
				    <span><?php _e("Posts Categorized:", "primertheme"); ?></span> <?php single_cat_title(); ?>
		    	</h1>
		    
		    <?php } elseif (is_tag()) { ?> 
			    <h1 class="archive-title h2">
				    <span><?php _e("Posts Tagged:", "primertheme"); ?></span> <?php single_tag_title(); ?>
			    </h1>
		    
		    <?php } elseif (is_author()) { 
		    	global $post;
		    	$author_id = $post->post_author;
		    ?>
			    <h1 class="archive-title h2">

			    	<span><?php _e("Posts By:", "primertheme"); ?></span> <?php echo get_the_author_meta('display_name', $author_id); ?>

			    </h1>
		    <?php } elseif (is_day()) { ?>
			    <h1 class="archive-title h2">
						<span><?php _e("Daily Archives:", "primertheme"); ?></span> <?php the_time('l, F j, Y'); ?>
			    </h1>

  			<?php } elseif (is_month()) { ?>
    		    <h1 class="archive-title h2">
	    	    	<span><?php _e("Monthly Archives:", "primertheme"); ?></span> <?php the_time('F Y'); ?>
		        </h1>
		
		    <?php } elseif (is_year()) { ?>
		        <h1 class="archive-title h2">
		    	    <span><?php _e("Yearly Archives:", "primertheme"); ?></span> <?php the_time('Y'); ?>
		        </h1>
		    <?php } ?>
    		
    		
  		  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  			
          <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
        
            <header class="article-header">
            
              <h3 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
              <p class="byline vcard"><?php
                printf(__('Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'primertheme'), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), primer_get_the_author_posts_link(), get_the_category_list(', '));
              ?></p>
        
            </header> <!-- end article header -->
        
            <section class="entry-content clearfix">
        	    <?php the_content(); ?>
            </section> <!-- end article section -->
        
            <footer class="article-footer">
        			<p class="tags"><?php the_tags('<span class="tags-title">' . __('Tags:', 'primertheme') . '</span> ', ', ', ''); ?></p>
            </footer> <!-- end article footer -->
            
            <?php comments_template(); ?>
            
          </article> <!-- end article -->
        
          <?php endwhile; ?>	
        
              <?php if (function_exists('primer_page_navi')) { ?>
                  <?php primer_page_navi(); ?>
              <?php } else { ?>
                  <nav class="wp-prev-next">
                      <ul class="clearfix">
              	        <li class="prev-link"><?php next_posts_link(__('&laquo; Older Entries', "primertheme")) ?></li>
              	        <li class="next-link"><?php previous_posts_link(__('Newer Entries &raquo;', "primertheme")) ?></li>
                      </ul>
                  </nav>
              <?php } ?>		
        
          <?php else : ?>
      					    
              <article id="post-not-found" class="hentry clearfix">
                  <header class="article-header">
              	    <h1><?php _e("Oops, Post Not Found!", "primertheme"); ?></h1>
              	</header>
                  <section class="entry-content">
              	    <p><?php _e("Uh Oh. Something is missing. Try double checking things.", "primertheme"); ?></p>
              	</section>
              	<footer class="article-footer">
              	    <p><?php _e("This is the error message in the index.php template.", "primertheme"); ?></p>
              	</footer>
              </article>
          
          <?php endif; ?>
          
  		</div><!-- end .col-lg-9 -->
  		
  		<div class="col-lg-3">
    		<?php get_sidebar(); ?>
  		</div><!-- end .col-lg-3 -->
  		
  	</div><!-- end .row -->
  </div><!-- end .container -->


<?php get_footer(); ?>
