<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<meta http-equiv="Content-Type" content="<?php echo esc_attr(get_bloginfo('html_type')); ?>; charset=<?php echo esc_attr(get_bloginfo('charset')); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.2, user-scalable=yes" />

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php
	if ( function_exists( 'wp_body_open' ) )
	{
		wp_body_open();
	}else{
		do_action('wp_body_open');
	}
?>

<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'gaming-lite' ); ?></a>

<div class="main-header-box">
	<div class="container">
		<div class="inner-header-box">
			<div class="top-header text-center text-md-left py-2">
				<div class="row">
					<div class="col-lg-5 col-md-4 col-sm-4 align-self-center">
						<?php if ( get_theme_mod('gaming_lite_header_announcement_text') ) : ?>
							<p class="mb-0 py-2 py-md-0"><i class="fas fa-bullhorn mr-2"></i><?php echo esc_html( get_theme_mod('gaming_lite_header_announcement_text' ) ); ?></p>
						<?php endif; ?>
					</div>
					<div class="col-lg-2 col-md-4 col-sm-4 align-self-center">
			    		<div class="logo text-center">
				    		<div class="logo-image mr-3">
				    			<?php echo esc_url( the_custom_logo() ); ?>
					    	</div>
					    	<div class="logo-content">
						    	<?php
						    		if ( get_theme_mod('gaming_lite_display_header_title', true) == true ) :
							      		echo '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name')) . '">';
							      			echo esc_attr(get_bloginfo('name'));
							      		echo '</a>';
							      	endif;

							      	if ( get_theme_mod('gaming_lite_display_header_text', false) == true ) :
						      			echo '<span>'. esc_attr(get_bloginfo('description')) . '</span>';
						      		endif;
					    		?>
							</div>
						</div>
				   	</div>
					<div class="col-lg-5 col-md-4 col-sm-4 align-self-center">
						<?php $gaming_lite_settings = get_theme_mod( 'gaming_lite_social_links_settings' ); ?>
						<div class="social-links text-center text-md-left text-lg-right py-2 py-md-0">
							<?php if ( is_array($gaming_lite_settings) || is_object($gaming_lite_settings) ){ ?>
								<span><?php esc_html_e( 'Connect with us  ','gaming-lite' ); ?></span>
						    	<?php foreach( $gaming_lite_settings as $gaming_lite_setting ) { ?>
							        <a href="<?php echo esc_url( $gaming_lite_setting['link_url'] ); ?>">
							            <i class="<?php echo esc_attr( $gaming_lite_setting['link_text'] ); ?> mr-3"></i>
							        </a>
						    	<?php } ?>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<header id="site-navigation" class="header text-center text-md-left">
				<div class="row">
					<div class="col-lg-5 col-md-8 col-sm-8 align-self-center">
						<?php if(has_nav_menu('main-menu')){ ?>
							<button class="menu-toggle my-2 py-2 px-3" aria-controls="top-menu" aria-expanded="false" type="button">
								<span aria-hidden="true"><?php esc_html_e( 'Menu', 'gaming-lite' ); ?></span>
							</button>
							<nav id="main-menu" class="close-panal">
								<?php
									wp_nav_menu( array(
										'theme_location' => 'main-menu',
										'container' => 'false'
									));
								?>
								<button class="close-menu my-2 p-2" type="button">
									<span aria-hidden="true"><i class="fa fa-times"></i></span>
								</button>
							</nav>
						<?php }?>
					</div>
					<div class="col-lg-7 col-md-4 col-sm-4 align-self-center">
						<div class="text-md-right sign-button my-3">
							<?php if ( get_theme_mod('gaming_lite_sign_up_url') || get_theme_mod('gaming_lite_sign_up_text') ) : ?>
								<a href="<?php echo esc_url( get_theme_mod('gaming_lite_sign_up_url' ) ); ?>" class="signup-box"><?php echo esc_html( get_theme_mod('gaming_lite_sign_up_text' ) ); ?></a>
							<?php endif; ?>
							<?php if ( get_theme_mod('gaming_lite_sign_in_url') || get_theme_mod('gaming_lite_sign_in_text') ) : ?>
								<a href="<?php echo esc_url( get_theme_mod('gaming_lite_sign_in_url' ) ); ?>" class="ml-md-3 signin-box"><i class="far fa-user mr-2"></i><?php echo esc_html( get_theme_mod('gaming_lite_sign_in_text' ) ); ?></a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</header>
		</div>
	</div>
</div>
