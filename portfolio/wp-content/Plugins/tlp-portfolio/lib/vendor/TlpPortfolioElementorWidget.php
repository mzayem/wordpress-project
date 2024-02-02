<?php
/**
 * Elementor Widget class.
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Elementor Widget class.
 */
class TlpPortfolioElementorWidget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'tlp-portfolio';
	}

	public function get_title() {
		return esc_html__( 'Tlp Portfolio', 'tlp-portfolio' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}
	public function get_script_depends() {
		return [ 'tlp-owl-carousel', 'tlp-isotope', 'tlp-portfolio' ];
	}
	public function get_style_depends() {
		return [ 'tlp-owl-carousel', 'tlp-owl-carousel-theme', 'tlp-portfolio' ];
	}
	public function get_categories() {
		return [ 'general' ];
	}

	protected function register_controls() {
		global $TLPportfolio;

		$this->start_controls_section(
			'setting_section',
			[
				'label' => esc_html__( 'Settings', 'tlp-portfolio' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'layout',
			[
				'type'    => \Elementor\Controls_Manager::SELECT2,
				'id'      => 'layout',
				'label'   => esc_html__( 'Layout', 'tlp-portfolio' ),
				'options' => $TLPportfolio->oldScLayouts(),
				'default' => 1,
			]
		);
		$this->add_control(
			'col',
			[
				'type'    => \Elementor\Controls_Manager::SELECT2,
				'id'      => 'col',
				'label'   => esc_html__( 'Desktop Column', 'tlp-portfolio' ),
				'options' => $TLPportfolio->scColumns(),
				'default' => 3,
			]
		);
		$this->add_control(
			'col_tabcolumn',
			[
				'type'    => \Elementor\Controls_Manager::SELECT2,
				'id'      => 'col_tabcolumn',
				'label'   => esc_html__( 'Tablet Column', 'tlp-portfolio' ),
				'options' => $TLPportfolio->scColumns(),
				'default' => 2,
			]
		);
		$this->add_control(
			'col_mobilecolumn',
			[
				'type'      => \Elementor\Controls_Manager::SELECT2,
				'id'        => 'col_mobilecolumn',
				'label'     => esc_html__( 'Mobile Column', 'tlp-portfolio' ),
				'options'   => $TLPportfolio->scColumns(),
				'default'   => 1,
				'condition' => [ 'layout!' => [ '2' ] ],
			]
		);
		$this->add_control(
			'orderby',
			[
				'type'    => \Elementor\Controls_Manager::SELECT2,
				'id'      => 'orderby',
				'label'   => esc_html__( 'Order By', 'tlp-portfolio' ),
				'options' => $TLPportfolio->scOrderBy(),
			]
		);
		$this->add_control(
			'order',
			[
				'type'    => \Elementor\Controls_Manager::SELECT2,
				'id'      => 'order',
				'label'   => esc_html__( 'Order', 'tlp-portfolio' ),
				'options' => $TLPportfolio->scOrder(),
			]
		);
		$this->add_control(
			'pagination',
			[
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Pagination', 'tlp-portfolio' ),
				'label_on'    => esc_html__( 'On', 'tlp-portfolio' ),
				'label_off'   => esc_html__( 'Off', 'tlp-portfolio' ),
				'default'     => '',
				'description' => esc_html__( 'Loop to first item. Default: On', 'tlp-portfolio' ),
				'condition'   => [ 'layout!' => [ 'carousel1' ] ],
			]
		);
		$this->add_control(
			'number',
			[
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'id'        => 'number',
				'label'     => esc_html__( 'Display Per Page Number', 'tlp-portfolio' ),
				'step'      => 1,
				'default'   => '',
				'condition' => [ 'pagination' => [ 'yes' ] ],
			]
		);
		$this->add_control(
			'details_page_link',
			[
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Details page link', 'tlp-portfolio' ),
				'label_on'    => esc_html__( 'On', 'tlp-portfolio' ),
				'label_off'   => esc_html__( 'Off', 'tlp-portfolio' ),
				'default'     => '',
				'description' => esc_html__( 'Display Project Url.', 'tlp-portfolio' ),
			]
		);

		$this->add_control(
			'link_type',
			[
				'label'     => esc_html__( 'Detail page link type', 'tlp-portfolio' ),
				'type'      => \Elementor\Controls_Manager::SELECT2,
				'multiple'  => false,
				'options'   => [
					'inner_link'    => esc_html__( 'Inner link', 'tlp-portfolio' ),
					'external_link' => esc_html__( 'External link', 'tlp-portfolio' ),
				],
				'default'   => 'inner_link',
				'condition' => [ 'details_page_link' => [ 'yes' ] ],
			]
		);

		$this->add_control(
			'link_target',
			[
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Link Open in new window', 'tlp-portfolio' ),
				'label_on'    => esc_html__( 'Yes', 'tlp-portfolio' ),
				'label_off'   => esc_html__( 'No', 'tlp-portfolio' ),
				'default'     => '',
				'description' => esc_html__( 'Loop to first item. Default: On', 'tlp-portfolio' ),
				'condition'   => [ 'details_page_link' => [ 'yes' ] ],
			]
		);

		$this->add_control(
			'cat',
			[
				'type'     => \Elementor\Controls_Manager::SELECT2,
				'id'       => 'cat',
				'label'    => esc_html__( 'Category', 'tlp-portfolio' ),
				'options'  => $TLPportfolio->getAllPortFolioCategoryList(),
				'multiple' => true,
			]
		);
		$this->add_control(
			'image',
			[
				'label'        => esc_html__( 'Hide Image', 'tlp-portfolio' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Hide', 'tlp-portfolio' ),
				'label_off'    => esc_html__( 'Show', 'tlp-portfolio' ),
				'return_value' => 'false',
			]
		);
		$this->add_control(
			'letter-limit',
			[
				'label'       => esc_html__( 'Short description limit', 'tlp-portfolio' ),
				'description' => esc_html__( 'Leave it blank to default 100 letter', 'tlp-portfolio' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'step'        => 1,
				'default'     => '',
			]
		);
		$this->add_control(
			'class',
			[
				'label' => esc_html__( 'Wrapper Class', 'tlp-portfolio' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_image',
			[
				'label'     => esc_html__( 'Image', 'tlp-portfolio' ),
				'condition' => [
					'image!' => 'false',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'large',
				'separator' => 'none',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_carousel',
			[
				'label'     => esc_html__( 'Carousel Settings', 'tlp-portfolio' ),
				'condition' => [
					'layout' => [ 'carousel1', 'carousel2', 'carousel3' ],
				],
			]
		);

		$this->add_control(
			'slider_autoplay',
			[
				'label'        => esc_html__( 'Autoplay', 'tlp-portfolio' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tlp-portfolio' ),
				'label_off'    => esc_html__( 'Hide', 'tlp-portfolio' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'slider_stop_on_hover',
			[
				'label'        => esc_html__( 'Stop on Hover', 'tlp-portfolio' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'tlp-portfolio' ),
				'label_off'    => esc_html__( 'Off', 'tlp-portfolio' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'slider_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'slider_timeout',
			[
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'label'       => esc_html__( 'Autoplay Timeout', 'tlp-portfolio' ),
				'options'     => [
					'5000' => esc_html__( '5 Seconds', 'tlp-portfolio' ),
					'4000' => esc_html__( '4 Seconds', 'tlp-portfolio' ),
					'3000' => esc_html__( '3 Seconds', 'tlp-portfolio' ),
					'2000' => esc_html__( '2 Seconds', 'tlp-portfolio' ),
					'1000' => esc_html__( '1 Second', 'tlp-portfolio' ),
				],
				'default'     => '5000',
				'description' => esc_html__( 'Set any value for example 5 seconds to play it in every 5 seconds. Default: 5 Seconds', 'tlp-portfolio' ),
				'condition'   => [ 'slider_autoplay' => 'yes' ],
			]
		);
		$this->add_control(
			'slider_autoplay_speed',
			[
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'label'       => esc_html__( 'Autoplay Slide Speed', 'tlp-portfolio' ),
				'default'     => 200,
				'description' => esc_html__( 'Slide speed in milliseconds. Default: 200', 'tlp-portfolio' ),
				'condition'   => [ 'slider_autoplay' => 'yes' ],
			]
		);
		$this->add_control(
			'slider_loop',
			[
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Loop', 'tlp-portfolio' ),
				'label_on'    => esc_html__( 'On', 'tlp-portfolio' ),
				'label_off'   => esc_html__( 'Off', 'tlp-portfolio' ),
				'default'     => 'yes',
				'description' => esc_html__( 'Loop to first item. Default: On', 'tlp-portfolio' ),
			]
		);
		$this->add_control(
			'slider_nav',
			[
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Nav', 'tlp-portfolio' ),
				'label_on'    => esc_html__( 'On', 'tlp-portfolio' ),
				'label_off'   => esc_html__( 'Off', 'tlp-portfolio' ),
				'default'     => 'yes',
				'description' => esc_html__( 'Loop to first item. Default: On', 'tlp-portfolio' ),
			]
		);
		$this->add_control(
			'slider_dots',
			[
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Dots', 'tlp-portfolio' ),
				'label_on'    => esc_html__( 'On', 'tlp-portfolio' ),
				'label_off'   => esc_html__( 'Off', 'tlp-portfolio' ),
				'default'     => 'yes',
				'description' => esc_html__( 'Loop to first item. Default: On', 'tlp-portfolio' ),
			]
		);

		$this->add_control(
			'slider_lazyload',
			[
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Lazyload', 'tlp-portfolio' ),
				'label_on'    => esc_html__( 'On', 'tlp-portfolio' ),
				'label_off'   => esc_html__( 'Off', 'tlp-portfolio' ),
				'default'     => 'yes',
				'description' => esc_html__( 'Loop to first item. Default: On', 'tlp-portfolio' ),
			]
		);
		$this->add_control(
			'slider_autoheight',
			[
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Auto Height', 'tlp-portfolio' ),
				'label_on'    => esc_html__( 'On', 'tlp-portfolio' ),
				'label_off'   => esc_html__( 'Off', 'tlp-portfolio' ),
				'default'     => 'yes',
				'description' => esc_html__( 'Loop to first item. Default: On', 'tlp-portfolio' ),
			]
		);
		$this->add_control(
			'slider_rtl',
			[
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'RTL', 'tlp-portfolio' ),
				'label_on'    => esc_html__( 'On', 'tlp-portfolio' ),
				'label_off'   => esc_html__( 'Off', 'tlp-portfolio' ),
				'default'     => '',
				'description' => esc_html__( 'Loop to first item. Default: On', 'tlp-portfolio' ),
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'advanced_style_section',
			[
				'label' => esc_html__( 'Advanced Style', 'tlp-portfolio' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label'     => esc_html__( 'Primary Color', 'tlp-portfolio' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tlp-portfolio .tlp-content' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'tlp-portfolio' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tlp-portfolio .tlp-overlay' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label'     => esc_html__( 'Button Background Color', 'tlp-portfolio' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tlp-portfolio-isotope-button button, {{WRAPPER}} .owl-theme .owl-nav [class*=owl-], {{WRAPPER}} .owl-theme .owl-dots .owl-dot span, {{WRAPPER}} .tlp-pagination li span, {{WRAPPER}} .tlp-pagination li a' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'button_hover_bg_color',
			[
				'label'     => esc_html__( 'Button Hover Background Color', 'tlp-portfolio' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tlp-portfolio-isotope-button button:hover, {{WRAPPER}} .owl-theme .owl-nav [class*=owl-]:hover, {{WRAPPER}} .tlp-pagination li span:hover, {{WRAPPER}} .tlp-pagination li a:hover, {{WRAPPER}} .owl-theme .owl-dots .owl-dot:hover span' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'button_active_bg_color',
			[
				'label'     => esc_html__( 'Button Active Color', 'tlp-portfolio' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tlp-portfolio-isotope-button button.selected, {{WRAPPER}} .owl-theme .owl-dots .owl-dot.active span, {{WRAPPER}} .tlp-pagination li.active span' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Button Text Color', 'tlp-portfolio' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tlp-portfolio-isotope-button button, {{WRAPPER}} .owl-theme .owl-nav [class*=owl-], {{WRAPPER}} .owl-theme .owl-dots .owl-dot span, {{WRAPPER}} .tlp-pagination li span, {{WRAPPER}} .tlp-pagination li a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Content Padding', 'tlp-portfolio' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}  .tlp-portfolio-item .tlp-content .tlp-content-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'gutter_padding',
			[
				'label'              => esc_html__( 'Gutter / Padding', 'tlp-portfolio' ),
				'type'               => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px', 'em', '%' ],
				'allowed_dimensions' => [ 'right', 'left' ],
				'selectors'          => [
					'{{WRAPPER}}  .tlp-portfolio-container .tlp-single-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_style_section',
			[
				'label' => esc_html__( 'Title Style', 'tlp-portfolio' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'title-color',
			[
				'label'     => esc_html__( 'Color', 'tlp-portfolio' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tlp-content-holder h3 a, {{WRAPPER}} .tlp-content-holder h3' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'title-font-size',
			[
				'label'     => esc_html__( 'Font size', 'tlp-portfolio' ),
				'type'      => \Elementor\Controls_Manager::SELECT2,
				'options'   => $TLPportfolio->scFontSize(),
				'selectors' => [
					'{{WRAPPER}} .tlp-content-holder h3' => 'font-size: {{VALUE}}px',
				],
			]
		);
		$this->add_control(
			'title-font-weight',
			[
				'label'     => esc_html__( 'Font weight', 'tlp-portfolio' ),
				'type'      => \Elementor\Controls_Manager::SELECT2,
				'options'   => $TLPportfolio->scTextWeight(),
				'selectors' => [
					'{{WRAPPER}} .tlp-content-holder h3' => 'font-weight: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'title-alignment',
			[
				'label'     => esc_html__( 'Alignment', 'tlp-portfolio' ),
				'type'      => \Elementor\Controls_Manager::SELECT2,
				'options'   => $TLPportfolio->scAlignment(),
				'selectors' => [
					'{{WRAPPER}} .tlp-content-holder h3' => 'text-align: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'title-margin',
			[
				'label'      => esc_html__( 'Margin', 'plugin-domain' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .tlp-portfolio .tlp-content h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'short_description_style_section',
			[
				'label' => esc_html__( 'Short Description Style', 'tlp-portfolio' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'short-desc-color',
			[
				'label'     => esc_html__( 'Color', 'tlp-portfolio' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tlp-portfolio .tlp-portfolio-sd' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'short-desc-font-size',
			[
				'label'     => esc_html__( 'Font size', 'tlp-portfolio' ),
				'type'      => \Elementor\Controls_Manager::SELECT2,
				'options'   => $TLPportfolio->scFontSize(),
				'selectors' => [
					'{{WRAPPER}} .tlp-portfolio .tlp-portfolio-sd' => 'font-size: {{VALUE}}px',
				],
			]
		);
		$this->add_control(
			'short-desc-font-weight',
			[
				'label'     => esc_html__( 'Font weight', 'tlp-portfolio' ),
				'type'      => \Elementor\Controls_Manager::SELECT2,
				'options'   => $TLPportfolio->scTextWeight(),
				'selectors' => [
					'{{WRAPPER}} .tlp-portfolio .tlp-portfolio-sd' => 'font-weight: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'short-desc-alignment',
			[
				'label'     => esc_html__( 'Alignment', 'tlp-portfolio' ),
				'type'      => \Elementor\Controls_Manager::SELECT2,
				'options'   => $TLPportfolio->scAlignment(),
				'selectors' => [
					'{{WRAPPER}} .tlp-portfolio .tlp-portfolio-sd' => 'text-align: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'short-desc-margin',
			[
				'label'      => esc_html__( 'Margin', 'plugin-domain' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .tlp-portfolio .tlp-portfolio-sd' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'meta_style_section',
			[
				'label' => esc_html__( 'Meta Style', 'tlp-portfolio' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'meta-color',
			[
				'label'     => esc_html__( 'Color', 'tlp-portfolio' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tlp-portfolio ul li' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'meta-font-size',
			[
				'label'     => esc_html__( 'Font size', 'tlp-portfolio' ),
				'type'      => \Elementor\Controls_Manager::SELECT2,
				'options'   => $TLPportfolio->scFontSize(),
				'selectors' => [
					'{{WRAPPER}} .tlp-portfolio ul li' => 'font-size: {{VALUE}}px',
				],
			]
		);

		$this->add_control(
			'meta-alignment',
			[
				'label'     => esc_html__( 'Alignment', 'tlp-portfolio' ),
				'type'      => \Elementor\Controls_Manager::SELECT2,
				'options'   => $TLPportfolio->scAlignment(),
				'selectors' => [
					'{{WRAPPER}} .tlp-portfolio ul li' => 'text-align: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'meta-margin',
			[
				'label'      => esc_html__( 'Margin', 'plugin-domain' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .tlp-portfolio ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'icon_style_section',
			[
				'label' => esc_html__( 'Icon Style', 'tlp-portfolio' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'icon_colors' );

		$this->start_controls_tab(
			'icon_colors_normal',
			[
				'label' => esc_html__( 'Normal', 'tlp-portfolio' ),
			]
		);

		$this->add_control(
			'icon_primary_color',
			[
				'label'     => esc_html__( 'Primary Color', 'tlp-portfolio' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .tlp-portfolio-item .tlp-overlay .link-icon a, {{WRAPPER}} .tlp-portfolio-item .link-icon a' => 'color: {{VALUE}};border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'icon_colors_hover',
			[
				'label' => esc_html__( 'Hover', 'tlp-portfolio' ),
			]
		);

		$this->add_control(
			'hover_primary_color',
			[
				'label'     => esc_html__( 'Primary Color', 'tlp-portfolio' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .tlp-portfolio-item .tlp-overlay .link-icon a:hover, {{WRAPPER}} .tlp-portfolio-item .link-icon a:hover' => 'color: {{VALUE}};border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tlp-portfolio' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tlp-portfolio-item .tlp-overlay .link-icon a, {{WRAPPER}} .tlp-portfolio-item .link-icon a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'field_selection',
			[
				'label' => esc_html__( 'Field Selection', 'tlp-portfolio' ),
			]
		);
		$this->add_control(
			'image_zoom',
			[
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Zoom Image', 'tlp-portfolio' ),
				'label_on'    => esc_html__( 'On', 'tlp-portfolio' ),
				'label_off'   => esc_html__( 'Off', 'tlp-portfolio' ),
				'default'     => 'yes',
				'description' => esc_html__( 'Display Name. Default: Yes', 'tlp-portfolio' ),

			]
		);
		$this->add_control(
			'name',
			[
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Name', 'tlp-portfolio' ),
				'label_on'    => esc_html__( 'On', 'tlp-portfolio' ),
				'label_off'   => esc_html__( 'Off', 'tlp-portfolio' ),
				'default'     => 'yes',
				'description' => esc_html__( 'Display Name. Default: Yes', 'tlp-portfolio' ),

			]
		);
		$this->add_control(
			'short_description',
			[
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Short description', 'tlp-portfolio' ),
				'label_on'    => esc_html__( 'On', 'tlp-portfolio' ),
				'label_off'   => esc_html__( 'Off', 'tlp-portfolio' ),
				'default'     => 'yes',
				'description' => esc_html__( 'Display Short Description. Default: Yes', 'tlp-portfolio' ),
				// 'condition'   => array( 'layout' => ['1', '2', '3', 'isotope'] )
			]
		);

		$this->add_control(
			'client_name',
			[
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Client Name', 'tlp-portfolio' ),
				'label_on'    => esc_html__( 'On', 'tlp-portfolio' ),
				'label_off'   => esc_html__( 'Off', 'tlp-portfolio' ),
				'default'     => '',
				'description' => esc_html__( 'Display Client Name.', 'tlp-portfolio' ),
			]
		);
		$this->add_control(
			'project_url',
			[
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Project Url', 'tlp-portfolio' ),
				'label_on'    => esc_html__( 'On', 'tlp-portfolio' ),
				'label_off'   => esc_html__( 'Off', 'tlp-portfolio' ),
				'default'     => '',
				'description' => esc_html__( 'Display Project Url.', 'tlp-portfolio' ),
			]
		);

		$this->add_control(
			'completed_date',
			[
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Completed Date', 'tlp-portfolio' ),
				'label_on'    => esc_html__( 'On', 'tlp-portfolio' ),
				'label_off'   => esc_html__( 'Off', 'tlp-portfolio' ),
				'default'     => '',
				'description' => esc_html__( 'Display Completed Date.', 'tlp-portfolio' ),
			]
		);
		$this->add_control(
			'categories',
			[
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Categories', 'tlp-portfolio' ),
				'label_on'    => esc_html__( 'On', 'tlp-portfolio' ),
				'label_off'   => esc_html__( 'Off', 'tlp-portfolio' ),
				'default'     => '',
				'description' => esc_html__( 'Display Categories.', 'tlp-portfolio' ),
			]
		);
		$this->add_control(
			'tools',
			[
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Tools', 'tlp-portfolio' ),
				'label_on'    => esc_html__( 'On', 'tlp-portfolio' ),
				'label_off'   => esc_html__( 'Off', 'tlp-portfolio' ),
				'default'     => '',
				'description' => esc_html__( 'Display tools.', 'tlp-portfolio' ),
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$shortcode = '[tlpportfolio';

		if ( isset( $settings['layout'] ) && ! empty( $settings['layout'] ) ) {
			$shortcode .= ' layout="' . $settings['layout'] . '"';
		}

		if ( isset( $settings['col'] ) && ! empty( $settings['col'] ) ) {
			$shortcode .= ' col="' . $settings['col'] . '"';
		}

		if ( isset( $settings['col_tabcolumn'] ) && ! empty( $settings['col_tabcolumn'] ) ) {
			$shortcode .= ' tablet_col="' . $settings['col_tabcolumn'] . '"';
		}

		if ( isset( $settings['col_mobilecolumn'] ) && ! empty( $settings['col_mobilecolumn'] ) ) {
			$shortcode .= ' mobile_col="' . $settings['col_mobilecolumn'] . '"';
		}

		if ( isset( $settings['orderby'] ) && ! empty( $settings['orderby'] ) ) {
			$shortcode .= ' orderby="' . $settings['orderby'] . '"';
		}

		if ( isset( $settings['order'] ) && ! empty( $settings['order'] ) ) {
			$shortcode .= ' order="' . $settings['order'] . '"';
		}

		if ( isset( $settings['number'] ) && ! empty( $settings['number'] ) ) {
			$shortcode .= ' number="' . $settings['number'] . '"';
		}

		if ( isset( $settings['pagination'] ) && ! empty( $settings['pagination'] ) ) {
			$shortcode .= ' pagination="' . $settings['pagination'] . '"';
		}

		if ( isset( $settings['details_page_link'] ) && ! empty( $settings['details_page_link'] ) ) {
			$shortcode .= ' enable_page_link="' . $settings['details_page_link'] . '"';
		}

		if ( isset( $settings['link_type'] ) && ! empty( $settings['link_type'] ) ) {
			$shortcode .= ' link_type="' . $settings['link_type'] . '"';
		}

		if ( isset( $settings['link_target'] ) && ! empty( $settings['link_target'] ) ) {
			$shortcode .= ' link_target="' . $settings['link_target'] . '"';
		}

		if ( isset( $settings['cat'] ) && ! empty( $settings['cat'] ) && is_array( $settings['cat'] ) ) {
			$shortcode .= ' cat="' . implode( ',', $settings['cat'] ) . '"';
		}

		if ( isset( $settings['image'] ) && ! empty( $settings['image'] ) ) {
			$shortcode .= ' image="false"';
		}

		if ( isset( $settings['image_size'] ) && ! empty( $settings['image_size'] ) ) {
			$shortcode .= ' image_size="' . $settings['image_size'] . '"';
		}

		if ( isset( $settings['image_custom_dimension'] ) && ! empty( $settings['image_custom_dimension'] ) ) {
			$shortcode .= ' image_custom_dimension=\'' . wp_json_encode( $settings['image_custom_dimension'] ) . '\'';
		}

		if ( isset( $settings['letter-limit'] ) && ! empty( $settings['letter-limit'] ) ) {
			$shortcode .= ' letter-limit="' . $settings['letter-limit'] . '"';
		}

		if ( isset( $settings['title-color'] ) && ! empty( $settings['title-color'] ) ) {
			$shortcode .= ' title-color="' . $settings['title-color'] . '"';
		}

		if ( isset( $settings['title-font-size'] ) && ! empty( $settings['title-font-size'] ) ) {
			$shortcode .= ' title-font-size="' . $settings['title-font-size'] . '"';
		}

		if ( isset( $settings['title-font-weight'] ) && ! empty( $settings['title-font-weight'] ) ) {
			$shortcode .= ' title-font-weight="' . $settings['title-font-weight'] . '"';
		}

		if ( isset( $settings['title-alignment'] ) && ! empty( $settings['title-alignment'] ) ) {
			$shortcode .= ' title-alignment="' . $settings['title-alignment'] . '"';
		}

		if ( isset( $settings['short-desc-color'] ) && ! empty( $settings['short-desc-color'] ) ) {
			$shortcode .= ' short-desc-color="' . $settings['short-desc-color'] . '"';
		}

		if ( isset( $settings['short-desc-font-size'] ) && ! empty( $settings['short-desc-font-size'] ) ) {
			$shortcode .= ' short-desc-font-size="' . $settings['short-desc-font-size'] . '"';
		}

		if ( isset( $settings['short-desc-font-weight'] ) && ! empty( $settings['short-desc-font-weight'] ) ) {
			$shortcode .= ' short-desc-font-weight="' . $settings['short-desc-font-weight'] . '"';
		}

		if ( isset( $settings['short-desc-alignment'] ) && ! empty( $settings['short-desc-alignment'] ) ) {
			$shortcode .= ' short-desc-alignment="' . $settings['short-desc-alignment'] . '"';
		}

		if ( isset( $settings['class'] ) && ! empty( $settings['class'] ) ) {
			$shortcode .= ' class="' . $settings['class'] . '"';
		}

		if ( isset( $settings['name'] ) && ! empty( $settings['name'] ) ) {
			$shortcode .= ' name="' . $settings['name'] . '"';
		}

		if ( isset( $settings['image_zoom'] ) && ! empty( $settings['image_zoom'] ) ) {
			$shortcode .= ' image_zoom="' . $settings['image_zoom'] . '"';
		}

		if ( isset( $settings['short_description'] ) && ! empty( $settings['short_description'] ) ) {
			$shortcode .= ' short_description="' . $settings['short_description'] . '"';
		}

		if ( isset( $settings['client_name'] ) && ! empty( $settings['client_name'] ) ) {
			$shortcode .= ' client_name="' . $settings['client_name'] . '"';
		}

		if ( isset( $settings['project_url'] ) && ! empty( $settings['project_url'] ) ) {
			$shortcode .= ' project_url="' . $settings['project_url'] . '"';
		}

		if ( isset( $settings['completed_date'] ) && ! empty( $settings['completed_date'] ) ) {
			$shortcode .= ' completed_date="' . $settings['completed_date'] . '"';
		}

		if ( isset( $settings['categories'] ) && ! empty( $settings['categories'] ) ) {
			$shortcode .= ' categories="' . $settings['categories'] . '"';
		}

		if ( isset( $settings['tools'] ) && ! empty( $settings['tools'] ) ) {
			$shortcode .= ' tools="' . $settings['tools'] . '"';
		}

		$elementor_settings = [];

		if ( isset( $settings['slider_autoplay'] ) && ! empty( $settings['slider_autoplay'] ) ) {
			$elementor_settings['autoplay'] = $settings['slider_autoplay'];
		}
		if
        ( isset( $settings['slider_stop_on_hover'] ) && ! empty( $settings['slider_stop_on_hover'] ) ) {
			$elementor_settings['stop_on_hover'] = $settings['slider_stop_on_hover'];
		}

		if ( isset( $settings['slider_timeout'] ) && ! empty( $settings['slider_timeout'] ) ) {
			$elementor_settings['timeout'] = $settings['slider_timeout'];
		}

		if ( isset( $settings['slider_autoplay_speed'] ) && ! empty( $settings['slider_autoplay_speed'] ) ) {
			$elementor_settings['autoplay_speed'] = $settings['slider_autoplay_speed'];
		}

		if ( isset( $settings['slider_loop'] ) && ! empty( $settings['slider_loop'] ) ) {
			$elementor_settings['loop'] = $settings['slider_loop'];
		}

		if ( isset( $settings['slider_nav'] ) && ! empty( $settings['slider_nav'] ) ) {
			$elementor_settings['nav'] = $settings['slider_nav'];
		}

		if ( isset( $settings['slider_dots'] ) && ! empty( $settings['slider_dots'] ) ) {
			$elementor_settings['dots'] = $settings['slider_dots'];
		}

		if ( isset( $settings['slider_lazyload'] ) && ! empty( $settings['slider_lazyload'] ) ) {
			$elementor_settings['lazyload'] = $settings['slider_lazyload'];
		}

		if ( isset( $settings['slider_autoheight'] ) && ! empty( $settings['slider_autoheight'] ) ) {
			$elementor_settings['autoheight'] = $settings['slider_autoheight'];
		}

		if ( isset( $settings['slider_rtl'] ) && ! empty( $settings['slider_rtl'] ) ) {
			$elementor_settings['rtl'] = $settings['slider_rtl'];
		}

		if ( ! empty( $elementor_settings ) ) {
			$shortcode .= ' slider_settings=\'' . wp_json_encode( $elementor_settings ) . '\'';
		}

		$shortcode .= ']';

		echo do_shortcode( $shortcode );
	}
}
