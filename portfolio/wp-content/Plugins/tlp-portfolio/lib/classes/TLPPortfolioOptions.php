<?php
/**
 * Options class.
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( ! class_exists( 'TLPPortfolioOptions' ) ) :
	/**
	 * Options class.
	 */
	class TLPPortfolioOptions {
		public function scLayoutMetaFields() {
			global $TLPportfolio;

			return [
				'pfp_layout_type'               => [
					'type'    => 'radio-image',
					'label'   => esc_html__( 'Layout type', 'tlp-portfolio' ),
					'id'      => 'rtpfp-layout-type',
					'options' => [
						'grid'     => [
							'title'   => esc_html__( 'Grid Layout', 'tlp-portfolio' ),
							'demoUrl' => '',
							'img'     => $TLPportfolio->assetsUrl . 'images/layout_type_grid.png',
						],
						'isotope'  => [
							'title'   => esc_html__( 'Isotop Layout', 'tlp-portfolio' ),
							'demoUrl' => '',
							'img'     => $TLPportfolio->assetsUrl . 'images/layout_type_isotope.png',
						],
						'carousel' => [
							'title'   => esc_html__( 'Slider Layout', 'tlp-portfolio' ),
							'demoUrl' => '',
							'img'     => $TLPportfolio->assetsUrl . 'images/layout_type_slider.png',
						],
					],
				],
				'pfp_layout'                    => [
					'label'   => esc_html__( 'Layout', 'tlp-portfolio' ),
					'type'    => 'radio-image',
					'class'   => 'rt-select2',
					'options' => $this->scLayouts(),
				],
				'pfp_isotope_filter_taxonomy'   => [
					'type'        => 'select',
					'label'       => __( "Isotope filter (Selected item) <span style='color:red;'>Pro feature</span>", 'tlp-portfolio' ),
					'holderClass' => 'pfp-isotope-item pfp-hidden',
					'class'       => 'rt-select2',
					'attr'        => 'disabled',
				],
				'pfp_isotope_filter_show_all'   => [
					'type'        => 'checkbox',
					'label'       => __( "Isotope filter (Show All item) <span style='color:red;'>Pro feature</span>", 'tlp-portfolio' ),
					'holderClass' => 'pfp-isotope-item pfp-hidden',
					'id'          => 'rt-tpg-sc-isotope-filter-show-all',
					'optionLabel' => esc_html__( 'Disable', 'tlp-portfolio' ),
					'option'      => 1,
					'attr'        => 'disabled',
				],
				'pfp_isotope_search_filtering'  => [
					'type'        => 'checkbox',
					'label'       => "Isotope search filter <span style='color:red;'>Pro feature</span>",
					'holderClass' => 'pfp-isotope-item pfp-hidden',
					'optionLabel' => 'Enable',
					'option'      => 1,
					'attr'        => 'disabled',
				],

				'pfp_carousel_speed'            => [
					'label'       => esc_html__( 'Speed', 'tlp-portfolio' ),
					'holderClass' => 'pfp-hidden pfp-carousel-item',
					'type'        => 'number',
					'default'     => 2000,
					'description' => esc_html__( 'Auto play Speed in milliseconds', 'tlp-portfolio' ),
				],
				'pfp_carousel_options'          => [
					'label'       => esc_html__( 'Carousel Options', 'tlp-portfolio' ),
					'holderClass' => 'pfp-hidden pfp-carousel-item',
					'type'        => 'checkbox',
					'multiple'    => true,
					'alignment'   => 'vertical',
					'options'     => $this->owlProperty(),
					'default'     => [ 'autoplay', 'arrows', 'dots', 'responsive', 'infinite' ],
				],
				'pfp_carousel_autoplay_timeout' => [
					'label'       => esc_html__( 'Autoplay timeout', 'tlp-portfolio' ),
					'holderClass' => 'pfp-hidden pfp-carousel-auto-play-timeout',
					'type'        => 'number',
					'default'     => 5000,
					'description' => esc_html__( 'Autoplay interval timeout', 'tlp-portfolio' ),
				],
				'pfp_desktop_column'            => [
					'type'    => 'select',
					'label'   => esc_html__( 'Desktop column', 'tlp-portfolio' ),
					'class'   => 'rt-select2',
					'default' => 3,
					'options' => $this->scColumns(),
				],
				'pfp_tab_column'                => [
					'type'    => 'select',
					'label'   => esc_html__( 'Tab column', 'tlp-portfolio' ),
					'class'   => 'rt-select2',
					'default' => 2,
					'options' => $this->scColumns(),
				],
				'pfp_mobile_column'             => [
					'type'    => 'select',
					'label'   => esc_html__( 'Mobile column', 'tlp-portfolio' ),
					'class'   => 'rt-select2',
					'default' => 1,
					'options' => $this->scColumns(),
				],
				'pfp_pagination'                => [
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Pagination', 'tlp-portfolio' ),
					'holderClass' => 'pagination',
					'optionLabel' => esc_html__( 'Enable', 'tlp-portfolio' ),
					'option'      => 1,
				],
				'pfp_posts_per_page'            => [
					'type'        => 'number',
					'label'       => esc_html__( 'Display per page', 'tlp-portfolio' ),
					'holderClass' => 'pfp-pagination-item pfp-hidden',
					'default'     => 5,
					'description' => esc_html__(
						'If value of Limit setting is not blank (empty), this value should be smaller than Limit value.',
						'tlp-portfolio'
					),
				],
				'pfp_image_size'                => [
					'type'    => 'select',
					'label'   => esc_html__( 'Image Size', 'tlp-portfolio' ),
					'class'   => 'rt-select2',
					'options' => TLPPortfolio()->get_image_sizes(),
				],
				'pfp_custom_image_size'         => [
					'type'        => 'image_size',
					'label'       => esc_html__( 'Custom Image Size', 'tlp-portfolio' ),
					'holderClass' => 'pfp-hidden',
					'description' => __( 'We prefer to upload image larger than your custom image size. <span style="margin-top: 5px; display: block; color: #9A2A2A; font-weight: 400;">Please note that, if you enter image size larger than the actual image iteself, the image sizes will fallback to the full size image.</span>', 'tlp-portfolio' ),
				],
				'pfp_disable_image'             => [
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Disable image', 'tlp-portfolio' ),
					'option'      => 1,
					'optionLabel' => esc_html__( 'Disable', 'tlp-portfolio' ),
				],
				'pfp_excerpt_limit'             => [
					'type'        => 'number',
					'label'       => esc_html__( 'Short description limit', 'tlp-portfolio' ),
					'description' => esc_html__(
						'Short description limit only integer number is allowed, Leave it blank for full text.',
						'tlp-portfolio'
					),
				],
				'pfp_detail_page_link'          => [
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Detail page link', 'tlp-portfolio' ),
					'optionLabel' => esc_html__( 'Enable', 'tlp-portfolio' ),
					'default'     => 1,
					'option'      => 1,
				],
				'pfp_detail_page_link_type'     => [
					'type'        => 'radio',
					'label'       => esc_html__( 'Detail page link type', 'tlp-portfolio' ),
					'default'     => 'inner_link',
					'holderClass' => 'pfp_detail_page_link_type pfp-hidden pfp-detail-page-link-item',
					'alignment'   => 'vertical',
					'options'     => [
						'inner_link'    => 'Inner Link',
						'external_link' => 'External Link',
					],
				],
				'pfp_link_target'               => [
					'type'        => 'radio',
					'label'       => esc_html__( 'Link Target', 'tlp-portfolio' ),
					'default'     => '_blank',
					'holderClass' => 'pfp_link_target pfp-hidden pfp-detail-page-link-item',
					'alignment'   => 'vertical',
					'options'     => [
						'_self'  => 'Same Window',
						'_blank' => 'New Window',
					],
				],
			];
		}

		public function scFilterMetaFields() {
			return [
				'pfp_post__in'          => [
					'label'       => esc_html__( 'Include only', 'tlp-portfolio' ),
					'type'        => 'text',
					'description' => esc_html__(
						'List of post IDs to show (comma-separated values, for example: 1,2,3)',
						'tlp-portfolio'
					),
				],
				'pfp_post__not_in'      => [
					'label'       => esc_html__( 'Exclude', 'tlp-portfolio' ),
					'type'        => 'text',
					'description' => esc_html__(
						'List of post IDs to show (comma-separated values, for example: 1,2,3)',
						'tlp-portfolio'
					),
				],
				'pfp_limit'             => [
					'label'       => esc_html__( 'Limit', 'tlp-portfolio' ),
					'type'        => 'number',
					'description' => esc_html__(
						'The number of posts to show. Set empty to show all found posts.',
						'tlp-portfolio'
					),
				],
				'pfp_categories'        => [
					'label'       => esc_html__( 'Categories', 'tlp-portfolio' ),
					'type'        => 'select',
					'class'       => 'rt-select2',
					'multiple'    => true,
					'description' => esc_html__(
						'Select the category you want to filter, Leave it blank for All category',
						'tlp-portfolio'
					),
					'options'     => TLPPortfolio()->getAllPortFolioCategoryList(),
				],
				'pfp_tags'              => [
					'label'       => esc_html__( 'Tags', 'tlp-portfolio' ),
					'type'        => 'select',
					'class'       => 'rt-select2',
					'multiple'    => true,
					'description' => esc_html__(
						'Select the category you want to filter, Leave it blank for All category',
						'tlp-portfolio'
					),
					'options'     => TLPPortfolio()->getAllPortFolioTagList(),
				],
				'pfp_taxonomy_relation' => [
					'label'       => esc_html__( 'Taxonomy relation', 'tlp-portfolio' ),
					'type'        => 'select',
					'class'       => 'rt-select2',
					'description' => esc_html__(
						'Select this option if you select more than one taxonomy like category and tag, or category , tag and tools',
						'tlp-portfolio'
					),
					'options'     => $this->scTaxonomyRelation(),
				],
				'pfp_order_by'          => [
					'label'   => esc_html__( 'Order By', 'tlp-portfolio' ),
					'type'    => 'select',
					'class'   => 'rt-select2',
					'default' => 'date',
					'options' => $this->scOrderBy(),
				],
				'pfp_order'             => [
					'label'     => esc_html__( 'Order', 'tlp-portfolio' ),
					'type'      => 'radio',
					'options'   => $this->scOrder(),
					'default'   => 'DESC',
					'alignment' => 'vertical',
				],
			];
		}

		public function field() {
			return [
				'name'              => 'Name',
				'short_description' => 'Short description',
				'client_name'       => 'Client Name',
				'project_url'       => 'Project Url',
				'completed_date'    => 'Completed Date',
				'tools'             => 'Tools',
				'categories'        => 'Categories',
				'zoom_image'        => 'Zoom Image',
			];
		}

		public function scItemDefaultMetaFields() {
			return [
				'name'              => 'Name',
				'short_description' => 'Short description',
				'zoom_image'        => 'Zoom Image',
			];
		}

		public function scItemMetaFields() {
			return [
				'pfp_item_fields' => [
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Field selection', 'tlp-portfolio' ),
					'multiple'    => true,
					'alignment'   => 'vertical',
					'default'     => array_keys( $this->scItemDefaultMetaFields() ),
					'options'     => $this->field(),
					'description' => esc_html__( 'Check the field which you want to display', 'tlp-portfolio' ),
				],
			];
		}

		public function scStyleFields() {
			return [
				'pfp_parent_class'            => [
					'type'        => 'text',
					'label'       => esc_html__( 'Parent class', 'tlp-portfolio' ),
					'class'       => 'medium-text',
					'description' => esc_html__( 'Parent class for adding custom css', 'tlp-portfolio' ),
				],
				'pfp_primary_color'           => [
					'type'  => 'colorpicker',
					'label' => esc_html__( 'Primary Color', 'tlp-portfolio' ),
					'alpha' => true,
				],
				'pfp_overlay_color'           => [
					'type'  => 'colorpicker',
					'label' => esc_html__( 'Overlay color', 'tlp-portfolio' ),
					'alpha' => true,
				],
				'pfp_button_bg_color'         => [
					'type'  => 'colorpicker',
					'label' => esc_html__( 'Button background color', 'tlp-portfolio' ),
				],
				'pfp_button_hover_bg_color'   => [
					'type'  => 'colorpicker',
					'label' => esc_html__( 'Button hover background color', 'tlp-portfolio' ),
				],
				'pfp_button_active_bg_color'  => [
					'type'  => 'colorpicker',
					'label' => esc_html__( 'Button active background color', 'tlp-portfolio' ),
				],
				'pfp_button_text_color'       => [
					'type'  => 'colorpicker',
					'label' => esc_html__( 'Button text color', 'tlp-portfolio' ),
				],
				'pfp_gutter'                  => [
					'type'        => 'number',
					'label'       => esc_html__( 'Padding', 'tlp-portfolio' ),
					'description' => __( 'Unit will be pixel, No need to give any unit. Only integer value will be valid.<br> Leave it blank for default', 'tlp-portfolio' ),
				],
				'pfp_name_style'              => [
					'type'  => 'style',
					'label' => esc_html__( 'Name / Title', 'tlp-portfolio' ),
				],
				'pfp_name_hover_style'        => [
					'type'  => 'style',
					'label' => esc_html__( 'Name Hover', 'tlp-portfolio' ),
				],
				'pfp_short_description_style' => [
					'type'  => 'style',
					'label' => esc_html__( 'Short description', 'tlp-portfolio' ),
				],
				'pfp_icon_style'              => [
					'type'  => 'style',
					'label' => esc_html__( 'Icon style', 'tlp-portfolio' ),
				],
				'pfp_meta_style'              => [
					'type'  => 'style',
					'label' => esc_html__( 'Meta style', 'tlp-portfolio' ),
				],
			];
		}

		public function imageCropType() {
			return [
				'soft' => esc_html__( 'Soft Crop', 'tlp-portfolio' ),
				'hard' => esc_html__( 'Hard Crop', 'tlp-portfolio' ),
			];
		}

		public function scTaxonomyRelation() {
			return [
				'OR'  => 'OR Relation',
				'AND' => 'AND Relation',
			];
		}

		public function socialLink() {
			return [
				'facebook' => 'Facebook',
				'twitter'  => 'Twitter',
				'linkedin' => 'LinkedIn',
			];
		}

		public function scColumns() {
			return [
				1 => '1 Column',
				2 => '2 Column',
				3 => '3 Column',
				4 => '4 Column',
				5 => '5 Column',
				6 => '6 Column',
			];
		}


		public function scLayouts() {
			global $TLPportfolio;

			$layout_root_url = 'https://www.radiustheme.com/demo/plugins/portfolio/';

			return [
				'layout1'   => [
					'title'   => 'Layout 1',
					'layout'  => 'grid',
					// 'demoUrl' => esc_url( $layout_root_url . 'portfolio-layout-1/' ),
					'img'     => $TLPportfolio->assetsUrl . 'images/layout/layout1.png',
				],
				'layout2'   => [
					'title'   => 'Layout 2',
					'layout'  => 'grid',
					// 'demoUrl' => esc_url( $layout_root_url . 'portfolio-layout-2/' ),
					'img'     => $TLPportfolio->assetsUrl . 'images/layout/layout2.png',
				],
				'layout3'   => [
					'title'   => 'Layout 3',
					'layout'  => 'grid',
					// 'demoUrl' => esc_url( $layout_root_url . 'portfolio-layout-3/' ),
					'img'     => $TLPportfolio->assetsUrl . 'images/layout/layout3.png',
				],

				'isotope1'  => [
					'title'   => 'Isotope Layout 1',
					'layout'  => 'isotope',
					// 'demoUrl' => esc_url( $layout_root_url . 'isotope-layout/' ),
					'img'     => $TLPportfolio->assetsUrl . 'images/layout/isotope1.png',
				],
				// isotope2 layout similar like  isotope3 Pro.
				'isotope2'  => [
					'title'   => 'Isotope Layout 2',
					'layout'  => 'isotope',
					// 'demoUrl' => esc_url( $layout_root_url . 'isotope-layout-2/' ),
					'img'     => $TLPportfolio->assetsUrl . 'images/layout/isotope2.png',
				],
				'isotope3'  => [
					'title'   => 'Isotope Layout 3',
					'layout'  => 'isotope',
					// 'demoUrl' => esc_url( $layout_root_url . 'isotope-layout-3/' ),
					'img'     => $TLPportfolio->assetsUrl . 'images/layout/isotope3.png',
				],
				'carousel1' => [
					'title'   => 'Carousel Layout 1',
					'layout'  => 'carousel',
					// 'demoUrl' => esc_url( $layout_root_url . 'carousel-layout-1/' ),
					'img'     => $TLPportfolio->assetsUrl . 'images/layout/carousel1.png',
				],

				'carousel2' => [
					'title'   => 'Carousel Layout 2',
					'layout'  => 'carousel',
					// 'demoUrl' => esc_url( $layout_root_url . 'carousel-layout-2/' ),
					'img'     => $TLPportfolio->assetsUrl . 'images/layout/carousel2.png',
				],

				'carousel3' => [
					'title'   => 'Carousel Layout 3',
					'layout'  => 'carousel',
					// 'demoUrl' => esc_url( $layout_root_url . 'carousel-layout-3/' ),
					'img'     => $TLPportfolio->assetsUrl . 'images/layout/carousel3.png',
				],
			];
		}

		public function owlProperty() {
			return [
				'loop'               => esc_html__( 'Loop', 'tlp-portfolio' ),
				'autoplay'           => esc_html__( 'Auto Play', 'tlp-portfolio' ),
				'autoplayHoverPause' => esc_html__( 'Pause on mouse hover', 'tlp-portfolio' ),
				'nav'                => esc_html__( 'Nav Button', 'tlp-portfolio' ),
				'dots'               => esc_html__( 'Pagination', 'tlp-portfolio' ),
				'auto_height'        => esc_html__( 'Auto Height', 'tlp-portfolio' ),
				'lazy_load'          => esc_html__( 'Lazy Load', 'tlp-portfolio' ),
				'rtl'                => esc_html__( 'Right to left (RTL)', 'tlp-portfolio' ),
			];
		}

		public function oldScLayouts() {
			return [
				1           => 'Layout 1',
				2           => 'Layout 2',
				3           => 'Layout 3',
				// 'layout4'  => 'Layout 4', // Next layout format
				'isotope'   => 'Isotope Layout 1',
				'isotope2'  => 'Isotope Layout 2',
				'isotope3'  => 'Isotope Layout 3',
				'carousel1' => 'Carousel Slider 1',
				'carousel2' => 'Carousel Slider 2',
				'carousel3' => 'Carousel Slider 3',
			];
		}

		public function scOrderBy() {
			return [
				'menu_order' => 'Menu Order',
				'title'      => 'Name',
				'ID'         => 'ID',
				'date'       => 'Date',
			];
		}

		public function scOrder() {
			return [
				'ASC'  => 'Ascending',
				'DESC' => 'Descending',
			];
		}

		public function owl_property() {
			return [
				'auto_play'   => esc_html__( 'Auto Play', 'tlp-portfolio' ),
				'navigation'  => esc_html__( 'Navigation', 'tlp-portfolio' ),
				'pagination'  => esc_html__( 'Pagination', 'tlp-portfolio' ),
				'stop_hover'  => esc_html__( 'Stop Hover', 'tlp-portfolio' ),
				'responsive'  => esc_html__( 'Responsive', 'tlp-portfolio' ),
				'auto_height' => esc_html__( 'Auto Height', 'tlp-portfolio' ),
				'lazy_load'   => esc_html__( 'Lazy Load', 'tlp-portfolio' ),
			];
		}

		public function scFontSize() {
			$num = [];
			for ( $i = 10; $i <= 50; $i ++ ) {
				$num[ $i ] = $i . 'px';
			}

			return $num;
		}

		public function scAlignment() {
			return [
				'left'    => 'Left',
				'right'   => 'Right',
				'center'  => 'Center',
				'justify' => 'Justify',
			];
		}

		public function scTextWeight() {
			return [
				'normal'  => 'Normal',
				'bold'    => 'Bold',
				'bolder'  => 'Bolder',
				'lighter' => 'Lighter',
				'inherit' => 'Inherit',
				'initial' => 'Initial',
				'unset'   => 'Unset',
				100       => '100',
				200       => '200',
				300       => '300',
				400       => '400',
				500       => '500',
				600       => '600',
				700       => '700',
				800       => '800',
				900       => '900',
			];
		}

		private function isotope_filter_taxonomy() {
			return apply_filters( 'tlp_portfolio_isotope_filter_taxonomy', array_flip( TLPPortfolio()->taxonomies ) );
		}
	}
endif;
