<?php

/*-----------------------------------------------------------------------------------*/
/* Enqueue script and styles */
/*-----------------------------------------------------------------------------------*/

function gaming_lite_enqueue_google_fonts() {

	require_once get_theme_file_path( 'core/includes/wptt-webfont-loader.php' );

	wp_enqueue_style( 'google-fonts-inter', 'https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap' );
}
add_action( 'wp_enqueue_scripts', 'gaming_lite_enqueue_google_fonts' );

if (!function_exists('gaming_lite_enqueue_scripts')) {

	function gaming_lite_enqueue_scripts() {

		wp_enqueue_style(
			'bootstrap-css',
			get_template_directory_uri() . '/css/bootstrap.css',
			array(),'4.5.0'
		);

		wp_enqueue_style(
			'fontawesome-css',
			get_template_directory_uri() . '/css/fontawesome-all.css',
			array(),'4.5.0'
		);

		wp_enqueue_style(
			'owl.carousel-css',
			get_template_directory_uri() . '/css/owl.carousel.css',
			array(),'2.3.4'
		);

		wp_enqueue_style('gaming-lite-style', get_stylesheet_uri(), array() );

		wp_style_add_data('gaming-lite-style', 'rtl', 'replace');

		wp_enqueue_style(
			'gaming-lite-media-css',
			get_template_directory_uri() . '/css/media.css',
			array(),'2.3.4'
		);

		wp_enqueue_style(
			'gaming-lite-woocommerce-css',
			get_template_directory_uri() . '/css/woocommerce.css',
			array(),'2.3.4'
		);

		wp_enqueue_script(
			'gaming-lite-navigation',
			get_template_directory_uri() . '/js/navigation.js',
			FALSE,
			'1.0',
			TRUE
		);

		wp_enqueue_script(
			'owl.carousel-js',
			get_template_directory_uri() . '/js/owl.carousel.js',
			array('jquery'),
			'2.3.4',
			TRUE
		);

		wp_enqueue_script(
			'gaming-lite-script',
			get_template_directory_uri() . '/js/script.js',
			array('jquery'),
			'1.0',
			TRUE
		);

		if ( is_singular() ) wp_enqueue_script( 'comment-reply' );

		$gaming_lite_css = '';

		if ( get_header_image() ) :

			$gaming_lite_css .=  '
				.main-header-box,.page-template-frontpage .inner-header-box{
					background-image: url('.esc_url(get_header_image()).');
					-webkit-background-size: cover !important;
					-moz-background-size: cover !important;
					-o-background-size: cover !important;
					background-size: cover !important;
				}';

		endif;

		wp_add_inline_style( 'gaming-lite-style', $gaming_lite_css );

		// Theme Customize CSS.
		require get_template_directory(). '/core/includes/inline.php';
		wp_add_inline_style( 'gaming-lite-style',$gaming_lite_custom_css );

	}

	add_action( 'wp_enqueue_scripts', 'gaming_lite_enqueue_scripts' );

}

/*-----------------------------------------------------------------------------------*/
/* Setup theme */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('gaming_lite_after_setup_theme')) {

	function gaming_lite_after_setup_theme() {

		if ( ! isset( $content_width ) ) $content_width = 900;

		register_nav_menus( array(
			'main-menu' => esc_html__( 'Main menu', 'gaming-lite' ),
		));

		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'align-wide' );
		add_theme_support('title-tag');
		add_theme_support('automatic-feed-links');
		add_theme_support( 'wp-block-styles' );
		add_theme_support('post-thumbnails');
		add_theme_support( 'custom-background', array(
		  'default-color' => 'f3f3f3'
		));

		add_theme_support( 'custom-logo', array(
			'height'      => 70,
			'width'       => 70,
		) );

		add_theme_support( 'custom-header', array(
			'header-text' => false,
			'width' => 1920,
			'height' => 100
		));

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		add_editor_style( array( '/css/editor-style.css' ) );
	}

	add_action( 'after_setup_theme', 'gaming_lite_after_setup_theme', 999 );

}

require get_template_directory() .'/core/includes/main.php';
require get_template_directory() .'/core/includes/tgm.php';
require get_template_directory() . '/core/includes/customizer.php';
load_template( trailingslashit( get_template_directory() ) . '/core/includes/class-upgrade-pro.php' );

