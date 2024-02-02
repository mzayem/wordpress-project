<?php if ( get_theme_mod('gaming_lite_latest_game_section_enable', true) == true ) : ?>
<div id="latest_game" class="py-5">
	<div class="container text-center">
    <?php if ( get_theme_mod('gaming_lite_latest_game_sub_heading') ) : ?>
		  <h5><?php echo esc_html(get_theme_mod('gaming_lite_latest_game_sub_heading'));?></h5>
    <?php endif; ?>
    <?php if ( get_theme_mod('gaming_lite_latest_game_main_heading') ) : ?>
		  <h3 class="mt-3"><?php echo esc_html(get_theme_mod('gaming_lite_latest_game_main_heading'));?></h3>
    <?php endif; ?>
    <div class="row mt-5">
      <div class="col-lg-2">
      </div>
      <div class="col-lg-4 col-md-4">
        <?php if(class_exists('woocommerce')){ ?>
          <button class="product-btn"><?php echo esc_html_e('System Type','gaming-lite'); ?><i class="fas fa-chevron-down"></i></button>
          <div class="product-cat">
            <?php
              $gaming_lite_args = array(
                'orderby'    => 'title',
                'order'      => 'ASC',
                'hide_empty' => 0,
                'parent'  => 0
              );
              $product_categories = get_terms( 'product_cat', $gaming_lite_args );
              $gaming_lite_count = count($product_categories);
              if ( $gaming_lite_count > 0 ){
                  foreach ( $product_categories as $gaming_lite_product_category ) {
                    $product_cat_id   = $gaming_lite_product_category->term_id;
                    $cat_link = get_category_link( $product_cat_id );
                    if ($gaming_lite_product_category->category_parent == 0) { ?>
                  <li class="drp_dwn_menu"><a href="<?php echo esc_url(get_term_link( $gaming_lite_product_category ) ); ?>">
                  <?php
                }
                echo esc_html( $gaming_lite_product_category->name ); ?></a><i class="fas fa-chevron-right ml-3"></i></li>
            <?php } } ?>
          </div>
        <?php }?>
      </div>
      <div class="col-lg-4 col-md-4">
        <?php if(class_exists('woocommerce')){ ?>
          <form method="get" class="woocommerce-product-search" action="<?php echo esc_url(home_url('/')); ?>">
            <label class="screen-reader-text" for="woocommerce-product-search-field"><?php esc_html_e('Search for:', 'gaming-lite'); ?></label>
            <input type="search" id="woocommerce-product-search-field" class="search-field " placeholder="<?php echo esc_attr('Search Hear','gaming-lite'); ?>" value="<?php echo get_search_query(); ?>" name="s"/>
            <button type="submit" value="" class="search-button"><i class="fas fa-search"></i></button>
            <input type="hidden" name="post_type" value="product"/>
          </form>
        <?php }?>
      </div>
      <div class="col-lg-2">
      </div>
    </div>
    <div class="row">
      <?php
      $gaming_lite_product_data = get_theme_mod('gaming_lite_latest_game_category');
      if ( class_exists( 'WooCommerce' ) ) {
        $args = array(
          'post_type' => 'product',
          'posts_per_page' => get_theme_mod('gaming_lite_latest_game_per_page'),
          'product_cat' => $gaming_lite_product_data,
          'order' => 'ASC'
        );
        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
        	<div class="col-xl-3 col-lg-4 col-md-6 mb-3">
            <div class="tab-product">
              <div class="product-image my-lg-4  my-md-2 my-3 box">
                <figure>
                  <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.esc_url(woocommerce_placeholder_img_src()).'" />'; ?>
                </figure>
              </div>
              <div class="product-details text-left align-self-center">
              	<span class="align-self-center">
            	    <?php if( $product->is_type( 'simple' ) ){ woocommerce_template_loop_rating( $loop->post, $product ); } ?>
            	    <h4 class="product-text mt-2 "><a href="<?php echo esc_url(get_permalink( $loop->post->ID )); ?>"><?php the_title(); ?></a></h4>
                </span>
                <span class="cart-button">
                  <span class="icon" href="<?php if(function_exists('wc_get_cart_url')){ echo esc_url(wc_get_cart_url()); } ?>"><span class="button1"><?php if( $product->is_type( 'simple' ) ) { woocommerce_template_loop_add_to_cart(  $loop->post, $product );} ?></span></span>
                </span>
              </div>
            </div>
          </div>
        <?php endwhile; wp_reset_query(); ?>
      <?php } ?>
	  </div>
	</div>
</div>
<?php endif; ?>
