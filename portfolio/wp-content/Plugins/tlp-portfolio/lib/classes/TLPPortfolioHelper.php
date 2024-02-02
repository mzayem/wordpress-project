<?php
/**
 * Helper class.
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( ! class_exists( 'TLPPortfolioHelper' ) ) :
	/**
	 * Helper class.
	 */
	class TLPPortfolioHelper {
		public function verifyNonce() {
			$nonce     = isset( $_REQUEST['tlp_nonce'] ) && ! empty( $_REQUEST['tlp_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['tlp_nonce'] ) ) : null;
			$nonceText = $this->nonceText();

			if ( wp_verify_nonce( $nonce, $nonceText ) ) {
				return true;
			}

			return false;
		}

		public function nonceId() {
			return 'tlp_nonce';
		}

		public function nonceText() {
			return 'tlp_portfolio_nonce';
		}


		public function meta_exist( $post_id, $meta_key, $type = 'post' ) {
			if ( ! $post_id ) {
				return false;
			}

			return metadata_exists( $type, $post_id, $meta_key );
		}

		public function get_short_description( $content, $limit = 0, $tags = '', $invert = false ) {
			$filter_content = wp_kses_post( html_entity_decode( $content ) );

			if ( $limit ) {
				$filter_content = wp_filter_nohtml_kses( $filter_content );

				if ( $limit > 0 && strlen( $filter_content ) > $limit ) {
					$filter_content = mb_substr( $filter_content, 0, $limit, 'utf-8' );
					$filter_content = preg_replace( '/\W\w+\s*(\W*)$/', '$1', $filter_content );
				}
			}

			return apply_filters( 'tlp_portfolio_get_short_description', $filter_content, $content, $limit );
		}

		/**
		 * @return string
		 * Remove select2Js confection
		 */
		public function getSelect2JsId() {
			$select2Id = 'tlp-select2';

			if ( class_exists( 'WPSEO_Admin_Asset_Manager' ) && class_exists( 'Avada' ) ) {
				$select2Id = 'yoast-seo-select2';
			} elseif ( class_exists( 'WPSEO_Admin_Asset_Manager' ) ) {
				$select2Id = 'yoast-seo-select2';
			} elseif ( class_exists( 'Avada' ) ) {
				$select2Id = 'select2-avada-js';
			}

			return $select2Id;
		}

		public function pfpScMetaFields() {
			return array_merge(
				TLPPortfolio()->scLayoutMetaFields(),
				TLPPortfolio()->scFilterMetaFields(),
				TLPPortfolio()->scItemMetaFields(),
				TLPPortfolio()->scStyleFields()
			);
		}

		public function rtFieldGenerator( $fields = [] ) {
			$html = null;

			if ( is_array( $fields ) && ! empty( $fields ) ) {
				$PFProField = new TlpPortfolioField();

				foreach ( $fields as $fieldKey => $field ) {
					$html .= $PFProField->Field( $fieldKey, $field );
				}
			}

			return $html;
		}

		public function getAllPortFolioCategoryList() {
			$terms    = [];
			$termList = get_terms( [ TLPPortfolio()->taxonomies['category'] ], [ 'hide_empty' => 0 ] );

			if ( is_array( $termList ) && ! empty( $termList ) && empty( $termList['errors'] ) ) {
				foreach ( $termList as $term ) {
					$terms[ $term->term_id ] = $term->name;
				}
			}

			return $terms;
		}


		public function getAllPortFolioTagList() {
			$terms    = [];
			$termList = get_terms( [ TLPPortfolio()->taxonomies['tag'] ], [ 'hide_empty' => 0 ] );

			if ( is_array( $termList ) && ! empty( $termList ) && empty( $termList['errors'] ) ) {
				foreach ( $termList as $term ) {
					$terms[ $term->term_id ] = $term->name;
				}
			}

			return $terms;
		}

		public function get_image_sizes() {
			global $_wp_additional_image_sizes;

			$sizes      = [];
			$interSizes = get_intermediate_image_sizes();

			if ( ! empty( $interSizes ) ) {
				foreach ( get_intermediate_image_sizes() as $_size ) {
					if ( in_array( $_size, [ 'thumbnail', 'medium', 'large' ] ) ) {
						$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
						$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
						$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
					} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
						$sizes[ $_size ] = [
							'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
							'height' => $_wp_additional_image_sizes[ $_size ]['height'],
							'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
						];
					}
				}
			}

			$imgSize = [
				'' => esc_html__( 'Select One', 'tlp-portfolio' ),
			];

			if ( ! empty( $sizes ) ) {
				foreach ( $sizes as $key => $img ) {
					$imgSize[ $key ] = ucfirst( $key ) . " ({$img['width']}*{$img['height']})";
				}
			}

			$imgSize['pfp_custom'] = esc_html__( 'Custom image size', 'tlp-portfolio' );

			return $imgSize;
		}

		public function getFeatureImageSrc( $post_id = null, $fImgSize = 'team-thumb', $customImgSize = [] ) {
			global $post;

			$img_class = 'img-responsive';
			$post_id   = ( $post_id ? absint( $post_id ) : $post->ID );
			$alt       = esc_attr( get_the_title( $post_id ) );
			$imgSrc    = $image = null;
			$cSize     = false;
			// if ($fImgSize == 'rt_custom') {

			if ( $fImgSize == 'pfp_custom' || $fImgSize == 'rt_custom' ) {
				$fImgSize = 'full';
				$cSize    = true;
			}
			// pfp_custom

			if ( $aID = get_post_thumbnail_id( $post_id ) ) {
				$image  = wp_get_attachment_image( $aID, $fImgSize, '', [ 'class' => $img_class ] );
				$imageS = wp_get_attachment_image_src( $aID, $fImgSize );
				$imgSrc = isset( $imageS[0] ) ? $imageS[0] : '';
			}

			if ( $imgSrc && $cSize ) {
				global $TLPportfolio;

				$w = ( ! empty( $customImgSize['width'] ) ? absint( $customImgSize['width'] ) : null );
				$h = ( ! empty( $customImgSize['height'] ) ? absint( $customImgSize['height'] ) : null );
				$c = ( ! empty( $customImgSize['crop'] ) && $customImgSize['crop'] == 'soft' ? false : true );

				if ( $w && $h ) {
					$imgSrc = $TLPportfolio->rtImageReSize( $imgSrc, $w, $h, $c );

					if ( $imgSrc ) {
						$image = "<img alt='{$alt}' width='{$w}' height='{$h}' class='{$img_class}' src='{$imgSrc}' />";
					}
				}
			}

			return $image;
		}

		public function rtImageReSize( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = false ) {
			$rtResize = new PFProReSizer();

			return $rtResize->process( $url, $width, $height, $crop, $single, $upscale );
		}


		/**
		 * Sanitize field value
		 *
		 * @param array $field
		 * @param null  $value
		 *
		 * @return array|null
		 * @internal param $value
		 */
		public function sanitize( $field = [], $value = null ) {
			$newValue = null;

			if ( is_array( $field ) ) {
				$type = ( ! empty( $field['type'] ) ? $field['type'] : 'text' );

				if ( empty( $field['multiple'] ) ) {
					if ( $type == 'url' ) {
						$newValue = esc_url( $value );
					} elseif ( $type == 'slug' ) {
						$newValue = sanitize_title_with_dashes( $value );
					} elseif ( $type == 'textarea' ) {
						$newValue = wp_kses_post( $value );
					} elseif ( $type == 'custom_css' ) {
						$newValue = htmlentities( stripslashes( $value ) );
					} elseif ( $type == 'image_size' ) {
						$newValue = [];

						foreach ( $value as $k => $v ) {
							$newValue[ $k ] = esc_attr( $v );
						}
					} elseif ( $type == 'style' ) {
						$newValue = [];

						foreach ( $value as $k => $v ) {
							if ( $k == 'color' ) {
								$newValue[ $k ] = $this->sanitize_hex_color( $v );
							} else {
								$newValue[ $k ] = $this->sanitize( [ 'type' => 'text' ], $v );
							}
						}
					} else {
						$newValue = sanitize_text_field( $value );
					}
				} else {
					$newValue = [];
					if ( ! empty( $value ) ) {
						if ( is_array( $value ) ) {
							foreach ( $value as $key => $val ) {
								if ( $type == 'style' && $key == 0 ) {
									if ( function_exists( 'sanitize_hex_color' ) ) {
										$newValue = sanitize_hex_color( $val );
									} else {
										$newValue[] = $this->sanitize_hex_color( $val );
									}
								} else {
									$newValue[] = sanitize_text_field( $val );
								}
							}
						} else {
							$newValue[] = sanitize_text_field( $value );
						}
					}
				}
			}

			return $newValue;
		}

		public function sanitize_hex_color( $color ) {
			if ( function_exists( 'sanitize_hex_color' ) ) {
				return sanitize_hex_color( $color );
			} else {
				if ( '' === $color ) {
					return '';
				}

				// 3 or 6 hex digits, or the empty string.
				if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
					return $color;
				}
			}
		}

		public function TLPhex2rgba( $color, $opacity = false ) {
			$default = 'rgb(0,0,0)';

			// Return default if no color provided.
			if ( empty( $color ) ) {
				return $default;
			}

			// Sanitize $color if "#" is provided.
			if ( $color[0] == '#' ) {
				$color = substr( $color, 1 );
			}

			// Check if color has 6 or 3 characters and get values.
			if ( strlen( $color ) == 6 ) {
				$hex = [ $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] ];
			} elseif ( strlen( $color ) == 3 ) {
				$hex = [ $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] ];
			} else {
				return $default;
			}

			// Convert hexadec to rgb.
			$rgb = array_map( 'hexdec', $hex );

			// Check if opacity is set(rgba or rgb).
			if ( $opacity ) {
				if ( abs( $opacity ) > 1 ) {
					$opacity = 1.0;
				}
				$output = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';
			} else {
				$output = 'rgb(' . implode( ',', $rgb ) . ')';
			}

			// Return rgb(a) color string.
			return $output;
		}

		public function singlePortfolioMeta( $id = null ) {
			global $TLPportfolio;

			$id = ( ! $id ? get_the_ID() : $id );

			if ( ! $id ) {
				return;
			}

			$project_url    = get_post_meta( $id, 'project_url', true );
			$tools          = get_post_meta( $id, 'tools', true );
			$client_name    = get_post_meta( $id, 'client_name', true );
			$completed_date = get_post_meta( $id, 'completed_date', true );
			$categories     = wp_strip_all_tags( get_the_term_list( $id, $TLPportfolio->taxonomies['category'], '', ', ' ) );
			$tags           = wp_strip_all_tags( get_the_term_list( $id, $TLPportfolio->taxonomies['tag'], '', ', ' ) );

			$html  = null;
			$html .= '<ul class="single-item-meta">';

			if ( $project_url ) {
				$html .= '<li><label>' . esc_html__( 'Project URL', 'tlp-portfolio' ) . ':</label> <a  href="' . esc_url( $project_url ) . '" target="_blank">' . esc_html( $project_url ) . '</a></li>';
			}

			if ( $categories ) {
				$html .= '<li class="categories"><label>' . esc_html__( 'Categories: ', 'tlp-portfolio' ) . '</label><span>' . esc_html( $categories ) . '</span></li>';
			}

			if ( $tools ) {
				$html .= '<li class="tools"><label>' . esc_html__( 'Tools', 'tlp-portfolio' ) . ': </label><span>' . esc_html( $tools ) . '</span></li>';
			}

			if ( $client_name ) {
				$html .= '<li class="client-name"><label>' . esc_html__( 'Client', 'tlp-portfolio' ) . ': </label> <span>' . esc_html( $client_name ) . '</span></li>';
			}

			if ( $completed_date ) {
				$html .= '<li class="completed-date"> <label>' . esc_html__( 'Completed Date', 'tlp-portfolio' ) . ': </label><span>' . esc_html( $completed_date ) . '</span></li>';
			}

			if ( $tags ) {
				$html .= '<li class="tags"><label>' . esc_html__( 'Tags :', 'tlp-portfolio' ) . '</label><span>' . esc_html( $tags ) . '</span></li>';
			}

			$html .= '</ul>';

			if ( $html ) {
				$html = "<ul class='single-item-meta'>{$html}</ul>";
			}

			return wp_kses_post( $html );
		}

		public function socialShare( $pLink ) {
			$html  = null;
			$html .= "<div class='single-portfolio-share'>
						<div class='fb-share rt-share-item'>
							<div class='fb-share-button' data-href='" . esc_attr( $pLink ) . "' data-layout='button_count'></div>
						</div>
						<div class='twitter-share rt-share-item'>
							<a href='" . esc_url( $pLink ) . "' class='twitter-share-button'{count} data-url='https://about.twitter.com/resources/buttons#tweet'>Tweet</a>
						</div>

						<div class='linkedin-share rt-share-item'>
							<script type='IN/Share' data-counter='right'></script>
						</div>
					</div>";
			$html .= '<div id="fb-root"></div>
			<script>(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
					fjs.parentNode.insertBefore(js, fjs);
				}(document, "script", "facebook-jssdk"));</script>';
			$html .= "<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			<script>window.___gcfg = { lang: 'en-US', parsetags: 'onload', };</script>";
			$html .= "<script src='https://apis.google.com/js/platform.js' async defer></script>";
			$html .= '<script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script>';
			$html .= '<script async defer src="//assets.pinterest.com/js/pinit.js"></script>';

			return $html;
		}

		public function proFeatureList() {
			ob_start();
			?>
			<ol>
				<li>Full Responsive & Mobile Friendly</li>
				<li>57 Layouts (Even Grid, Masonry Grid, Even Isotope, Masonry Isotope & Carousel Slider)</li>
				<li>Unlimited Layouts Variation</li>
				<li>Unlimited Colors</li>
				<li>Unlimited ShortCode Generator</li>
				<li>Drag & Drop Ordering</li>
				<li>Drag & Drop Taxonomy ie Category Ordering</li>
				<li>Gutter / Padding Control</li>
				<li>Dynamic image Re-size & Custom image size</li>
				<li>Detail page with popup next preview button and normal view</li>
				<li>Device wise Item View Control</li>
				<li>Visual Composer Compatibility</li>
				<li> 4 Types of Pagination Normal number, AJAX number Pagination, AJAX Load More & Auto Load on Scroll</li>
				<li>Layout Preview Under ShortCode Generator</li>
				<li>Count for Isotope Button</li>
				<li>Search for Isotope Layouts</li>
				<li>All Fields Control show/hide</li>
				<li>RTL Added for Carousel Slider</li>
				<li>All text color, Size and Text align control</li>
				<li>Related Portfolio</li>
			</ol>
			<p><a href="<?php echo esc_url( TLPPortfolio()->pro_version_link() ); ?>" class="button button-primary" target="_blank">Get Pro Version</a></p>
			<?php
			return ob_get_clean();

		}

		/**
		 * @param     $query
		 * @param int    $args
		 * @param     $scMeta
		 *
		 * @return string|null
		 */
		public function pagination( $query, $args, $scMeta ) {
			$html      = null;
			$range     = isset( $args['posts_per_page'] ) ? $args['posts_per_page'] : 4;
			$range     = isset( $args['posts_per_page_meta'] ) ? $args['posts_per_page_meta'] : $range;
			$showitems = ( $range * 2 ) + 1;

			global $paged;

			if ( is_front_page() ) {
				$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
			} else {
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			}

			if ( empty( $paged ) ) {
				$paged = 1;
			}

			$pages = $query->max_num_pages;

			if ( isset( $scMeta['pfp_limit'][0] ) && ! empty( $scMeta['pfp_limit'][0] ) ) {
				$found_post = $query->found_posts;

				if ( $range && $found_post > $scMeta['pfp_limit'][0] ) {
					$found_post = $scMeta['pfp_limit'][0];
					$pages      = ceil( $found_post / $range );
				}
			}

			if ( ! $pages ) {
				global $wp_query;
				$pages = $wp_query->max_num_pages;
				$pages = $pages ? $pages : 1;
			}

			if ( 1 != $pages ) {
				$li = null;

				if ( apply_filters( 'tlp_portfolio_pagination_page_count', true ) ) {
					$li .= sprintf(
						'<li class="disabled hidden-xs"><span><span aria-hidden="true">%s</span></span></li>',
						sprintf( esc_html__( 'Page %1$d of %2$d', 'tlp-portfolio' ), $paged, $pages )
					);
				}

				if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) {
					$li .= sprintf(
						'<li><a href="%1$s" aria-label="%2$s">&laquo;<span class="hidden-xs">%2$s</span></a></li>',
						get_pagenum_link( 1 ),
						esc_html__( 'First', 'tlp-portfolio' )
					);
				}

				if ( $paged > 1 && $showitems < $pages ) {
					$li .= sprintf(
						'<li><a href="%1$s" aria-label="%2$s">&lsaquo;<span class="hidden-xs">%2$s</span></a></li>',
						get_pagenum_link( $paged - 1 ),
						esc_html__( 'Previous', 'tlp-portfolio' )
					);
				}

				for ( $i = 1; $i <= $pages; $i++ ) {
					if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
						$li .= $paged == $i ? sprintf( '<li class="active"><span>%d</span></li>', $i )
							: sprintf( '<li><a href="%s">%d</a></li>', get_pagenum_link( $i ), $i );

					}
				}

				if ( $paged < $pages && $showitems < $pages ) {
					$li .= sprintf(
						'<li><a href="%1$s" aria-label="%2$s">&lsaquo;<span class="hidden-xs">%2$s </span></a></li>',
						get_pagenum_link( $paged + 1 ),
						esc_html__( 'Next', 'tlp-portfolio' )
					);
				}

				if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages ) {
					$li .= sprintf(
						'<li><a href="%1$s" aria-label="%2$s">&raquo;<span class="hidden-xs">%2$s </span></a></li>',
						get_pagenum_link( $pages ),
						esc_html__( 'Last', 'tlp-portfolio' )
					);
				}

				$html = sprintf(
					'<div class="tlp-pagination-wrap" data-total-pages="%d" data-posts-per-page="%d">%s</div>',
					$query->max_num_pages,
					$args['posts_per_page'],
					$li ? sprintf( '<ul class="tlp-pagination">%s</ul>', $li ) : ''
				);
			}

			return apply_filters( 'tlp_portfolio_pagination_html', $html, $query, $args, $scMeta );
		}

		public function get_shortCode_list() {
			$scList = [];
			$scQ    = get_posts(
				[
					'post_type'      => TLPPortfolio()->getScPostType(),
					'order_by'       => 'title',
					'order'          => 'ASC',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
				]
			);

			if ( ! empty( $scQ ) ) {
				$scList = wp_list_pluck( $scQ, 'post_title', 'ID' );
			}

			return $scList;
		}

		// Date format.
		public function date_format_php_to_js() {
			$sFormat = get_option( 'date_format' );

			switch ( $sFormat ) {
				// Predefined WP date formats
				case 'F j, Y':
					return ( 'MM dd, yyyy' );
					break;
				case 'Y/m/d':
					return ( 'yyyy/mm/dd' );
					break;
				case 'm/d/Y':
					return ( 'mm/dd/yyyy' );
					break;
				case 'd/m/Y':
					return ( 'dd/mm/yyyy' );
					break;
				default:
					return ( 'dd-mm-yyyy' );
					break;
			}
		}

		/**
		 * A custom sanitization function that will take the incoming input, and sanitize
		 * the input before handing it back to WordPress to save to the database and The output of frontend.
		 *
		 * @since    1.0.0
		 *
		 * @param    array $input  Array value string .
		 * @return   array.
		 */
		public function array_text_sanitization( $input ) {
			$input = maybe_unserialize( $input );
			return ! empty( $input ) ? array_map( 'sanitize_text_field', array_filter( $input ) ) : [];
		}

		/**
		 * A custom sanitization function that will take the incoming input, and sanitize
		 * the input before handing it back to WordPress to save to the database and The output of frontend.
		 *
		 * @since    1.0.0
		 *
		 * @param    array $input  Array with integer value  .
		 * @return   array.
		 */
		public function array_int_sanitization( $input ) {
			$input = maybe_unserialize( $input );
			return ! empty( $input ) ? array_map( 'absint', array_filter( $input ) ) : [];
		}

		/**
		 * Prints HTMl.
		 *
		 * @param string $html HTML.
		 * @param bool   $allHtml All HTML.
		 *
		 * @return mixed
		 */
		public function print_html( $html, $allHtml = false ) {
			if ( $allHtml ) {
				echo stripslashes_deep( $html );
			} else {
				echo wp_kses_post( stripslashes_deep( $html ) );
			}
		}

		/**
		 * Allowed HTML for wp_kses.
		 *
		 * @param string $level Tag level.
		 *
		 * @return mixed
		 */
		public function allowedHtml( $level = 'basic' ) {
			$allowed_html = [];

			switch ( $level ) {
				case 'basic':
					$allowed_html = [
						'b'      => [
							'class' => [],
							'id'    => [],
						],
						'i'      => [
							'class' => [],
							'id'    => [],
						],
						'u'      => [
							'class' => [],
							'id'    => [],
						],
						'br'     => [
							'class' => [],
							'id'    => [],
						],
						'em'     => [
							'class' => [],
							'id'    => [],
						],
						'span'   => [
							'class' => [],
							'id'    => [],
							'style' => [],
						],
						'strong' => [
							'class' => [],
							'id'    => [],
						],
						'hr'     => [
							'class' => [],
							'id'    => [],
						],
						'div'    => [
							'class' => [],
							'id'    => [],
						],
						'a'      => [
							'href'   => [],
							'title'  => [],
							'class'  => [],
							'id'     => [],
							'target' => [],
						],
					];
					break;

				case 'advanced':
					$allowed_html = [
						'b'      => [
							'class' => [],
							'id'    => [],
						],
						'i'      => [
							'class' => [],
							'id'    => [],
						],
						'u'      => [
							'class' => [],
							'id'    => [],
						],
						'br'     => [
							'class' => [],
							'id'    => [],
						],
						'em'     => [
							'class' => [],
							'id'    => [],
						],
						'span'   => [
							'class' => [],
							'id'    => [],
						],
						'strong' => [
							'class' => [],
							'id'    => [],
						],
						'hr'     => [
							'class' => [],
							'id'    => [],
						],
						'a'      => [
							'href'   => [],
							'title'  => [],
							'class'  => [],
							'id'     => [],
							'target' => [],
						],
						'input'  => [
							'type'  => [],
							'name'  => [],
							'class' => [],
							'value' => [],
						],
					];
					break;

				case 'image':
					$allowed_html = [
						'img' => [
							'src'      => [],
							'data-src' => [],
							'alt'      => [],
							'height'   => [],
							'width'    => [],
							'class'    => [],
							'id'       => [],
							'style'    => [],
							'srcset'   => [],
							'loading'  => [],
							'sizes'    => [],
						],
						'div' => [
							'class' => [],
						],
					];
					break;

				case 'anchor':
					$allowed_html = [
						'a' => [
							'href'  => [],
							'title' => [],
							'class' => [],
							'id'    => [],
							'style' => [],
						],
					];
					break;

				default:
					// code...
					break;
			}

			return $allowed_html;
		}

		/**
		 * Definition for wp_kses.
		 *
		 * @param string $string String to check.
		 * @param string $level Tag level.
		 *
		 * @return mixed
		 */
		public function htmlKses( $string, $level ) {
			if ( empty( $string ) ) {
				return;
			}

			return wp_kses( $string, self::allowedHtml( $level ) );
		}
	}
endif;