/*-----------------------------------------------------------------------------------*/
/* Enqueue theme logo style */
/*-----------------------------------------------------------------------------------*/
function gaming_lite_logo_resizer() {

    $gaming_lite_theme_logo_size_css = '';
    $gaming_lite_logo_resizer = get_theme_mod('gaming_lite_logo_resizer');

	$gaming_lite_theme_logo_size_css = '
		.custom-logo{
			height: '.esc_attr($gaming_lite_logo_resizer).'px !important;
			width: '.esc_attr($gaming_lite_logo_resizer).'px !important;
		}
	';
    wp_add_inline_style( 'gaming-lite-style',$gaming_lite_theme_logo_size_css );

}
add_action( 'wp_enqueue_scripts', 'gaming_lite_logo_resizer' );

/*-----------------------------------------------------------------------------------*/
/* Enqueue Global color style */
/*-----------------------------------------------------------------------------------*/
function gaming_lite_global_color() {

    $gaming_lite_theme_color_css = '';
    $gaming_lite_global_color = get_theme_mod('gaming_lite_global_color');
    $gaming_lite_global_color_2 = get_theme_mod('gaming_lite_global_color_2');

	$gaming_lite_theme_color_css = '
		.sign-button a.signin-box,.logo,#main-menu ul.children li a:hover,#main-menu ul.sub-menu li a:hover,p.slider-button a,.slider button.owl-prev i:hover, .slider button.owl-next i:hover,.pagination .nav-links a:hover,.pagination .nav-links a:focus,.pagination .nav-links span.current,.gaming-lite-pagination span.current,.gaming-lite-pagination span.current:hover,.gaming-lite-pagination span.current:focus,.gaming-lite-pagination a span:hover,.gaming-lite-pagination a span:focus,.comment-respond input#submit,.comment-reply a,.sidebar-area h4.title,.sidebar-area .tagcloud a,.searchform input[type=submit],.searchform input[type=submit]:hover ,.searchform input[type=submit]:focus,.scroll-up a,nav.woocommerce-MyAccount-navigation ul li,.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.woocommerce a.added_to_cart,#latest_game li.drp_dwn_menu:hover{
			background: '.esc_attr($gaming_lite_global_color).';
		}
		a:hover,a:focus,.top-header p i,.social-links i:hover,.sign-button a.signin-box:hover,.sign-button a.signup-box:hover,#main-menu a:hover,#main-menu ul li a:hover,#main-menu li:hover > a,#main-menu a:focus,#main-menu li.focus > a,#main-menu li:focus > a,#main-menu ul li.current-menu-item > a,#main-menu ul li.current_page_item > a,#main-menu ul li.current-menu-parent > a,#main-menu ul li.current_page_ancestor > a,#main-menu ul li.current-menu-ancestor > a,.post-meta i,.blog_inner_box h6,p.slider-button a:hover,.slider button.owl-prev i, .slider button.owl-next i,.woocommerce ul.products li.product .price,.woocommerce div.product p.price, .woocommerce div.product span.price,#latest_game h5,#latest_game .icon:before,#latest_game .icon .button1 a.button.product_type_simple.add_to_cart_button.ajax_add_to_cart,#latest_game h4 a:hover,#latest_game .star-rating span::before,#latest_game a.added_to_cart.wc-forward{
			color: '.esc_attr($gaming_lite_global_color).';
		}
		.slider button.owl-prev i:hover, .slider button.owl-next i:hover{
			border-color: '.esc_attr($gaming_lite_global_color).';
		}
		@media screen and (min-width: 320px) and (max-width: 767px){
	         .menu-toggle, .dropdown-toggle,.sign-button a.signup-box,button.close-menu {
	        background: '.esc_attr($gaming_lite_global_color).';
	 		}
		}
		.page-template-frontpage .inner-header-box,.main-header-box,.blog_inner_box,.comment-respond input#submit:hover,.comment-reply a:hover,.sidebar-area .tagcloud a:hover,footer,nav.woocommerce-MyAccount-navigation ul li:hover,.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover,.woocommerce a.added_to_cart:hover,.woocommerce ul.products li.product .onsale, .woocommerce span.onsale,.scroll-up a:hover,p.slider-button a:hover{
			background: '.esc_attr($gaming_lite_global_color_2).';
		}
		a,h1,h2,h3,h4,h5,h6,#main-menu ul.children li a ,#main-menu ul.sub-menu li a{
			color: '.esc_attr($gaming_lite_global_color_2).';
		}
		.sidebar-area h4.title{
			border-color: '.esc_attr($gaming_lite_global_color_2).';
		}
		@media screen and (min-width: 320px) and (max-width: 767px){
	         .page-template-frontpage .main-header-box {
	        background: '.esc_attr($gaming_lite_global_color_2).';
	 		}
		}
	';
    wp_add_inline_style( 'gaming-lite-style',$gaming_lite_theme_color_css );
    wp_add_inline_style( 'gaming-lite-woocommerce-css',$gaming_lite_theme_color_css );

}
add_action( 'wp_enqueue_scripts', 'gaming_lite_global_color' );

