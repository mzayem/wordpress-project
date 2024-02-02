<?php


$gaming_lite_custom_css = '';

	/*---------------------------text-transform-------------------*/

	$gaming_lite_text_transform = get_theme_mod( 'menu_text_transform_gaming_lite','CAPITALISE');
    if($gaming_lite_text_transform == 'CAPITALISE'){

		$gaming_lite_custom_css .='#main-menu ul li a{';

			$gaming_lite_custom_css .='text-transform: capitalize ; font-size: 13px;';

		$gaming_lite_custom_css .='}';

	}else if($gaming_lite_text_transform == 'UPPERCASE'){

		$gaming_lite_custom_css .='#main-menu ul li a{';

			$gaming_lite_custom_css .='text-transform: uppercase ; font-size: 13px;';

		$gaming_lite_custom_css .='}';

	}else if($gaming_lite_text_transform == 'LOWERCASE'){

		$gaming_lite_custom_css .='#main-menu ul li a{';

			$gaming_lite_custom_css .='text-transform: lowercase ; font-size: 13px;';

		$gaming_lite_custom_css .='}';
	}

	/*---------------------------Container Width-------------------*/

$gaming_lite_container_width = get_theme_mod('gaming_lite_container_width');

		$gaming_lite_custom_css .='body{';

			$gaming_lite_custom_css .='width: '.esc_attr($gaming_lite_container_width).'%; margin: auto;';

		$gaming_lite_custom_css .='}';


	/*---------------------------Slider-content-alignment-------------------*/

$gaming_lite_slider_content_alignment = get_theme_mod( 'gaming_lite_slider_content_alignment','LEFT-ALIGN');

 if($gaming_lite_slider_content_alignment == 'LEFT-ALIGN'){

		$gaming_lite_custom_css .='.blog_box{';

			$gaming_lite_custom_css .='text-align:left;';

		$gaming_lite_custom_css .='}';


	}else if($gaming_lite_slider_content_alignment == 'CENTER-ALIGN'){

		$gaming_lite_custom_css .='.blog_box{';

			$gaming_lite_custom_css .='text-align:center;';

		$gaming_lite_custom_css .='}';


	}else if($gaming_lite_slider_content_alignment == 'RIGHT-ALIGN'){

		$gaming_lite_custom_css .='.blog_box{';

			$gaming_lite_custom_css .='text-align:right;';

		$gaming_lite_custom_css .='}';

	}
