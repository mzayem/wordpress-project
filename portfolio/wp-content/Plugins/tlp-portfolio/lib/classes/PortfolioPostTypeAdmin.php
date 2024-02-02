<?php
/**
 * Post Type Admin class.
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( ! class_exists( 'PortfolioPostTypeAdmin' ) ) :
	/**
	 * Post Type Admin class.
	 */
	class PortfolioPostTypeAdmin {
		public $post_type    = 'portfolio';
		public $sc_post_type = 'portfolio-sc';

		public function __construct() {
			add_theme_support( 'post-thumbnails', [ $this->post_type ] );

			add_filter( 'manage_edit-' . $this->post_type . '_columns', [ $this, 'arrange_portfolio_columns' ] );
			add_action( 'manage_' . $this->post_type . '_posts_custom_column', [ $this, 'manage_portfolio_columns' ], 10, 2 );
			add_action( 'restrict_manage_posts', [ $this, 'add_taxonomy_filters' ] );

			add_filter( 'manage_edit-' . $this->sc_post_type . '_columns', [ $this, 'arrange_portfolio_sc_columns' ] );
			add_action( 'manage_' . $this->sc_post_type . '_posts_custom_column', [ $this, 'manage_portfolio_sc_columns' ], 10, 2 );
		}

		public function arrange_portfolio_sc_columns( $columns ) {
			$shortcode = [ 'shortcode' => esc_html__( 'TLP Portfolio ShortCode', 'tlp-portfolio' ) ];
			return array_slice( $columns, 0, 2, true ) + $shortcode + array_slice( $columns, 1, null, true );
		}

		public function manage_portfolio_sc_columns( $column ) {
			switch ( $column ) {
				case 'shortcode':
					echo '<input type="text" onfocus="this.select();" readonly="readonly" value="[tlpportfolio id=&quot;' . get_the_ID() . '&quot; title=&quot;' . esc_html( get_the_title() ) . '&quot;]" class="large-text code tlp-code-sc">';
					break;
				default:
					break;
			}
		}

		public function add_taxonomy_filters() {
			global $typenow;

			// Must set this to the post type you want the filter(s) displayed on.
			if ( $this->post_type !== $typenow ) {
				return;
			}

			$taxonomies = [ 'tag' => 'portfolio-tag' ];

			foreach ( $taxonomies as $tax_slug ) {
				TLPPortfolio()->print_html( $this->build_taxonomy_filter( $tax_slug ), true );
			}
		}

		/**
		 * Build an individual dropdown filter.
		 *
		 * @param  string $tax_slug Taxonomy slug to build filter for.
		 *
		 * @return string Markup, or empty string if taxonomy has no terms.
		 */
		protected function build_taxonomy_filter( $tax_slug ) {
			$terms = get_terms( $tax_slug );

			if ( 0 == count( $terms ) ) {
				return '';
			}

			$tax_name         = $this->get_taxonomy_name_from_slug( $tax_slug );
			$current_tax_slug = isset( $_GET[ $tax_slug ] ) ? sanitize_title_with_dashes( wp_unslash( $_GET[ $tax_slug ] ) ) : false;
			$filter           = '<select name="' . esc_attr( $tax_slug ) . '" id="' . esc_attr( $tax_slug ) . '" class="postform">';
			$filter          .= '<option value="0">' . esc_html( $tax_name ) . '</option>';
			$filter          .= $this->build_term_options( $terms, $current_tax_slug );
			$filter          .= '</select>';

			return $filter;
		}

		/**
		 * Get the friendly taxonomy name, if given a taxonomy slug.
		 *
		 * @param  string $tax_slug Taxonomy slug.
		 *
		 * @return string Friendly name of taxonomy, or empty string if not a valid taxonomy.
		 */
		protected function get_taxonomy_name_from_slug( $tax_slug ) {
			$tax_obj = get_taxonomy( $tax_slug );

			if ( ! $tax_obj ) {
				return '';
			}

			return $tax_obj->labels->name;
		}

		/**
		 * Build a series of option elements from an array.
		 *
		 * Also checks to see if one of the options is selected.
		 *
		 * @param  array  $terms            Array of term objects.
		 * @param  string $current_tax_slug Slug of currently selected term.
		 *
		 * @return string Markup.
		 */
		protected function build_term_options( $terms, $current_tax_slug ) {
			$options = '';

			foreach ( $terms as $term ) {
				$options .= sprintf(
					"<option value='%s' %s />%s</option>",
					esc_attr( $term->slug ),
					selected( $current_tax_slug, $term->slug, false ),
					esc_html( $term->name . '(' . $term->count . ')' )
				);
			}
			return $options;
		}


		public function arrange_portfolio_columns( $columns ) {
			$column_thumbnail = [ 'thumbnail' => esc_html__( 'Image', 'tlp-portfolio' ) ];
			return array_slice( $columns, 0, 2, true ) + $column_thumbnail + array_slice( $columns, 1, null, true );
		}

		public function manage_portfolio_columns( $column ) {
			switch ( $column ) {
				case 'thumbnail':
					echo get_the_post_thumbnail( get_the_ID(), [ 35, 35 ] );
					break;
			}
		}
	}
endif;