/*-----------------------------------------------------------------------------------*/
/* Get post comments */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('gaming_lite_comment')) :
    /**
     * Template for comments and pingbacks.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     */
    function gaming_lite_comment($comment, $args, $depth){

        if ('pingback' == $comment->comment_type || 'trackback' == $comment->comment_type) : ?>

            <li id="comment-<?php comment_ID(); ?>" <?php comment_class('media'); ?>>
            <div class="comment-body">
                <?php esc_html_e('Pingback:', 'gaming-lite');
                comment_author_link(); ?><?php edit_comment_link(__('Edit', 'gaming-lite'), '<span class="edit-link">', '</span>'); ?>
            </div>

        <?php else : ?>

        <li id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body media mb-4">
                <a class="pull-left" href="#">
                    <?php if (0 != $args['avatar_size']) echo get_avatar($comment, $args['avatar_size']); ?>
                </a>
                <div class="media-body">
                    <div class="media-body-wrap card">
                        <div class="card-header">
                            <h5 class="mt-0"><?php /* translators: %s: author */ printf('<cite class="fn">%s</cite>', get_comment_author_link() ); ?></h5>
                            <div class="comment-meta">
                                <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                                    <time datetime="<?php comment_time('c'); ?>">
                                        <?php /* translators: %s: Date */ printf( esc_attr('%1$s at %2$s', '1: date, 2: time', 'gaming-lite'), esc_attr( get_comment_date() ), esc_attr( get_comment_time() ) ); ?>
                                    </time>
                                </a>
                                <?php edit_comment_link( __( 'Edit', 'gaming-lite' ), '<span class="edit-link">', '</span>' ); ?>
                            </div>
                        </div>

                        <?php if ('0' == $comment->comment_approved) : ?>
                            <p class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'gaming-lite'); ?></p>
                        <?php endif; ?>

                        <div class="comment-content card-block">
                            <?php comment_text(); ?>
                        </div>

                        <?php comment_reply_link(
                            array_merge(
                                $args, array(
                                    'add_below' => 'div-comment',
                                    'depth' => $depth,
                                    'max_depth' => $args['max_depth'],
                                    'before' => '<footer class="reply comment-reply card-footer">',
                                    'after' => '</footer><!-- .reply -->'
                                )
                            )
                        ); ?>
                    </div>
                </div>
            </article>

            <?php
        endif;
    }
endif; // ends check for gaming_lite_comment()

if (!function_exists('gaming_lite_widgets_init')) {

	function gaming_lite_widgets_init() {

		register_sidebar(array(

			'name' => esc_html__('Sidebar','gaming-lite'),
			'id'   => 'gaming-lite-sidebar',
			'description'   => esc_html__('This sidebar will be shown next to the content.', 'gaming-lite'),
			'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="title">',
			'after_title'   => '</h4>'

		));

		register_sidebar(array(

			'name' => esc_html__('Footer sidebar','gaming-lite'),
			'id'   => 'gaming-lite-footer-sidebar',
			'description'   => esc_html__('This sidebar will be shown next at the bottom of your content.', 'gaming-lite'),
			'before_widget' => '<div id="%1$s" class="col-lg-3 col-md-3 %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="title">',
			'after_title'   => '</h4>'

		));

	}

	add_action( 'widgets_init', 'gaming_lite_widgets_init' );

}

function gaming_lite_get_categories_select() {
	$teh_cats = get_categories();
	$results = array();
	$gaming_lite_count = count($teh_cats);
	for ($i=0; $i < $gaming_lite_count; $i++) {
	if (isset($teh_cats[$i]))
  		$results[$teh_cats[$i]->slug] = $teh_cats[$i]->name;
	else
  		$gaming_lite_count++;
	}
	return $results;
}

function gaming_lite_sanitize_select( $input, $setting ) {
	// Ensure input is a slug
	$input = sanitize_key( $input );

	// Get list of choices from the control
	// associated with the setting
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it;
	// otherwise, return the default
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Change number or products per row to 3
 */
add_filter('loop_shop_columns', 'gaming_lite_loop_columns', 999);
if (!function_exists('gaming_lite_loop_columns')) {
	function gaming_lite_loop_columns() {
		return 3; // 3 products per row
	}
}

//redirect
Function gaming_lite_notice(){
    global $pagenow;
    if ( is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] ) ) {
   		wp_safe_redirect( admin_url("themes.php?page=gaming-lite-guide-page") );
   	}
}
add_action('after_setup_theme', 'gaming_lite_notice');

?>
