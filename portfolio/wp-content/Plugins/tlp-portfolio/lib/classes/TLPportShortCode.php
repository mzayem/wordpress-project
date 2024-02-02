<?php
/**
 * Shortcode class.
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( ! class_exists( 'TLPportShortCode' ) ) :
	/**
	 * Shortcode class.
	 */
	class TLPportShortCode {
		public function __construct() {
			add_shortcode( 'tlpportfolio', [ $this, 'portfolio_shortcode' ] );
			add_action( 'wp_ajax_tlp_portfolio_preview_ajax_call', [ $this, 'portfolio_shortcode' ] );
		}

		public function load_scripts() {
			wp_enqueue_style(
				[
					'tlp-owl-carousel',
					'tlp-owl-carousel-theme',
				]
			);

			wp_enqueue_script(
				[
					'tlp-magnific',
					'tlp-isotope',
					'tlp-owl-carousel',
					'tlp-portfolio',
				]
			);
		}

		public function portfolio_shortcode( $atts, $content = '' ) {
			global $TLPportfolio;

			$error   = true;
			$html    = $msg = null;
			$preview = isset( $_REQUEST['sc_id'] ) ? absint( $_REQUEST['sc_id'] ) : 0;
			$scID    = isset( $atts['id'] ) ? absint( $atts['id'] ) : 0;

			if ( $scID || $preview ) {
				$post = get_post( $scID );

				if ( ( ! $preview && ! is_null( $post ) && $post->post_type === TLPPortfolio()->getScPostType() ) || ( $preview && TLPPortfolio()->verifyNonce() ) ) {
					$rand         = wp_rand();
					$container_id = $scID ? $scID : $preview;
					$layoutID     = 'tlp-portfolio-container-' . $container_id;
					$arg          = [];
					$query_args   = [
						'post_type'   => TLPPortfolio()->post_type,
						'post_status' => 'publish',
					];

					if ( $preview ) {
						$error         = false;
						$scMeta        = $_REQUEST;
						$layout        = isset( $scMeta['pfp_layout'] ) && ! empty( $scMeta['pfp_layout'] ) ? sanitize_text_field( wp_unslash( $scMeta['pfp_layout'] ) ) : 'layout1';
						$dCol          = isset( $scMeta['pfp_desktop_column'] ) && ! empty( $scMeta['pfp_desktop_column'] ) ? absint( $scMeta['pfp_desktop_column'] ) : 3;
						$tCol          = isset( $scMeta['pfp_tab_column'] ) && ! empty( $scMeta['pfp_tab_column'] ) ? absint( $scMeta['pfp_tab_column'] ) : 2;
						$mCol          = isset( $scMeta['pfp_mobile_column'] ) && ! empty( $scMeta['pfp_mobile_column'] ) ? absint( $scMeta['pfp_mobile_column'] ) : 1;
						$imgSize       = isset( $scMeta['pfp_image_size'] ) && ! empty( $scMeta['pfp_image_size'] ) ? sanitize_text_field( wp_unslash( $scMeta['pfp_image_size'] ) ) : 'medium';
						$customImgSize = isset( $scMeta['pfp_custom_image_size'] ) ? TLPPortfolio()->array_text_sanitization( $scMeta['pfp_custom_image_size'] ) : [];

						$excerpt_limit = isset( $scMeta['pfp_excerpt_limit'] ) && ! empty( $scMeta['pfp_excerpt_limit'] ) ? absint( $scMeta['pfp_excerpt_limit'] ) : 0;
						$disable_image = isset( $scMeta['pfp_disable_image'] ) && ! empty( $scMeta['pfp_disable_image'] ) ? true : false;
						$post__in      = isset( $scMeta['pfp_post__in'] ) && ! empty( $scMeta['pfp_post__in'] ) ? sanitize_text_field( wp_unslash( $scMeta['pfp_post__in'] ) ) : null;
						$post__not_in  = isset( $scMeta['pfp_post__not_in'] ) && ! empty( $scMeta['pfp_post__not_in'] ) ? sanitize_text_field( wp_unslash( $scMeta['pfp_post__not_in'] ) ) : null;

						$limit = $query_args['posts_per_page'] = ! isset( $scMeta['pfp_limit'] ) || ( isset( $scMeta['pfp_limit'] ) && ( empty( $scMeta['pfp_limit'] ) || $scMeta['pfp_limit'] === '-1' ) ) ? 10000000 : absint( $scMeta['pfp_limit'] );

						$pagination = isset( $scMeta['pfp_pagination'] ) && ! empty( $scMeta['pfp_pagination'] ) ? true : false;

						$cats = isset( $scMeta['pfp_categories'] ) ? TLPPortfolio()->array_int_sanitization( $scMeta['pfp_categories'] ) : [];
						$tags = isset( $scMeta['pfp_tags'] ) ? TLPPortfolio()->array_int_sanitization( $scMeta['pfp_tags'] ) : [];

						$relation = isset( $scMeta['pfp_taxonomy_relation'] ) && ! empty( $scMeta['pfp_taxonomy_relation'] ) ? sanitize_text_field( wp_unslash( $scMeta['pfp_taxonomy_relation'] ) ) : 'AND';

						$order_by = isset( $scMeta['pfp_order_by'] ) && ! empty( $scMeta['pfp_order_by'] ) ? sanitize_text_field( wp_unslash( $scMeta['pfp_order_by'] ) ) : null;

						$order       = isset( $scMeta['pfp_order'] ) && ! empty( $scMeta['pfp_order'] ) ? sanitize_text_field( wp_unslash( $scMeta['pfp_order'] ) ) : null;
						$parentClass = isset( $scMeta['pfp_parent_class'] ) && ! empty( $scMeta['pfp_parent_class'] ) ? sanitize_text_field( wp_unslash( $scMeta['pfp_parent_class'] ) ) : null;

						$arg['link'] = isset( $scMeta['pfp_detail_page_link'] ) && ! empty( $scMeta['pfp_detail_page_link'] );

						$arg['link_type'] = isset( $scMeta['pfp_detail_page_link_type'] ) && ! empty( $scMeta['pfp_detail_page_link_type'] ) ? sanitize_text_field( wp_unslash( $scMeta['pfp_detail_page_link_type'] ) ) : 'inner_link';

						$arg['link_target'] = $arg['link_type'] == 'external_link' && isset( $scMeta['pfp_link_target'] ) && $scMeta['pfp_link_target'] == '_blank' ? '_blank' : null;

						$disable_equal_height = isset( $scMeta['pfp_disable_equal_height'] ) && ! empty( $scMeta['pfp_disable_equal_height'] );

					} else {
						$scMeta = get_post_meta( $scID );
						$layout = isset( $scMeta['pfp_layout'][0] ) && ! empty( $scMeta['pfp_layout'][0] ) ? sanitize_text_field( $scMeta['pfp_layout'][0] ) : 'layout1';
						$dCol   = isset( $scMeta['pfp_desktop_column'][0] ) && ! empty( $scMeta['pfp_desktop_column'][0] ) ? absint( $scMeta['pfp_desktop_column'][0] ) : 3;

						$tCol    = isset( $scMeta['pfp_tab_column'][0] ) && ! empty( $scMeta['pfp_tab_column'][0] ) ? absint( $scMeta['pfp_tab_column'][0] ) : 2;
						$mCol    = isset( $scMeta['pfp_mobile_column'][0] ) && ! empty( $scMeta['pfp_mobile_column'][0] ) ? absint( $scMeta['pfp_mobile_column'][0] ) : 1;
						$imgSize = isset( $scMeta['pfp_image_size'][0] ) && ! empty( $scMeta['pfp_image_size'][0] ) ? sanitize_text_field( $scMeta['pfp_image_size'][0] ) : 'medium';

						$customImgSize = isset( $scMeta['pfp_custom_image_size'][0] ) && ! empty( $scMeta['pfp_custom_image_size'][0] ) ? TLPPortfolio()->array_text_sanitization( $scMeta['pfp_custom_image_size'][0] ) : [];

						$excerpt_limit = isset( $scMeta['pfp_excerpt_limit'][0] ) && ! empty( $scMeta['pfp_excerpt_limit'][0] ) ? absint( $scMeta['pfp_excerpt_limit'][0] ) : 0;
						$disable_image = isset( $scMeta['pfp_disable_image'][0] ) && ! empty( $scMeta['pfp_disable_image'][0] ) ? true : false;

						$post__in     = isset( $scMeta['pfp_post__in'][0] ) && ! empty( $scMeta['pfp_post__in'][0] ) ? sanitize_text_field( trim( $scMeta['pfp_post__in'][0] ) ) : null;
						$post__not_in = isset( $scMeta['pfp_post__not_in'][0] ) && ! empty( $scMeta['pfp_post__not_in'][0] ) ? sanitize_text_field( trim( $scMeta['pfp_post__not_in'][0] ) ) : null;

						$limit      = $query_args['posts_per_page'] = ! isset( $scMeta['pfp_limit'][0] ) || ( isset( $scMeta['pfp_limit'][0] ) && ( empty( $scMeta['pfp_limit'][0] ) || $scMeta['pfp_limit'][0] === '-1' ) ) ? 10000000 : absint( $scMeta['pfp_limit'][0] );
						$pagination = isset( $scMeta['pfp_pagination'][0] ) && ! empty( $scMeta['pfp_pagination'][0] ) ? true : false;

						$cats = isset( $scMeta['pfp_categories'] ) && ! empty( $scMeta['pfp_categories'] ) ? TLPPortfolio()->array_int_sanitization( $scMeta['pfp_categories'] ) : [];

						$tags = isset( $scMeta['pfp_tags'] ) && ! empty( $scMeta['pfp_tags'] ) ? TLPPortfolio()->array_int_sanitization( $scMeta['pfp_tags'] ) : [];

						$relation = isset( $scMeta['pfp_taxonomy_relation'][0] ) && ! empty( $scMeta['pfp_taxonomy_relation'][0] ) ? sanitize_text_field( $scMeta['pfp_taxonomy_relation'][0] ) : 'AND';

						$order_by    = isset( $scMeta['pfp_order_by'][0] ) && ! empty( $scMeta['pfp_order_by'][0] ) ? sanitize_text_field( $scMeta['pfp_order_by'][0] ) : null;
						$order       = isset( $scMeta['pfp_order'][0] ) && ! empty( $scMeta['pfp_order'][0] ) ? sanitize_text_field( $scMeta['pfp_order'][0] ) : null;
						$parentClass = isset( $scMeta['pfp_parent_class'][0] ) && ! empty( $scMeta['pfp_parent_class'][0] ) ? sanitize_text_field( $scMeta['pfp_parent_class'][0] ) : null;

						$arg['link']          = isset( $scMeta['pfp_detail_page_link'][0] ) && ! empty( $scMeta['pfp_detail_page_link'][0] );
						$arg['link_type']     = isset( $scMeta['pfp_detail_page_link_type'][0] ) && ! empty( $scMeta['pfp_detail_page_link_type'][0] ) ? sanitize_text_field( $scMeta['pfp_detail_page_link_type'][0] ) : 'inner_link';
						$arg['link_target']   = $arg['link_type'] == 'external_link' && isset( $scMeta['pfp_link_target'][0] ) && $scMeta['pfp_link_target'][0] == '_blank' ? '_blank' : null;
						$disable_equal_height = isset( $scMeta['pfp_disable_equal_height'][0] ) && ! empty( $scMeta['pfp_disable_equal_height'][0] );
					}

					$cat_ids = $cats;

					if ( isset( $scMeta['pfp_item_fields'] ) ) {
						$arg['items'] = ! empty( $scMeta['pfp_item_fields'] ) ? TLPPortfolio()->array_text_sanitization( $scMeta['pfp_item_fields'] ) : [];
					} else {
						$arg['items'] = [
							'name',
							'short_description',
							'zoom_image',
						];
					}

					$dColItems = $dCol;
					$tColItems = $tCol;
					$mColItems = $mCol;

					if ( ! in_array( $layout, array_keys( TLPPortfolio()->scLayouts() ) ) ) {
						$layout = 'layout1';
					}

					if ( ! in_array( $dCol, array_keys( TLPPortfolio()->scColumns() ) ) ) {
						$dCol = 3;
					}
					if ( ! in_array( $tCol, array_keys( TLPPortfolio()->scColumns() ) ) ) {
						$tCol = 2;
					}
					if ( ! in_array( $mCol, array_keys( TLPPortfolio()->scColumns() ) ) ) {
						$mCol = 1;
					}

					$isIsotope  = preg_match( '/isotope/', $layout );
					$isCarousel = preg_match( '/carousel/', $layout );
					$isLayout   = preg_match( '/layout/', $layout );

					/* post__in */
					if ( $post__in ) {
						$query_args['post__in'] = explode( ',', $post__in );
					}
					/* post__not_in */
					if ( $post__not_in ) {
						$query_args['post__not_in'] = explode( ',', $post__not_in );
					}

					/* LIMIT */
					if ( $pagination && ! ( $isCarousel || $isIsotope ) ) {
						$posts_per_page = ( isset( $scMeta['pfp_posts_per_page'][0] ) ? absint( $scMeta['pfp_posts_per_page'][0] ) : $limit );

						// $limit.
						if ( $posts_per_page > $limit ) {
							$posts_per_page = $limit;
						}

						// Set 'posts_per_page' parameter.
						$query_args['posts_per_page']      = $posts_per_page;
						$query_args['posts_per_page_meta'] = $posts_per_page;

						if ( is_front_page() ) {
							$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
						} else {
							$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
						}

						$offset              = $posts_per_page * ( (int) $paged - 1 );
						$query_args['paged'] = $paged;

						// Update posts_per_page.
						$remaining_post = $limit - $offset;

						if ( 0 < $remaining_post ) {
							if ( intval( $query_args['posts_per_page'] ) > $remaining_post ) {
								$query_args['posts_per_page'] = $remaining_post;
								$query_args['offset']         = $offset;
							}
						} else {
							$query_args['posts_per_page'] = 0;
						}
					}

					if ( $isCarousel || $isIsotope ) {
						$query_args['posts_per_page'] = $limit;
					}

					$taxQ = [];

					if ( is_array( $cats ) && ! empty( $cats ) ) {
						$taxQ[] = [
							'taxonomy' => TLPPortfolio()->taxonomies['category'],
							'field'    => 'term_id',
							'terms'    => $cats,
						];
					}

					if ( is_array( $tags ) && ! empty( $tags ) ) {
						$taxQ[] = [
							'taxonomy' => TLPPortfolio()->taxonomies['tag'],
							'field'    => 'term_id',
							'terms'    => $tags,
						];
					}

					if ( ! empty( $taxQ ) ) {
						if ( count( $taxQ ) > 1 ) {
							$taxQ['relation'] = $relation;
						}
						$query_args['tax_query'] = $taxQ;
					}

					if ( $order ) {
						$query_args['order'] = $order;
					}

					if ( $order_by ) {
						$query_args['orderby'] = $order_by;
					}

					// Validation.
					$containerDataAttr = " data-layout='{$layout}' data-desktop-col='{$dCol}'  data-tab-col='{$tCol}'  data-mobile-col='{$mCol}'";
					$old_dCol          = $dCol;
					$dCol              = round( 12 / $dCol );
					$tCol              = round( 12 / $tCol );
					$mCol              = round( 12 / $mCol );

					if ( $isCarousel ) {
						$dCol = $tCol = $mCol = 12;
					}

					$arg['grid'] = sprintf(
						'tlp-col-md-%d tlp-col-sm-%d tlp-col-xs-%d tlp-single-item%s%s%s%s',
						$dCol,
						$tCol,
						$mCol,
						$isIsotope ? ' tlp-isotope-item' : null,
						$isCarousel ? ' tlp-carousel-item' : null,
						$isLayout ? ' tlp-grid-item' : null,
						! $isIsotope && ! $disable_equal_height ? ' tlp-equal-height' : null
					);

					if ( $old_dCol == 2 ) {
						$arg['image_area']   = 'tlp-col-lg-5 tlp-col-md-5 tlp-col-sm-6 tlp-col-xs-12 ';
						$arg['content_area'] = 'tlp-col-lg-7 tlp-col-md-7 tlp-col-sm-6 tlp-col-xs-12 ';
					} else {
						$arg['image_area']   = 'tlp-col-lg-3 tlp-col-md-3 tlp-col-sm-6 tlp-col-xs-12 ';
						$arg['content_area'] = 'tlp-col-lg-9 tlp-col-md-9 tlp-col-sm-6 tlp-col-xs-12 ';
					}

					$portfolioQuery = new WP_Query( apply_filters( 'tlp_portfolio_sc_query_args', $query_args ) );
					$class          = [
						'rt-container-fluid',
						'tlp-portfolio',
						'tlp-portfolio-container',
					];

					if ( $parentClass ) {
						$class[] = $parentClass;
					}

					$preLoader = null;

					if ( $isIsotope ) {
						$class[] = 'is-isotope';
					}

					if ( $isCarousel ) {
						$class[]   = 'is-carousel';
						$preLoader = 'pfp-pre-loader';
					}

					/**
					 *
					 */
					if ( $preview ) {
						$html .= $this->customStyle( $layoutID, $scMeta, true, $preview );
					}

					if ( $portfolioQuery->have_posts() ) {
						$dataAttr = "data-title='" . esc_html__( 'Loading ...', 'tlp-portfolio' ) . "'";
						$html    .= sprintf( '<div class="%s" id="%s" data-layout="%s"><div class="rt-row %s %s" %s>', implode( ' ', $class ), $layoutID, $layout, $layout, $preLoader, $dataAttr );

						if ( $isCarousel ) {
							$smartSpeed      = ! empty( $scMeta['pfp_carousel_speed'][0] ) ? absint( $scMeta['pfp_carousel_speed'][0] ) : 250;
							$autoplayTimeout = ! empty( $scMeta['pfp_carousel_autoplay_timeout'][0] ) ? absint( $scMeta['pfp_carousel_autoplay_timeout'][0] ) : 5000;
							$cOpt            = ! empty( $scMeta['pfp_carousel_options'] ) ? TLPPortfolio()->array_text_sanitization( $scMeta['pfp_carousel_options'] ) : [];

							$autoPlay           = ( in_array( 'autoplay', $cOpt ) ? 'true' : 'false' );
							$autoPlayHoverPause = ( in_array( 'autoplayHoverPause', $cOpt ) ? 'true' : 'false' );

							$nav        = ( in_array( 'nav', $cOpt ) ? 'true' : 'false' );
							$dots       = ( in_array( 'dots', $cOpt ) ? 'true' : 'false' );
							$loop       = ( in_array( 'loop', $cOpt ) ? 'true' : 'false' );
							$lazyLoad   = ( in_array( 'lazy_load', $cOpt ) ? 'true' : 'false' );
							$autoHeight = ( in_array( 'auto_height', $cOpt ) ? 'true' : 'false' );
							$rtl        = ( in_array( 'rtl', $cOpt ) ? 'true' : 'false' );
							$html      .= "<div class='pfp-carousel owl-carousel owl-theme '
												data-loop='{$loop}'
												data-items='{$dColItems}'
												data-autoplay='{$autoPlay}'
												data-autoplay-timeout='{$autoplayTimeout}'
												data-autoplay-hover-pause='{$autoPlayHoverPause}'
												data-dots='{$dots}'
												data-nav='{$nav}'
												data-lazyload='{$lazyLoad}'
												data-autoheight='{$autoHeight}'
												data-rtl='{$rtl}'
												data-smart-speed='{$smartSpeed}'
												data-tabcolumn='{$tColItems}'
												data-mobilecolumn='{$mColItems}'
											>";
						}

						$current_page_term = [];
						$loops_content     = '';

						while ( $portfolioQuery->have_posts() ) :
							$portfolioQuery->the_post();
							$iID                   = get_the_ID();
							$arg['categories']     = wp_strip_all_tags( get_the_term_list( $iID, $TLPportfolio->taxonomies['category'], '', ', ' ) );
							$arg['title']          = get_the_title();
							$arg['iID']            = $iID;
							$arg['item_link']      = get_permalink();
							$arg['project_url']    = get_post_meta( $iID, 'project_url', true );
							$arg['client_name']    = get_post_meta( $iID, 'client_name', true );
							$arg['completed_date'] = get_post_meta( $iID, 'completed_date', true );
							$arg['tools']          = get_post_meta( $iID, 'tools', true );
							$arg['pLink']          = get_permalink();

							if ( $arg['link_type'] == 'external_link' && $arg['project_url'] ) {
								$arg['item_link'] = $arg['project_url'];
							}

							$short_d        = get_post_meta( $iID, 'short_description', true );
							$arg['short_d'] = TLPPortfolio()->get_short_description( $short_d, $excerpt_limit );

							if ( $isIsotope ) {
								$termAs    = wp_get_post_terms( $iID, TLPPortfolio()->taxonomies['category'], [ 'fields' => 'all' ] );
								$isoFilter = null;

								if ( ! empty( $termAs ) ) {
									foreach ( $termAs as $term ) {
										$isoFilter          .= ' ' . 'iso_' . $term->term_id;
										$isoFilter          .= ' ' . $term->slug;
										$current_page_term[] = $term->term_id;
									}
								}

								$arg['isoFilter'] = $isoFilter;
							}

							if ( $disable_image ) {
								$arg['content_area'] = 'tlp-col-md-12';
								$arg['imgFull']      = $arg['img'] = null;
							} else {
								if ( has_post_thumbnail() ) {
									$arg['img']     = TLPPortfolio()->getFeatureImageSrc( $iID, $imgSize, $customImgSize );
									$imageFull      = wp_get_attachment_image_src( get_post_thumbnail_id( $iID ), 'full' );
									$arg['imgFull'] = isset( $imageFull[0] ) ? $imageFull[0] : '';
								} else {
									$arg['img'] = $arg['imgFull'] = null;
								}
								$arg['imgFull'] = ! $arg['imgFull'] && $arg['img'] ? $arg['img'] : $arg['imgFull'];
							}

							$loops_content .= TLPPortfolio()->render( 'layouts/' . $layout, $arg, true );
						endwhile;

						$filter_button = '';

						if ( $isIsotope ) {
							$terms = get_terms(
								apply_filters(
									'tlp_portfolio_sc_isotope_button_args',
									[
										'taxonomy'   => TLPPortfolio()->taxonomies['category'],
										'orderby'    => 'name',
										'order'      => 'ASC',
										'hide_empty' => false,
									]
								)
							);

							if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
								$filter_button .= sprintf( '<div class="tlp-portfolio-isotope-button button-group filter-button-group option-set"><button data-filter="*" class="selected">%s</button>', __( 'Show all', 'tlp-portfolio' ) );

								foreach ( $terms as $term ) {
									if ( ! empty( $cat_ids ) ) {
										if ( in_array( $term->term_id, $cat_ids ) && in_array( $term->term_id, $current_page_term ) ) {
											$filter_button .= "<button data-filter='.$term->slug'>" . $term->name . '</button>';
										}
									} else {
										if ( in_array( $term->term_id, $current_page_term ) ) {
											$filter_button .= "<button data-filter='.$term->slug'>" . $term->name . '</button>';
										}
									}
								}

								$filter_button .= '</div>';
							}

							$filter_button .= '<div class="tlp-portfolio-isotope">';
						}

						$html .= $filter_button . $loops_content;

						if ( $isIsotope || $isCarousel ) {
							$html .= ' </div>'; // end tlp-team-isotope // end carosel.
						}

						$html .= '</div>'; // end row.

						if ( $pagination && ! ( $isCarousel || $isIsotope ) ) {
							$html .= TLPPortfolio()->pagination( $portfolioQuery, $query_args, $scMeta );
						}

						$html .= '</div>'; // end container.

						add_action( 'wp_footer', [ $this, 'load_scripts' ] );
						wp_reset_postdata();

					} else {
						$html .= sprintf( '<p>%s</p>', esc_html__( 'No portfolio found', 'tlp-portfolio' ) );
					}
				} else {
					if ( $preview ) {
						$msg = esc_html__( 'Session Error !!', 'tlp-portfolio' );
					} else {
						$html .= '<p>' . esc_html__( 'No shortCode found', 'tlp-portfolio' ) . '</p>';
					}
				}
				if ( $preview ) {
					wp_send_json(
						[
							'error' => $error,
							'msg'   => $msg,
							'data'  => $html,
						]
					);
				} else {
					return $html;
				}
			} else {
				return $this->get_team_old_layout( $atts );
			}
		}

		public function templateOne( $itemArg ) {
			return TLPPortfolio()->render( 'elementor/layout1', $itemArg, true );
		}

		public function templateTwo( $itemArg ) {
			return TLPPortfolio()->render( 'elementor/layout2', $itemArg, true );
		}

		public function templateThree( $itemArg ) {
			return TLPPortfolio()->render( 'elementor/layout3', $itemArg, true );
		}

		public function layoutIsotope1( $itemArg ) {
			return TLPPortfolio()->render( 'elementor/isotope1', $itemArg, true );
		}

		public function layoutIsotope2( $itemArg ) {
			return TLPPortfolio()->render( 'elementor/isotope2', $itemArg, true );
		}

		public function layoutIsotope3( $itemArg ) {
			return TLPPortfolio()->render( 'elementor/isotope3', $itemArg, true );
		}

		public function carousel3( $itemArg ) {
			return TLPPortfolio()->render( 'elementor/carousel3', $itemArg, true );
		}

		public function carousel2( $itemArg ) {
			return TLPPortfolio()->render( 'elementor/carousel2', $itemArg, true );
		}

		public function carousel1( $itemArg ) {
			return TLPPortfolio()->render( 'elementor/carousel1', $itemArg, true );
		}

		private function customStyle( $layoutID, $scMeta, $new_layout = false, $preview = false ) {
			$style = null;

			if ( $new_layout ) {
				$primaryColor        = isset( $scMeta['pfp_primary_color'] ) && ! empty( $scMeta['pfp_primary_color'] ) ? $scMeta['pfp_primary_color'] : null;
				$overlayColor        = isset( $scMeta['pfp_overlay_color'] ) && ! empty( $scMeta['pfp_overlay_color'] ) ? $scMeta['pfp_overlay_color'] : null;
				$buttonBgColor       = isset( $scMeta['pfp_button_bg_color'] ) && ! empty( $scMeta['pfp_button_bg_color'] ) ? $scMeta['pfp_button_bg_color'] : null;
				$buttonTxtColor      = isset( $scMeta['pfp_button_text_color'] ) && ! empty( $scMeta['pfp_button_text_color'] ) ? $scMeta['pfp_button_text_color'] : null;
				$buttonHoverBgColor  = isset( $scMeta['pfp_button_hover_bg_color'] ) && ! empty( $scMeta['pfp_button_hover_bg_color'] ) ? $scMeta['pfp_button_hover_bg_color'] : null;
				$buttonActiveBgColor = isset( $scMeta['pfp_button_active_bg_color'] ) && ! empty( $scMeta['pfp_button_active_bg_color'] ) ? $scMeta['pfp_button_active_bg_color'] : null;
				$name                = isset( $scMeta['pfp_name_style'] ) && ! empty( $scMeta['pfp_name_style'] ) ? $scMeta['pfp_name_style'] : [];
				$name_hover          = isset( $scMeta['pfp_name_hover_style'] ) && ! empty( $scMeta['pfp_name_hover_style'] ) ? $scMeta['pfp_name_hover_style'] : [];

				$short_desc = isset( $scMeta['pfp_short_description_style'] ) && ! empty( $scMeta['pfp_short_description_style'] ) ? $scMeta['pfp_short_description_style'] : [];
				$gutter     = isset( $scMeta['pfp_gutter'] ) && ! empty( $scMeta['pfp_gutter'] ) ? absint( $scMeta['pfp_gutter'] ) : null;
				$iconStyle  = isset( $scMeta['pfp_icon_style'] ) && ! empty( $scMeta['pfp_icon_style'] ) ? $scMeta['pfp_icon_style'] : [];

				$meta_style = ( isset( $scMeta['pfp_meta_style'] ) ? TLPPortfolio()->array_text_sanitization( $scMeta['pfp_meta_style'] ) : [] );

				if ( $primaryColor ) {
					$style .= "#{$layoutID} .tlp-pagination ul.page-numbers li .page-numbers {";
					$style .= 'background:' . $primaryColor . ';';
					$style .= '}';

					$style .= "#{$layoutID} .isotope2 .tlp-portfolio-item .tlp-overlay .tlp-title,#{$layoutID} .carousel2 .tlp-portfolio-item .tlp-overlay .tlp-title,";
					$style .= "#{$layoutID} .tlp-portfolio-item .tlp-content{";
					$style .= 'background:' . $primaryColor . ';';
					$style .= '}';
					$style .= "#{$layoutID} .tlp-portfolio-item .tlp-content .tlp-content-holder{padding:15px}";
					$style .= "#{$layoutID} .owl-theme .owl-nav [class*=owl-]{background:{$primaryColor}}";
					$style .= "#{$layoutID} .owl-theme .owl-dots .owl-dot.active span, #{$layoutID}  .owl-theme .owl-dots .owl-dot:hover span{background:{$primaryColor}}";
				}
				if ( $overlayColor ) {
					$style .= "#{$layoutID} .tlp-overlay {";
					$style .= 'background:' . $overlayColor . ';';
					$style .= '}';
				}

				/* Button background color */
				if ( $buttonBgColor ) {

					$style .= "#{$layoutID} .tlp-portfolio-isotope-button button,
								#{$layoutID} .owl-theme .owl-nav [class*=owl-],
								#{$layoutID} .owl-theme .owl-dots .owl-dot span,
								#{$layoutID} .tlp-pagination li span,
								#{$layoutID} .tlp-pagination li a {";
					$style .= "background: {$buttonBgColor};";
					$style .= ( $buttonTxtColor ? "color: {$buttonTxtColor}" : null );
					$style .= '}';
				}

				/* Button hover background color */
				if ( $buttonHoverBgColor ) {
					$style .= "#{$layoutID} .tlp-portfolio-isotope-button button:hover,
								#{$layoutID} .owl-theme .owl-nav [class*=owl-]:hover,
								#{$layoutID} .tlp-pagination li span:hover,
								#{$layoutID} .tlp-pagination li a:hover {";
					$style .= "background: {$buttonHoverBgColor};";
					$style .= '}';
				}

				/* Button Active background color */
				if ( $buttonActiveBgColor ) {
					$style .= "#{$layoutID} .tlp-portfolio-isotope-button button.selected,
								#{$layoutID} .owl-theme .owl-dots .owl-dot.active span,
								#{$layoutID} .tlp-pagination li.active span {";
					$style .= "background: {$buttonActiveBgColor};";
					$style .= '}';
				}

				/* gutter */
				if ( $gutter ) {
					$style .= "#{$layoutID} [class*='tlp-col-'] {";
					$style .= "padding-left : {$gutter}px;";
					$style .= "padding-right : {$gutter}px;";
					$style .= "margin-top : {$gutter}px;";
					$style .= "margin-bottom : {$gutter}px;";
					$style .= '}';
					$style .= "#{$layoutID} .rt-row{";
					$style .= "margin-left : -{$gutter}px;";
					$style .= "margin-right : -{$gutter}px;";
					$style .= '}';
				}

				// Social icon color.
				if ( ! empty( $iconStyle ) && is_array( $iconStyle ) ) {
					$iconStyleComoncss  = ! empty( $iconStyle['color'] ) ? 'color:' . $iconStyle['color'] . ';' : null;
					$iconStyleComoncss .= ! empty( $iconStyle['size'] ) ? 'font-size:' . $iconStyle['size'] . 'px;' : null;
					$iconStyleComoncss .= ! empty( $iconStyle['align'] ) ? 'text-align:' . $iconStyle['align'] . ';' : null;
					$iconStyleComoncss .= ! empty( $iconStyle['weight'] ) ? 'font-weight:' . $iconStyle['weight'] . ';' : null;
					$style             .= "#{$layoutID} .tlp-portfolio-item ul li i{";
					$style             .= $iconStyleComoncss;
					$style             .= '}';
					$style             .= "#{$layoutID} .tlp-portfolio-item .tlp-overlay .link-icon a, #{$layoutID} .tlp-portfolio-item .link-icon a {";
					$style             .= 'border: 1px solid  ' . $iconStyle['color'] . ';';
					$style             .= $iconStyleComoncss;
					$style             .= '}';
				}

				// Name.
				if ( is_array( $name ) && ! empty( $name ) ) {
					$style .= "#{$layoutID} .tlp-portfolio-item h3 a, #{$layoutID} .tlp-portfolio-item h3 {";
					$style .= isset( $name['color'] ) && ! empty( $name['color'] ) ? 'color:' . $name['color'] . ';' : null;
					$style .= isset( $name['align'] ) && ! empty( $name['align'] ) ? 'text-align:' . $name['align'] . ' !important;' : null;
					$style .= isset( $name['weight'] ) && ! empty( $name['weight'] ) ? 'font-weight:' . $name['weight'] . ';' : null;
					$style .= isset( $name['size'] ) && ! empty( $name['size'] ) ? 'font-size:' . $name['size'] . 'px;' : null;
					$style .= '}';
				}

				// Name Hover.
				if ( is_array( $name_hover ) && ! empty( $name_hover ) ) {
					$style .= "#{$layoutID} .tlp-portfolio-item h3 a:hover, #{$layoutID} .tlp-portfolio-item h3:not(.color-white):hover {";
					$style .= isset( $name_hover['color'] ) && ! empty( $name_hover['color'] ) ? 'color:' . $name_hover['color'] . ';' : null;
					$style .= isset( $name_hover['align'] ) && ! empty( $name_hover['align'] ) ? 'text-align:' . $name_hover['align'] . ' !important;' : null;
					$style .= isset( $name_hover['weight'] ) && ! empty( $name_hover['weight'] ) ? 'font-weight:' . $name_hover['weight'] . ';' : null;
					$style .= isset( $name_hover['size'] ) && ! empty( $name_hover['size'] ) ? 'font-size:' . $name_hover['size'] . 'px;' : null;
					$style .= '}';
				}

				// Short Description.
				if ( is_array( $short_desc ) && ! empty( $short_desc ) ) {
					$style .= "#{$layoutID} .tlp-portfolio-item .tlp-portfolio-sd {";
					$style .= isset( $name['color'] ) && ! empty( $short_desc['color'] ) ? 'color:' . $short_desc['color'] . ';' : null;
					$style .= isset( $name['size'] ) && ! empty( $short_desc['size'] ) ? 'font-size:' . $short_desc['size'] . 'px;' : null;
					$style .= isset( $name['weight'] ) && ! empty( $short_desc['weight'] ) ? 'font-weight:' . $short_desc['weight'] . ';' : null;
					$style .= isset( $name['align'] ) && ! empty( $short_desc['align'] ) ? 'text-align:' . $short_desc['align'] . ';' : null;
					$style .= '}';
				}

				if ( is_array( $meta_style ) && ! empty( $meta_style ) ) {
					$metaStyleComoncss  = isset( $meta_style['color'] ) && ! empty( $meta_style['color'] ) ? 'color:' . $meta_style['color'] . ';' : null;
					$metaStyleComoncss .= isset( $meta_style['size'] ) && ! empty( $meta_style['size'] ) ? 'font-size:' . $meta_style['size'] . 'px;' : null;
					$metaStyleComoncss .= isset( $meta_style['weight'] ) && ! empty( $meta_style['weight'] ) ? 'font-weight:' . $meta_style['weight'] . ';' : null;
					$metaStyleComoncss .= isset( $meta_style['align'] ) && ! empty( $meta_style['align'] ) ? 'text-align:' . $meta_style['align'] . ';' : null;

					if ( $metaStyleComoncss ) {
						$style .= "#{$layoutID} .tlp-portfolio-item .extra-features ul li {";
						$style .= $metaStyleComoncss;
						$style .= '}';
					}
				}
			} else {
				$title_color     = ! empty( $scMeta['title-color'] ) ? $scMeta['title-color'] : null;
				$title_size      = ! empty( $scMeta['title-font-size'] ) ? $scMeta['title-font-size'] : null;
				$title_weight    = ! empty( $scMeta['title-font-weight'] ) ? $scMeta['title-font-weight'] : null;
				$title_alignment = ! empty( $scMeta['title-alignment'] ) ? $scMeta['title-alignment'] : null;

				$short_desc_color     = ! empty( $scMeta['short-desc-color'] ) ? $scMeta['short-desc-color'] : null;
				$short_desc_size      = ! empty( $scMeta['short-desc-font-size'] ) ? $scMeta['short-desc-font-size'] : null;
				$short_desc_weight    = ! empty( $scMeta['short-desc-font-weight'] ) ? $scMeta['short-desc-font-weight'] : null;
				$short_desc_alignment = ! empty( $scMeta['short-desc-alignment'] ) ? $scMeta['short-desc-alignment'] : null;

				if ( $title_color ) {
					$style .= "#{$layoutID}.tlp-portfolio h3,
							#{$layoutID}.tlp-portfolio h3 a{ color: {$title_color};}";
				}

				if ( $title_size ) {
					$style .= "#{$layoutID}.tlp-portfolio h3,
							#{$layoutID}.tlp-portfolio h3 a{ font-size: {$title_size}px;}";
				}

				if ( $title_weight ) {
					$style .= "#{$layoutID}.tlp-portfolio h3,
							#{$layoutID}.tlp-portfolio h3 a{ font-weight: {$title_weight};}";
				}

				if ( $title_alignment ) {
					$style .= "#{$layoutID}.tlp-portfolio h3{ text-align: {$title_alignment};}";
				}

				// Short description.
				if ( $short_desc_color || $short_desc_size || $short_desc_weight || $short_desc_alignment ) {
					$style .= "#{$layoutID}.tlp-portfolio .tlp-content-holder .tlp-portfolio-sd{";

					if ( $short_desc_color ) {
						$style .= "color: {$short_desc_color};";
					}

					if ( $short_desc_size ) {
						$style .= "font-size: {$short_desc_size}px;";
					}

					if ( $short_desc_weight ) {
						$style .= "font-weight: {$short_desc_weight};";
					}

					if ( $short_desc_alignment ) {
						$style .= "text-align: {$short_desc_alignment};";
					}

					$style .= '}';
				}
			}

			if ( ! empty( $style ) ) {
				$style = "<style>{$style}</style>";
			}

			return $style;

		}

		private function get_team_old_layout( $atts ) {
			global $TLPportfolio;

			$atts          = shortcode_atts(
				[
					'orderby'                => 'date',
					'order'                  => 'DESC',
					'image'                  => 'true',
					'image_zoom'             => '',
					'image_size'             => 'full',
					'image_custom_dimension' => '', // wp_json_encode string.
					'number'                 => - 1,
					'pagination'             => false,
					'enable_page_link'       => false,
					'link_type'              => false,
					'link_target'            => false,
					'col'                    => 3,
					'tablet_col'             => 2,
					'mobile_col'             => 1,
					'layout'                 => 1,
					'letter-limit'           => 0,
					'cat'                    => null,
					'title-color'            => null,
					'title-font-size'        => null,
					'title-font-weight'      => null,
					'title-alignment'        => null,
					'short-desc-color'       => null,
					'short-desc-font-size'   => null,
					'short-desc-font-weight' => null,
					'short-desc-alignment'   => null,
					'class'                  => null,
					'slider_settings'        => '', // wp_json_encode string.
					'name'                   => '',
					'categories'             => '',
					'short_description'      => '',
					'client_name'            => '',
					'project_url'            => '',
					'completed_date'         => '',
					'tools'                  => '',
				],
				$atts,
				'tlpportfolio'
			);
			$atts['image'] = 'true' === esc_html($atts['image']);
			$limit         = $atts['letter-limit'] ? absint( $atts['letter-limit'] ) : 0;
			$dCol          = absint($atts['col']);
			$tCol          = absint($atts['tablet_col']);
			$mCol          = absint( $atts['mobile_col'] );

			if ( ! in_array( $dCol, array_keys( TLPPortfolio()->scColumns() ) ) ) {
				$dCol = 3;
			}

			if ( ! in_array( $tCol, array_keys( TLPPortfolio()->scColumns() ) ) ) {
				$tCol = 2;
			}

			if ( ! in_array( $mCol, array_keys( TLPPortfolio()->scColumns() ) ) ) {
				$mCol = 1;
			}

			if ( ! in_array( $atts['layout'], array_keys( TLPPortfolio()->oldScLayouts() ) ) ) {
				$atts['layout'] = 1;
			}

			if ( 1 == absint($atts['layout']) ) {
				$layout = 'layout1';
			} elseif ( 2 == absint($atts['layout'] )) {
				$layout = 'layout2';
			} elseif ( 3 == absint($atts['layout']) ) {
				$layout = 'layout3';
			} elseif ( 'isotope' == esc_html($atts['layout']) ) {
				$layout = 'isotope1';
			} else {
				$layout = esc_html($atts['layout']);
			}

			$isIsotope  = preg_match( '/isotope/', $layout );
			$isCarousel = preg_match( '/carousel/', $layout );
			$isLayout   = preg_match( '/layout/', $layout );
			$grid       = $dCol == 5 ? '24' : 12 / $dCol;
			$tgrid      = $tCol == 5 ? '24' : 12 / $tCol;
			$mgrid      = $mCol == 5 ? '24' : 12 / $mCol;

			if ( $dCol == 2 ) {
				$image_area   = 'tlp-col-lg-5 tlp-col-md-5 tlp-col-sm-6 tlp-col-xs-12 ';
				$content_area = 'tlp-col-lg-7 tlp-col-md-7 tlp-col-sm-6 tlp-col-xs-12 ';
			} else {
				$image_area   = 'tlp-col-lg-3 tlp-col-md-3 tlp-col-sm-6 tlp-col-xs-12 ';
				$content_area = 'tlp-col-lg-9 tlp-col-md-9 tlp-col-sm-6 tlp-col-xs-12 ';
			}

			$html           = null;
			$rand           = rand( 1, 10 );
			$posts_per_page = ( isset( $atts['number'] ) ? intval( $atts['number'] ) : -1 );

			$args = [
				'post_type'      => TLPPortfolio()->post_type,
				'post_status'    => 'publish',
				'posts_per_page' => $posts_per_page,
				'orderby'        => esc_html($atts['orderby']),
				'order'          => esc_html($atts['order']),
			];

			/* LIMIT */
			if ( $atts['pagination'] && ! ( $isCarousel || $isIsotope ) ) {
				$paged         = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				$args['paged'] = $paged;
			}

			if ( is_user_logged_in() && is_super_admin() ) {
				$args['post_status'] = [ 'publish', 'private' ];
			}

			$cat_ids = [];

			if ( ! empty( $atts['cat'] ) ) {
				$cat_ids           = explode( ',', esc_html($atts['cat']) );
				$args['tax_query'] = [
					[
						'taxonomy' => TLPPortfolio()->taxonomies['category'],
						'field'    => 'term_id',
						'terms'    => $cat_ids,
						'operator' => 'IN',
					],
				];
			}

			$customImgSize = [];
			$fImgSize      = 'full';
			if ( ! empty( $atts['image_size'] ) ) {
				$fImgSize = esc_html( $atts['image_size']);
				if ( 'pfp_custom' == $fImgSize || 'custom' == $fImgSize ) {
					if ( 'custom' == $fImgSize ) { // Elementor support.
						$fImgSize = 'pfp_custom';
					}

					$customImgSize = ! empty( $atts['image_custom_dimension'] ) ? json_decode( $atts['image_custom_dimension'], true ) : [];
				}
			}

			$portfolioQuery = new WP_Query( $args );
			$layoutID       = 'tlp-portfolio-container-' . mt_rand();
			$class          = [
				'rt-container-fluid',
				'tlp-portfolio',
				'tlp-portfolio-container',
			];

			if ( $isCarousel ) {
				$class[] = 'is-carousel';
			}

			if ( ! empty( $atts['class'] ) ) {
				$class[] = esc_html($atts['class']);
			}

			if ( $isIsotope ) {
				$class[] = 'is-isotope';
			}

			$class = implode( ' ', $class );
			$html .= "<div class='" . esc_attr( $class ) . "' id='{$layoutID}'>";

			$RowClasslayout = preg_replace( '/layoutcarousel/i', 'carousel', $layout );

			$html .= '<div class="rt-row ' . $RowClasslayout . '">';

			if ( $portfolioQuery->have_posts() ) {
				if ( $isIsotope ) {
					$terms = get_terms(
						TLPPortfolio()->taxonomies['category'],
						[
							'orderby'    => 'name',
							'order'      => 'ASC',
							'hide_empty' => false,
						]
					);
					$html .= '<div class="tlp-portfolio-isotope-button button-group filter-button-group option-set">
											<button data-filter="*" class="selected">' . __(
							'Show all',
							'tlp-portfolio'
						) . '</button>';

					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
						foreach ( $terms as $term ) {
							if ( ! empty( $cat_ids ) ) {
								if ( in_array( $term->term_id, $cat_ids ) ) {
									$html .= "<button data-filter='." . $term->slug . "'>" . $term->name . '</button>';
								}
							} else {
								$html .= "<button data-filter='.$term->slug'>" . $term->name . '</button>';
							}
						}
					}

					$html .= ' </div>';
					$html .= '<div class="tlp-portfolio-isotope">';
				}

				if ( $isCarousel ) {
					$Scontrol           = json_decode( $atts['slider_settings'], true );
					$dColItems          = ! empty( $atts['col'] ) ? absint( $atts['col']) : 3;
					$tColItems          = ! empty( $atts['tablet_col'] ) ? absint($atts['tablet_col']) : 2;
					$mColItems          = ! empty( $atts['mobile_col'] ) ? absint( $atts['mobile_col'] ) : 1;
					$smartSpeed         = ! empty( $Scontrol['autoplay_speed'] ) ? absint($Scontrol['autoplay_speed']) : 250;
					$autoplayTimeout    = ! empty( $Scontrol['timeout'] ) ? absint($Scontrol['timeout']) : 5000;
					$cOpt               = [];
					$autoPlay           = ! empty( $Scontrol['autoplay'] ) ? 'true' : 'false';
					$autoPlayHoverPause = ! empty( $Scontrol['stop_on_hover'] ) ? 'true' : 'false';
					$nav                = ! empty( $Scontrol['nav'] ) ? 'true' : 'false';
					$dots               = ! empty( $Scontrol['dots'] ) ? 'true' : 'false';
					$loop               = ! empty( $Scontrol['loop'] ) ? 'true' : 'false';
					$lazyLoad           = ! empty( $Scontrol['lazyload'] ) ? 'true' : 'false';
					$autoHeight         = ! empty( $Scontrol['autoheight'] ) ? 'true' : 'false';
					$rtl                = ! empty( $Scontrol['rtl'] ) ? 'true' : 'false';

					$html .= "<div class='pfp-carousel owl-carousel owl-theme'
									data-loop='{$loop}'
									data-items='{$dColItems}'
									data-autoplay='{$autoPlay}'
									data-autoplay-timeout='{$autoplayTimeout}'
									data-autoplay-hover-pause='{$autoPlayHoverPause}'
									data-dots='{$dots}'
									data-nav='{$nav}'
									data-lazyload='{$lazyLoad}'
									data-autoheight='{$autoHeight}'
									data-rtl='{$rtl}'
									data-smart-speed='{$smartSpeed}'
									data-tabcolumn='{$tColItems}'
									data-mobilecolumn='{$mColItems}'
									>";
				}

				while ( $portfolioQuery->have_posts() ) :
					$portfolioQuery->the_post();

					$title = get_the_title();
					$iID   = get_the_ID();
					$plink = get_permalink();

					$short_d     = get_post_meta( $iID, 'short_description', true );
					$short_d     = TLPPortfolio()->get_short_description( $short_d, $limit );
					$project_url = get_post_meta( $iID, 'project_url', true );
					$tools       = get_post_meta( $iID, 'tools', true );

					$client_name    = get_post_meta( $iID, 'client_name', true );
					$completed_date = get_post_meta( $iID, 'completed_date', true );

					$tags = get_the_term_list( $iID, TLPPortfolio()->taxonomies['tag'], 'Tags : ', ',' );

					$catClass   = null;
					$categories = null;
					$catAs      = wp_get_post_terms(
						$iID,
						TLPPortfolio()->taxonomies['category'],
						[ 'fields' => 'all' ]
					);

					if ( ! empty( $catAs ) ) {
						foreach ( $catAs as $cat ) {
							$catClass   .= ' ' . $cat->slug;
							$categories .= ' ' . $cat->name;
						}
					}

					$img     = null;
					$imgFull = null;

					if ( has_post_thumbnail() ) {
						$img = TLPPortfolio()->getFeatureImageSrc( $iID, $fImgSize, $customImgSize );

						$imageFull = wp_get_attachment_image_src( get_post_thumbnail_id( $iID ), 'full' );
						$imgFull   = isset( $imageFull[0] ) ? $imageFull[0] : '';
					} else {
						$img = TLPPortfolio()->assetsUrl . 'images/demo.jpg';
					}

					if ( ! $imgFull ) {
						$imgFull = $img;
					}

					if ( ! $atts['image'] ) {
						$content_area = 'tlp-col-md-12';
						$img          = null;
					}

					$itemArg                     = [];
					$itemArg['categories']       = ! empty( $atts['categories'] ) ? $categories : '';
					$itemArg['link_target']      = ! empty( $atts['link_target'] ) ? '_blank' : '_self';
					$itemArg['enable_page_link'] = ! empty( $atts['enable_page_link'] ) ? true : false;
					$itemArg['title']            = ! empty( $atts['name'] ) ? $title : '';
					$itemArg['PostTitle']        = $title;
					$itemArg['plink']            = $plink;

					if ( 'external_link' == $atts['link_type'] && $project_url ) {
						$itemArg['plink'] = $project_url;
					}

					$itemArg['img']            = $img;
					$itemArg['imgFull']        = $imgFull;
					$itemArg['short_d']        = ! empty( $atts['short_description'] ) ? $short_d : '';
					$itemArg['grid']           = $grid;
					$itemArg['tgrid']          = $tgrid;
					$itemArg['mgrid']          = $mgrid;
					$itemArg['rand']           = $rand;
					$itemArg['catClass']       = $catClass;
					$itemArg['limit']          = $limit;
					$itemArg['image_area']     = $image_area;
					$itemArg['content_area']   = $content_area;
					$itemArg['client_name']    = ! empty( $atts['client_name'] ) ? esc_html($client_name) : '';
					$itemArg['project_url']    = $atts['project_url'];
					$itemArg['completed_date'] = ! empty( $atts['completed_date'] ) ? $completed_date : '';
					$itemArg['tools']          = ! empty( $atts['tools'] ) ? wp_kses_post($tools) : '';
					$itemArg['image_zoom']     = ! empty( $atts['image_zoom'] ) ? esc_html( $atts['image_zoom'] ) : '';

					if ( $atts['layout'] ) {
						switch ( $layout ) {
							case 'layout1':
								$html .= $this->templateOne( $itemArg );
								break;

							case 'layout2':
								$html .= $this->templateTwo( $itemArg );
								break;

							case 'layout3':
								$html .= $this->templateThree( $itemArg );
								break;

							case 'isotope1':
								$html .= $this->layoutIsotope1( $itemArg );
								break;

							case 'isotope2':
								$html .= $this->layoutIsotope2( $itemArg );
								break;
							case 'isotope3':
								$html .= $this->layoutIsotope3( $itemArg );
								break;

							case 'carousel1':
								$html .= $this->carousel1( $itemArg );
								break;

							case 'carousel2':
								$html .= $this->carousel2( $itemArg );
								break;

							case 'carousel3':
								$html .= $this->carousel3( $itemArg );
								break;

							default:
								// code...
								break;

						}
					}
				endwhile;
				wp_reset_postdata();

				if ( $isIsotope || $isCarousel ) {
					$html .= ' </div>'; // end tlp-team-isotope.
				}

				add_action( 'wp_footer', [ $this, 'load_scripts' ] );

			} else {
				$html .= '<p>No portfolio found</p>';
			}

			$html .= '</div>'; // end row.

			if ( $atts['pagination'] && ! $isCarousel ) {
				$html .= TLPPortfolio()->pagination( $portfolioQuery, $args, [] );
			}
			$html .= '</div>'; // end container.

			return $html;
		}
	}
endif;
