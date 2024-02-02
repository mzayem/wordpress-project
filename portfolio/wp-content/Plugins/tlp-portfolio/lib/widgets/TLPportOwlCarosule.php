<?php
/**
 * Owl Carousel Class.
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( ! class_exists( 'TLPportOwlCarosule' ) ) :
	/**
	 * Owl Carousel Class.
	 */
	class TLPportOwlCarosule extends WP_Widget {
		private $caroA = [];

		/**
		 * TLP TEAM widget setup
		 */
		public function __construct() {
			$widget_ops = [
				'classname'   => 'widget_tlp_port_owl_carousel',
				'description' => esc_html__( 'Display the portfolio as carousel.', 'tlp-portfolio' ),
			];
			parent::__construct( 'widget_tlp_port_owl_carousel', esc_html__( 'TPL Portfolio', 'tlp-portfolio' ), $widget_ops );

			add_action( 'wp_enqueue_scripts', [ $this, 'carousel_script' ] );

		}

		public function carousel_script() {
			global $TLPportfolio;

			wp_enqueue_style( 'tlpportfolio-css', $TLPportfolio->assetsUrl . 'css/tlpportfolio.css' );
		}

		/**
		 * display the widgets on the screen.
		 */
		public function widget( $args, $instance ) {
			$widget_id = isset( $args['widget_id'] ) ? sanitize_text_field( $args['widget_id'] ) : '';
			$caroID    = $widget_id . '-port-carousel';

			global $TLPportfolio;

			extract( $args );

			$total = ( isset( $instance['total'] ) ? ( $instance['total'] ? (int) $instance['total'] : 8 ) : 8 );
			$limit = ( isset( $instance['letter-limit'] ) ? (int) $instance['letter-limit'] : 0 );

			echo $before_widget;

			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', ( isset( $instance['title'] ) ? $instance['title'] : 'Portfolio' ) ) . $args['after_title'];
			}
			?>
			<div class="tlp-portfolio-widget-wrapper">
				<?php
				$args_q = [
					'post_type'      => $TLPportfolio->post_type,
					'post_status'    => 'publish',
					'posts_per_page' => $total,
					'orderby'        => 'date',
					'order'          => 'DESC',
				];

				$teamQuery = new WP_Query( $args_q );

				if ( $teamQuery->have_posts() ) {
					$settings = get_option( $TLPportfolio->options['settings'] );
					$fSize    = ! empty( $settings['feature_img_size'] ) ? $settings['feature_img_size'] : $TLPportfolio->options['tlp-portfolio-thumb'];
					?>
					<div class='rt-container-fluid tlp-portfolio'>
						<div class="rt-row ">
							<div id='<?php echo esc_attr( $caroID ); ?>' class='slider owl-carousel owl-theme'>
								<?php
								while ( $teamQuery->have_posts() ) :
									$teamQuery->the_post();
									$title    = get_the_title();
									$plink    = get_permalink();
									$sDetails = get_post_meta( get_the_ID(), 'short_description', true );

									if ( has_post_thumbnail() ) {
										$image     = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $fSize );
										$timg      = $image[0];
										$imageFull = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
										$imgFull   = $imageFull[0];
									} else {
										$timg = $TLPportfolio->assetsUrl . 'images/demo.jpg';
									}

									$grid = ( ! empty( $instance['number'] ) ? (int) $instance['number'] : 4 );
									$grid = round( 12 / $grid );
									?>
									<div class='tlp-col-sm-12 tlp-col-xs-12 tlp-equal-height'>
										<div class="tlp-portfolio-item">
											<div class="tlp-portfolio-thum tlp-item">
												<img class="img-responsive" src="<?php echo esc_url( $timg ); ?>" alt="<?php echo esc_attr( $title ); ?> "/>
												<div class="tlp-overlay">
													<p class="link-icon">
														<a class="tlp-zoom" href="<?php echo esc_url( $imgFull ); ?>"><i class="demo-icon icon-zoom-in"></i></a>
														<a target="_blank" href="<?php echo esc_url( $plink ); ?>"><i class="demo-icon icon-link-ext"></i></a>
													</p>
												</div>
											</div>
											<div class="tlp-content">
												<div class="tlp-content-holder">
													<h3><a href="<?php echo esc_url( $plink ); ?>"><?php echo esc_html( $title ); ?></a></h3>
													<?php $details = $limit > 0 ? substr( $sDetails, 0, $limit ) : html_entity_decode( $sDetails ); ?>
													<div class="tlp-portfolio-sd"><?php echo wp_kses_post( $details ); ?></div>
												</div>
											</div>

										</div>
									</div>
									<?php
								endwhile;
								wp_reset_postdata();
								?>
							</div>
						</div>
					</div>
					<?php
				} else {
					?>
					<p> <?php esc_html_e( 'No post found', 'tlp-portfolio' ); ?></p>
				<?php } ?>
			</div>

			<?php
			echo $after_widget;

			$this->caroA[] = [
				'id'  => $caroID,
				'opt' => [
					'items'        => ( isset( $instance['number'] ) ? ( $instance['number'] ? (int) $instance['number'] : 4 ) : 4 ),
					'speed'        => ( isset( $instance['speed'] ) ? ( $instance['speed'] ? (int) $instance['speed'] : 800 ) : 800 ),
					'auto_play'    => ( isset( $instance['auto_play'] ) ? true : false ),
					'pagination'   => ( isset( $instance['pagination'] ) ? true : false ),
					'navigation'   => ( isset( $instance['navigation'] ) ? true : false ),
					'stop_hover'   => ( isset( $instance['stop_hover'] ) ? true : false ),
					'responsive'   => ( isset( $instance['responsive'] ) ? true : false ),
					'tabletnumber' => ( isset( $instance['tabletnumber'] ) && ! empty( $instance['tabletnumber'] ) ? (int) $instance['tabletnumber'] : 2 ),
					'mobilenumber' => ( isset( $instance['mobilenumber'] ) && ! empty( $instance['mobilenumber'] ) ? (int) $instance['mobilenumber'] : 1 ),
					'auto_height'  => ( isset( $instance['auto_height'] ) ? true : false ),
					'lazy_load'    => ( isset( $instance['lazy_load'] ) ? true : false ),
				],
			];

			add_action( 'wp_footer', [ $this, 'register_scripts' ] );
			add_action( 'wp_footer', [ $this, 'low_footer_script' ], 100 );
		}

		public function register_scripts() {
			wp_enqueue_style( [ 'tlp-owl-carousel', 'tlp-owl-carousel-theme' ] );
			wp_enqueue_script(
				[
					'jquery',
					'tlp-magnific',
					'tlp-owl-carousel',
					'tlp-portfolio',
				]
			);
		}

		public function low_footer_script() {
			foreach ( $this->caroA as $ca ) {
				if ( isset( $ca ) && is_array( $ca ) ) {
					echo $this->croScript( $ca );
				}
			}
		}

		public function croScript( $ca ) {
			$caro  = null;
			$caro .= '<script>';
			$caro .= '(function($){
						$("#' . $ca['id'] . '").owlCarousel({
							items: ' . $ca['opt']['items'] . ',
							loop: true,
							nav: ' . $ca['opt']['navigation'] . ',
							dots: ' . $ca['opt']['pagination'] . ',
							navText: ["<i class=\'demo-icon icon-left-open\'></i>", "<i class=\'demo-icon icon-right-open\'></i>"],
							autoplay: ' . $ca['opt']['auto_play'] . ',
							autoplayHoverPause: ' . $ca['opt']['stop_hover'] . ',
							smartSpeed: ' . $ca['opt']['speed'] . ',
							lazyLoad: ' . $ca['opt']['lazy_load'] . ',
							responsiveClass: true,
							responsive: {
								0: {
									items: ' . $ca['opt']['mobilenumber'] . '
								},
								600: {
									items: ' . $ca['opt']['tabletnumber'] . '
								},
								1000: {
									items: ' . $ca['opt']['items'] . '
								}
							}
						});
					})(jQuery)';
			$caro .= '</script>';

			return $caro;
		}

		public function form( $instance ) {
			$defaults = [
				'title'        => 'Portfolio',
				'number'       => 4,
				'tabletnumber' => 2,
				'mobilenumber' => 1,
				'total'        => 8,
				'letter-limit' => 0,
				'speed'        => 800,
				'auto_play'    => 1,
			];

			global $TLPportfolio;

			foreach ( $TLPportfolio->owl_property() as $key => $item ) {
				$defaults[ $key ] = 1;
			}

			$instance = wp_parse_args( (array) $instance, $defaults );
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'tlp-portfolio' ); ?></label>
				<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>"
					style="width:100%;"/></p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of item per slide:', 'tlp-portfolio' ); ?></label>
				<input type="text" size="2" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>"
					value="<?php echo absint( $instance['number'] ); ?>"/></p>
			<p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'tabletnumber' ) ); ?>"><?php esc_html_e( 'Number of item for tablet:', 'tlp-portfolio' ); ?></label>
				<input type="text" size="2" id="<?php echo esc_attr( $this->get_field_id( 'tabletnumber' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'tabletnumber' ) ); ?>"
					value="<?php echo absint( $instance['tabletnumber'] ); ?>"/></p>
			<p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'mobilenumber' ) ); ?>"><?php esc_html_e( 'Number of item for mobile:', 'tlp-portfolio' ); ?></label>
				<input type="text" size="2" id="<?php echo esc_attr( $this->get_field_id( 'mobilenumber' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'mobilenumber' ) ); ?>"
					value="<?php echo absint( $instance['mobilenumber'] ); ?>"/></p>
			<p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'letter-limit' ) ); ?>"><?php esc_html_e( 'Letter limit for short description:', 'tlp-portfolio' ); ?></label>
				<input type="text" size="2" id="<?php echo esc_attr( $this->get_field_id( 'letter-limit' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'letter-limit' ) ); ?>"
					value="<?php echo absint( $instance['letter-limit'] ); ?>"/></p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'total' ) ); ?>"><?php esc_html_e( 'Total Number of item:', 'tlp-portfolio' ); ?></label>
				<input type="text" size="2" id="<?php echo esc_attr( $this->get_field_id( 'total' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'total' ) ); ?>"
					value="<?php echo absint( $instance['total'] ); ?>"/>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'speed' ) ); ?>"><?php esc_html_e( 'Slide Speed:', 'tlp-portfolio' ); ?></label>
				<input type="text" size="4" id="<?php echo esc_attr( $this->get_field_id( 'speed' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'speed' ) ); ?>"
					value="<?php echo absint( $instance['speed'] ); ?>"/>
			</p>
			<?php
			echo '<p>';
			foreach ( $TLPportfolio->owl_property() as $key => $value ) {
				$checked = ( $instance[ $key ] ? 'checked' : null );
				// $html    = null;
				?>
					<input type="checkbox" <?php echo esc_attr( $checked ); ?> value="1" class="checkbox"
					id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>"><label for="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"> <?php echo esc_html( $value ); ?></label><br>
				<?php
			}
			echo '</p>';
		}

		public function update( $new_instance, $old_instance ) {
			$instance                 = [];
			$instance['title']        = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
			$instance['number']       = ( ! empty( $new_instance['number'] ) ) ? (int) ( $new_instance['number'] ) : '';
			$instance['tabletnumber'] = ( ! empty( $new_instance['tabletnumber'] ) ) ? (int) ( $new_instance['tabletnumber'] ) : '';
			$instance['mobilenumber'] = ( ! empty( $new_instance['mobilenumber'] ) ) ? (int) ( $new_instance['mobilenumber'] ) : '';

			$instance['letter-limit'] = ( ! empty( $new_instance['letter-limit'] ) ) ? (int) ( $new_instance['letter-limit'] ) : '';
			$instance['total']        = ( ! empty( $new_instance['total'] ) ) ? (int) ( $new_instance['total'] ) : '';
			$instance['speed']        = ( ! empty( $new_instance['speed'] ) ) ? (int) ( $new_instance['speed'] ) : '';

			global $TLPportfolio;

			$options = $TLPportfolio->owl_property();

			if ( ! empty( $options ) ) {
				foreach ( $options as $key => $value ) {
					$instance[ $key ] = ( ! empty( $new_instance[ $key ] ) ) ? (int) ( $new_instance[ $key ] ) : '';
				}
			}

			return $instance;
		}
	}
endif;
