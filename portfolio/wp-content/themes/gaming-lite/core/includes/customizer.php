<?php

if ( class_exists("Kirki")){

	// LOGO

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'slider',
		'settings'    => 'gaming_lite_logo_resizer',
		'label'       => esc_html__( 'Adjust Your Logo Size ', 'gaming-lite' ),
		'section'     => 'title_tagline',
		'default'     => 70,
		'choices'     => [
			'min'  => 10,
			'max'  => 300,
			'step' => 10,
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'gaming_lite_enable_logo_text',
		'section'     => 'title_tagline',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Enable / Disable Site Title and Tagline', 'gaming-lite' ) . '</h3>',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'gaming_lite_display_header_title',
		'label'       => esc_html__( 'Site Title Enable / Disable Button', 'gaming-lite' ),
		'section'     => 'title_tagline',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'gaming-lite' ),
			'off' => esc_html__( 'Disable', 'gaming-lite' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'gaming_lite_display_header_text',
		'label'       => esc_html__( 'Tagline Enable / Disable Button', 'gaming-lite' ),
		'section'     => 'title_tagline',
		'default'     => false,
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'gaming-lite' ),
			'off' => esc_html__( 'Disable', 'gaming-lite' ),
		],
	] );

	//FONT STYLE TYPOGRAPHY

	Kirki::add_panel( 'gaming_lite_panel_id', array(
	    'priority'    => 10,
	    'title'       => esc_html__( 'Typography', 'gaming-lite' ),
	) );

	Kirki::add_section( 'gaming_lite_font_style_section', array(
		'title'      => esc_attr__( 'Typography Option',  'gaming-lite' ),
		'priority'   => 2,
		'capability' => 'edit_theme_options',
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'gaming_lite_all_headings_typography',
		'section'     => 'gaming_lite_font_style_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Heading Of All Sections',  'gaming-lite' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'global', array(
		'type'        => 'typography',
		'settings'    => 'gaming_lite_all_headings_typography',
		'label'       => esc_attr__( 'Heading Typography',  'gaming-lite' ),
		'description' => esc_attr__( 'Select the typography options for your heading.',  'gaming-lite' ),
		'help'        => esc_attr__( 'The typography options you set here will override the Body Typography options for all headers on your site (post titles, widget titles etc).',  'gaming-lite' ),
		'section'     => 'gaming_lite_font_style_section',
		'priority'    => 10,
		'default'     => array(
			'font-family'    => '',
			'variant'        => '',
		),
		'output' => array(
			array(
				'element' => array( 'h1','h2','h3','h4','h5','h6', ),
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'gaming_lite_body_content_typography',
		'section'     => 'gaming_lite_font_style_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Body Content',  'gaming-lite' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'global', array(
		'type'        => 'typography',
		'settings'    => 'gaming_lite_body_content_typography',
		'label'       => esc_attr__( 'Content Typography',  'gaming-lite' ),
		'description' => esc_attr__( 'Select the typography options for your content.',  'gaming-lite' ),
		'help'        => esc_attr__( 'The typography options you set here will override the Body Typography options for all headers on your site (post titles, widget titles etc).',  'gaming-lite' ),
		'section'     => 'gaming_lite_font_style_section',
		'priority'    => 10,
		'default'     => array(
			'font-family'    => '',
			'variant'        => '',
		),
		'output' => array(
			array(
				'element' => array( 'body', ),
			),
		),
	) );

	// PANEL

	Kirki::add_panel( 'gaming_lite_panel_id', array(
	    'priority'    => 10,
	    'title'       => esc_html__( 'Theme Options', 'gaming-lite' ),
	) );

	// Color

	Kirki::add_section( 'gaming_lite_section_color', array(
	    'title'          => esc_html__( 'Global Color', 'gaming-lite' ),
	    'description'    => esc_html__( 'Theme Color Settings', 'gaming-lite' ),
	    'panel'          => 'gaming_lite_panel_id',
	    'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'gaming_lite_global_colors',
		'section'     => 'gaming_lite_section_color',
		'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Here you can change your theme color on one click.', 'gaming-lite' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'color',
		'settings'    => 'gaming_lite_global_color',
		'label'       => __( 'Choose Your First Color', 'gaming-lite' ),
		'section'     => 'gaming_lite_section_color',
		'default'     => '#fd7900',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'color',
		'settings'    => 'gaming_lite_global_color_2',
		'label'       => __( 'Choose Your Second Color', 'gaming-lite' ),
		'section'     => 'gaming_lite_section_color',
		'default'     => '#090913',
	] );

	// Additional Settings

	Kirki::add_section( 'gaming_lite_Additional_settings', array(
	    'title'          => esc_html__( 'Additional Settings', 'gaming-lite' ),
	    'description'    => esc_html__( 'Scroll To Top', 'gaming-lite' ),
	    'panel'          => 'gaming_lite_panel_id',
	    'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'gaming_lite_scroll_enable_setting',
		'label'       => esc_html__( 'Here you can enable or disable your scroller.', 'gaming-lite' ),
		'section'     => 'gaming_lite_Additional_settings',
		'default'     => '1',
		'priority'    => 10,
	] );

	new \Kirki\Field\Select(
	[
		'settings'    => 'menu_text_transform_gaming_lite',
		'label'       => esc_html__( 'Menus Text Transform', 'gaming-lite' ),
		'section'     => 'gaming_lite_Additional_settings',
		'default'     => 'CAPITALISE',
		'placeholder' => esc_html__( 'Choose an option', 'gaming-lite' ),
		'choices'     => [
			'CAPITALISE' => esc_html__( 'CAPITALISE', 'gaming-lite' ),
			'UPPERCASE' => esc_html__( 'UPPERCASE', 'gaming-lite' ),
			'LOWERCASE' => esc_html__( 'LOWERCASE', 'gaming-lite' ),

		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'slider',
		'settings'    => 'gaming_lite_container_width',
		'label'       => esc_html__( 'Theme Container Width', 'gaming-lite' ),
		'section'     => 'gaming_lite_Additional_settings',
		'default'     => 100,
		'choices'     => [
			'min'  => 50,
			'max'  => 100,
			'step' => 1,
		],
	] );

	// Woocommerce Settings

	Kirki::add_section( 'gaming_lite_woocommerce_settings', array(
			'title'          => esc_html__( 'Woocommerce Settings', 'gaming-lite' ),
			'description'    => esc_html__( 'Shop Page', 'gaming-lite' ),
			'panel'          => 'gaming_lite_panel_id',
			'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'gaming_lite_shop_sidebar',
		'label'       => esc_html__( 'Here you can enable or disable shop page sidebar.', 'gaming-lite' ),
		'section'     => 'gaming_lite_woocommerce_settings',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'gaming_lite_product_sidebar',
		'label'       => esc_html__( 'Here you can enable or disable product page sidebar.', 'gaming-lite' ),
		'section'     => 'gaming_lite_woocommerce_settings',
		'default'     => '1',
		'priority'    => 10,
	] );


	// POST SECTION

	Kirki::add_section( 'gaming_lite_section_post', array(
	    'title'          => esc_html__( 'Post Settings', 'gaming-lite' ),
	    'description'    => esc_html__( 'Here you can get different post settings', 'gaming-lite' ),
	    'panel'          => 'gaming_lite_panel_id',
	    'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'gaming_lite_enable_post_heading',
		'section'     => 'gaming_lite_section_post',
		'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Enable / Disable Post Settings.', 'gaming-lite' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'gaming_lite_blog_admin_enable',
		'label'       => esc_html__( 'Post Author Enable / Disable Button', 'gaming-lite' ),
		'section'     => 'gaming_lite_section_post',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'gaming-lite' ),
			'off' => esc_html__( 'Disable', 'gaming-lite' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'gaming_lite_blog_comment_enable',
		'label'       => esc_html__( 'Post Comment Enable / Disable Button', 'gaming-lite' ),
		'section'     => 'gaming_lite_section_post',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'gaming-lite' ),
			'off' => esc_html__( 'Disable', 'gaming-lite' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'slider',
		'settings'    => 'gaming_lite_post_excerpt_number',
		'label'       => esc_html__( 'Post Content Range', 'gaming-lite' ),
		'section'     => 'gaming_lite_section_post',
		'default'     => 15,
		'choices'     => [
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		],
	] );

	// HEADER SECTION

	Kirki::add_section( 'gaming_lite_section_header', array(
	    'title'          => esc_html__( 'Header Settings', 'gaming-lite' ),
	    'description'    => esc_html__( 'Here you can add header information.', 'gaming-lite' ),
	    'panel'          => 'gaming_lite_panel_id',
	    'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'gaming_lite_header_announcement_text_heading',
		'section'     => 'gaming_lite_section_header',
		'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Announcement Text', 'gaming-lite' ) . '</h3>',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'gaming_lite_header_announcement_text',
		'section'  => 'gaming_lite_section_header',
		'default'  => '',
		'priority' => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'gaming_lite_enable_socail_link',
		'section'     => 'gaming_lite_section_header',
		'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Social Media Link', 'gaming-lite' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'repeater',
		'section'     => 'gaming_lite_section_header',
		'priority'    => 10,
		'row_label' => [
			'type'  => 'field',
			'value' => esc_html__( 'Social Icon', 'gaming-lite' ),
			'field' => 'link_text',
		],
		'button_label' => esc_html__('Add New Social Icon', 'gaming-lite' ),
		'settings'     => 'gaming_lite_social_links_settings',
		'default'      => '',
		'fields' 	   => [
			'link_text' => [
				'type'        => 'text',
				'label'       => esc_html__( 'Icon', 'gaming-lite' ),
				'description' => esc_html__( 'Add the fontawesome class ex: "fab fa-facebook-f".', 'gaming-lite' ),
				'default'     => '',
			],
			'link_url' => [
				'type'        => 'url',
				'label'       => esc_html__( 'Social Link', 'gaming-lite' ),
				'description' => esc_html__( 'Add the social icon url here.', 'gaming-lite' ),
				'default'     => '',
			],
		],
		'choices' => [
			'limit' => 5
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'gaming_lite_header_sign_button_heading',
		'section'     => 'gaming_lite_section_header',
		'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Header Button', 'gaming-lite' ) . '</h3>',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'label'       => esc_html__( 'Sign Up Text', 'gaming-lite' ),
		'settings' => 'gaming_lite_sign_up_text',
		'section'  => 'gaming_lite_section_header',
		'default'  => '',
		'priority' => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'     => 'url',
		'label'       => esc_html__( 'Sign Up URL', 'gaming-lite' ),
		'settings' => 'gaming_lite_sign_up_url',
		'section'  => 'gaming_lite_section_header',
		'default'  => '',
		'priority' => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'label'       => esc_html__( 'Sign In Text', 'gaming-lite' ),
		'settings' => 'gaming_lite_sign_in_text',
		'section'  => 'gaming_lite_section_header',
		'default'  => '',
		'priority' => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'     => 'url',
		'label'       => esc_html__( 'Sign In URL', 'gaming-lite' ),
		'settings' => 'gaming_lite_sign_in_url',
		'section'  => 'gaming_lite_section_header',
		'default'  => '',
		'priority' => 10,
	] );

	// SLIDER SECTION

	Kirki::add_section( 'gaming_lite_blog_slide_section', array(
        'title'          => esc_html__( ' Slider Settings', 'gaming-lite' ),
        'description'    => esc_html__( 'You have to select post category to show slider.', 'gaming-lite' ),
        'panel'          => 'gaming_lite_panel_id',
        'priority'       => 160,
    ) );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'gaming_lite_enable_heading',
		'section'     => 'gaming_lite_blog_slide_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Enable / Disable Slider', 'gaming-lite' ) . '</h3>',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'gaming_lite_blog_box_enable',
		'label'       => esc_html__( 'Section Enable / Disable', 'gaming-lite' ),
		'section'     => 'gaming_lite_blog_slide_section',
		'default'     => '0',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'gaming-lite' ),
			'off' => esc_html__( 'Disable', 'gaming-lite' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'gaming_lite_title_unable_disable',
		'label'       => esc_html__( 'Slide Title Enable / Disable', 'gaming-lite' ),
		'section'     => 'gaming_lite_blog_slide_section',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'gaming-lite' ),
			'off' => esc_html__( 'Disable', 'gaming-lite' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'gaming_lite_button_unable_disable',
		'label'       => esc_html__( 'Slide Button Enable / Disable', 'gaming-lite' ),
		'section'     => 'gaming_lite_blog_slide_section',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'gaming-lite' ),
			'off' => esc_html__( 'Disable', 'gaming-lite' ),
		],
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'gaming_lite_slider_heading',
		'section'     => 'gaming_lite_blog_slide_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Slider', 'gaming-lite' ) . '</h3>',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'number',
		'settings'    => 'gaming_lite_blog_slide_number',
		'label'       => esc_html__( 'Number of slides to show', 'gaming-lite' ),
		'section'     => 'gaming_lite_blog_slide_section',
		'default'     => 3,
		'choices'     => [
			'min'  => 0,
			'max'  => 80,
			'step' => 1,
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'select',
		'settings'    => 'gaming_lite_blog_slide_category',
		'label'       => esc_html__( 'Select the category to show slider ( Image Dimension 1600 x 600 )', 'gaming-lite' ),
		'section'     => 'gaming_lite_blog_slide_section',
		'default'     => '',
		'placeholder' => esc_html__( 'Select an category...', 'gaming-lite' ),
		'priority'    => 10,
		'choices'     => gaming_lite_get_categories_select(),
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'gaming_lite_slider_short_heading',
		'section'     => 'gaming_lite_blog_slide_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Slider Sub Title', 'gaming-lite' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'gaming_lite_slider_short_title',
		'section'  => 'gaming_lite_blog_slide_section',
		'priority' => 10,
    ] );

		new \Kirki\Field\Select(
	[
		'settings'    => 'gaming_lite_slider_content_alignment',
		'label'       => esc_html__( 'Slider Content Alignment', 'gaming-lite' ),
		'section'     => 'gaming_lite_blog_slide_section',
		'default'     => 'LEFT-ALIGN',
		'placeholder' => esc_html__( 'Choose an option', 'gaming-lite' ),
		'choices'     => [
			'LEFT-ALIGN' => esc_html__( 'LEFT-ALIGN', 'gaming-lite' ),
			'CENTER-ALIGN' => esc_html__( 'CENTER-ALIGN', 'gaming-lite' ),
			'RIGHT-ALIGN' => esc_html__( 'RIGHT-ALIGN', 'gaming-lite' ),

		],
	] );

	// LATEST GAME SECTION

	Kirki::add_section( 'gaming_lite_latest_game_section', array(
        'title'          => esc_html__( 'Latest Game Settings', 'gaming-lite' ),
        'description'    => esc_html__( 'You have to select product category to show games section.', 'gaming-lite' ),
        'panel'          => 'gaming_lite_panel_id',
        'priority'       => 160,
    ) );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'gaming_lite_latest_game_section_enable_heading',
		'section'     => 'gaming_lite_latest_game_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Enable / Disable Latest Game Section', 'gaming-lite' ) . '</h3>',
		'priority'    => 1,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'gaming_lite_latest_game_section_enable',
		'label'       => esc_html__( 'Section Enable / Disable', 'gaming-lite' ),
		'section'     => 'gaming_lite_latest_game_section',
		'default'     => '0',
		'priority'    => 2,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'gaming-lite' ),
			'off' => esc_html__( 'Disable', 'gaming-lite' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'gaming_lite_latest_game_heading',
		'section'     => 'gaming_lite_latest_game_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Latest Game Headings',  'gaming-lite' ) . '</h3>',
		'priority'    => 3,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'gaming_lite_latest_game_sub_heading',
		'label'    => esc_html__( 'Sub Heading', 'gaming-lite' ),
		'section'  => 'gaming_lite_latest_game_section',
		'priority' => 4,
    ] );

    Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'gaming_lite_latest_game_main_heading',
		'label'    => esc_html__( 'Main Heading', 'gaming-lite' ),
		'section'  => 'gaming_lite_latest_game_section',
		'priority' => 5,
    ] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'gaming_lite_game_product_heading',
		'section'     => 'gaming_lite_latest_game_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Latest Games', 'gaming-lite' ) . '</h3>',
		'priority'    => 7,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'number',
		'settings'    => 'gaming_lite_latest_game_per_page',
		'label'       => esc_html__( 'Number of products to show', 'gaming-lite' ),
		'section'     => 'gaming_lite_latest_game_section',
		'default'     => 8,
		'choices'     => [
			'min'  => 0,
			'max'  => 80,
			'step' => 1,
		],
	] );

	// FOOTER SECTION

	Kirki::add_section( 'gaming_lite_footer_section', array(
        'title'          => esc_html__( 'Footer Settings', 'gaming-lite' ),
        'description'    => esc_html__( 'Here you can change copyright text', 'gaming-lite' ),
        'panel'          => 'gaming_lite_panel_id',
        'priority'       => 160,
    ) );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'gaming_lite_footer_text_heading',
		'section'     => 'gaming_lite_footer_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Footer Copyright Text', 'gaming-lite' ) . '</h3>',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'gaming_lite_footer_text',
		'section'  => 'gaming_lite_footer_section',
		'default'  => '',
		'priority' => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'gaming_lite_footer_enable_heading',
		'section'     => 'gaming_lite_footer_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Enable / Disable Footer Link', 'gaming-lite' ) . '</h3>',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'gaming_lite_copyright_enable',
		'label'       => esc_html__( 'Section Enable / Disable', 'gaming-lite' ),
		'section'     => 'gaming_lite_footer_section',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'gaming-lite' ),
			'off' => esc_html__( 'Disable', 'gaming-lite' ),
		],
	] );
}

add_action( 'customize_register', 'gaming_lite_customizer_settings' );
function gaming_lite_customizer_settings( $wp_customize ) {
	//Latest Game Section
	$args = array(
       'type'                     => 'product',
        'child_of'                 => 0,
        'parent'                   => '',
        'orderby'                  => 'term_group',
        'order'                    => 'ASC',
        'hide_empty'               => false,
        'hierarchical'             => 1,
        'number'                   => '',
        'taxonomy'                 => 'product_cat',
        'pad_counts'               => false
    );
	$categories = get_categories($args);
	$cat_posts = array();
	$m = 0;
	$cat_posts[]='Select';
	foreach($categories as $category){
		if($m==0){
			$default = $category->slug;
			$m++;
		}
		$cat_posts[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('gaming_lite_latest_game_category',array(
		'default'	=> 'select',
		'sanitize_callback' => 'gaming_lite_sanitize_select',
	));
	$wp_customize->add_control('gaming_lite_latest_game_category',array(
		'type'    => 'select',
		'choices' => $cat_posts,
		'label' => __('Select category to display games ','gaming-lite'),
		'section' => 'gaming_lite_latest_game_section',
	));
}
