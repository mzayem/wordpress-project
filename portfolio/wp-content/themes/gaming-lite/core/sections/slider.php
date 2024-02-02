<?php if ( get_theme_mod('gaming_lite_blog_box_enable') ) : ?>

<?php $gaming_lite_args = array(
  'post_type' => 'post',
  'post_status' => 'publish',
  'category_name' =>  get_theme_mod('gaming_lite_blog_slide_category'),
  'posts_per_page' => get_theme_mod('gaming_lite_blog_slide_number'),
); ?>

<div class="slider">
  <div class="owl-carousel">
    <?php $gaming_lite_arr_posts = new WP_Query( $gaming_lite_args );
    if ( $gaming_lite_arr_posts->have_posts() ) :
      while ( $gaming_lite_arr_posts->have_posts() ) :
        $gaming_lite_arr_posts->the_post();
        ?>
        <div class="blog_inner_box">
          <?php
            if ( has_post_thumbnail() ) :
              the_post_thumbnail();
            endif;
          ?>
          <div class="blog_box pt-3 pt-md-0">
            <h6><?php echo esc_html( get_theme_mod('gaming_lite_slider_short_title' ) ); ?></h6>
            <?php if ( get_theme_mod('gaming_lite_title_unable_disable',true) ) : ?>
            <h3 class="my-3"><?php the_title(); ?></a></h3>
            <?php endif; ?>
            <?php if ( get_theme_mod('gaming_lite_button_unable_disable',true) ) : ?>
            <p class="slider-button mt-4">
              <a href="<?php echo esc_url(get_permalink($post->ID)); ?>"><?php esc_html_e('KNOW MORE','gaming-lite'); ?></a>
              <?php endif; ?>
            </p>
          </div>
        </div>
      <?php
    endwhile;
    wp_reset_postdata();
    endif; ?>
  </div>
</div>

<?php endif; ?>