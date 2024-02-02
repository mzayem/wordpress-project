<?php
/**
 * Dynamic CSS
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

$layoutID            = 'tlp-portfolio-container-' . $scID;
$scMeta              = get_post_meta( $scID );
$primaryColor        = isset( $scMeta['pfp_primary_color'][0] ) && ! empty( $scMeta['pfp_primary_color'][0] ) ? sanitize_text_field( $scMeta['pfp_primary_color'][0] ) : null;
$overlayColor        = isset( $scMeta['pfp_overlay_color'][0] ) && ! empty( $scMeta['pfp_overlay_color'][0] ) ? sanitize_text_field( $scMeta['pfp_overlay_color'][0] ) : null;
$buttonBgColor       = isset( $scMeta['pfp_button_bg_color'][0] ) && ! empty( $scMeta['pfp_button_bg_color'][0] ) ? sanitize_text_field( $scMeta['pfp_button_bg_color'][0] ) : null;
$buttonTxtColor      = isset( $scMeta['pfp_button_text_color'][0] ) && ! empty( $scMeta['pfp_button_text_color'][0] ) ? sanitize_text_field( $scMeta['pfp_button_text_color'][0] ) : null;
$buttonHoverBgColor  = isset( $scMeta['pfp_button_hover_bg_color'][0] ) && ! empty( $scMeta['pfp_button_hover_bg_color'][0] ) ? sanitize_text_field( $scMeta['pfp_button_hover_bg_color'][0] ) : null;
$buttonActiveBgColor = isset( $scMeta['pfp_button_active_bg_color'][0] ) && ! empty( $scMeta['pfp_button_active_bg_color'][0] ) ? sanitize_text_field( $scMeta['pfp_button_active_bg_color'][0] ) : null;
$name                = isset( $scMeta['pfp_name_style'][0] ) && ! empty( $scMeta['pfp_name_style'][0] ) ? TLPPortfolio()->array_text_sanitization( $scMeta['pfp_name_style'][0] ) : [];

$name_hover = isset( $scMeta['pfp_name_hover_style'][0] ) && ! empty( $scMeta['pfp_name_hover_style'][0] ) ? TLPPortfolio()->array_text_sanitization( $scMeta['pfp_name_hover_style'][0] ) : [];

$short_desc = isset( $scMeta['pfp_short_description_style'][0] ) && ! empty( $scMeta['pfp_short_description_style'][0] ) ? TLPPortfolio()->array_text_sanitization( $scMeta['pfp_short_description_style'][0] ) : [];
$gutter     = isset( $scMeta['pfp_gutter'][0] ) && ! empty( $scMeta['pfp_gutter'][0] ) ? absint( $scMeta['pfp_gutter'][0] ) : null;
$iconStyle  = ( ! empty( $scMeta['pfp_icon_style'][0] ) ? TLPPortfolio()->array_text_sanitization( $scMeta['pfp_icon_style'][0] ) : [] );
$meta_style = ( isset( $scMeta['pfp_meta_style'][0] ) ? TLPPortfolio()->array_text_sanitization( $scMeta['pfp_meta_style'][0] ) : [] );

$style = '';


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

	$style .= "#{$layoutID} .tlp-portfolio-isotope-button button,#{$layoutID} .owl-theme .owl-nav [class*=owl-],#{$layoutID} .owl-theme .owl-dots .owl-dot span,#{$layoutID} .tlp-pagination li span, #{$layoutID} .tlp-pagination li a {";
	$style .= "background: {$buttonBgColor};";
	$style .= ( $buttonTxtColor ? "color: {$buttonTxtColor}" : null );
	$style .= '}';
}

/* Button hover background color */
if ( $buttonHoverBgColor ) {
	$style .= "#{$layoutID} .tlp-portfolio-isotope-button button:hover, #{$layoutID} .owl-theme .owl-nav [class*=owl-]:hover, #{$layoutID} .tlp-pagination li span:hover, #{$layoutID} .tlp-pagination li a:hover {";
	$style .= "background: {$buttonHoverBgColor};";
	$style .= '}';
}

/* Button Active background color */
if ( $buttonActiveBgColor ) {
	$style .= "#{$layoutID} .tlp-portfolio-isotope-button button.selected, #{$layoutID} .owl-theme .owl-dots .owl-dot.active span, #{$layoutID} .tlp-pagination li.active span {";
	$style .= "background: {$buttonActiveBgColor};";
	$style .= '}';
}

/* gutter */
if ( $gutter ) {
	$style .= "#{$layoutID} > .rt-row > [class*='tlp-col-'], #{$layoutID} > .rt-row > .tlp-portfolio-isotope > [class*='tlp-col-'],  #{$layoutID} > .rt-row .owl-item > [class*='tlp-col-'] {";
	$style .= "padding-left : {$gutter}px;";
	$style .= "padding-right : {$gutter}px;";
	$style .= "margin-top : {$gutter}px;";
	$style .= "margin-bottom : {$gutter}px;";
	$style .= '}';
	$style .= "#{$layoutID} > .rt-row, #{$layoutID} > .rt-row {";
	$style .= "margin-left : -{$gutter}px;";
	$style .= "margin-right : -{$gutter}px;";
	$style .= '}';
}

// Social icon color
if ( ! empty( $iconStyle ) && is_array( $iconStyle ) ) {
	$iconStyleComoncss  = ! empty( $iconStyle['color'] ) ? 'color:' . $iconStyle['color'] . ';' : null;
	$iconStyleComoncss .= ! empty( $iconStyle['size'] ) ? 'font-size:' . $iconStyle['size'] . 'px;' : null;
	$iconStyleComoncss .= ! empty( $iconStyle['align'] ) ? 'text-align:' . $iconStyle['align'] . ';' : null;
	$iconStyleComoncss .= ! empty( $iconStyle['weight'] ) ? 'font-weight:' . $iconStyle['weight'] . ';' : null;

	if ( $iconStyleComoncss ) {
		$style .= "#{$layoutID} .tlp-portfolio-item ul li i, #{$layoutID} .tlp-portfolio-item .tlp-overlay .link-icon a, #{$layoutID} .tlp-portfolio-item .link-icon a {";
		$style .= $iconStyleComoncss;
		$style .= '}';

		if ( isset( $iconStyle['color'] ) ) {
			$style .= "#{$layoutID} .tlp-portfolio-item .tlp-overlay .link-icon a, #{$layoutID} .tlp-portfolio-item .link-icon a {";
			$style .= 'border: 1px solid  ' . $iconStyle['color'] . ';';
			$style .= '}';
		}
	}
}
// Name
if ( is_array( $name ) && ! empty( $name ) ) {
	$nameStyleComoncss  = isset( $name['color'] ) && ! empty( $name['color'] ) ? 'color:' . $name['color'] . ';' : null;
	$nameStyleComoncss .= isset( $name['align'] ) && ! empty( $name['align'] ) ? 'text-align:' . $name['align'] . ' !important;' : null;
	$nameStyleComoncss .= isset( $name['weight'] ) && ! empty( $name['weight'] ) ? 'font-weight:' . $name['weight'] . ';' : null;
	$nameStyleComoncss .= isset( $name['size'] ) && ! empty( $name['size'] ) ? 'font-size:' . $name['size'] . 'px;' : null;

	if ( $nameStyleComoncss ) {
		$style .= "#{$layoutID} .tlp-portfolio-item h3 a, #{$layoutID} .tlp-portfolio-item h3 {";
		$style .= $nameStyleComoncss;
		$style .= '}';
	}
}
// Name Hover
if ( is_array( $name_hover ) && ! empty( $name_hover ) ) {
	$name_hoverStyleComoncss  = isset( $name_hover['color'] ) && ! empty( $name_hover['color'] ) ? 'color:' . $name_hover['color'] . ';' : null;
	$name_hoverStyleComoncss .= isset( $name_hover['align'] ) && ! empty( $name_hover['align'] ) ? 'text-align:' . $name_hover['align'] . ' !important;' : null;
	$name_hoverStyleComoncss .= isset( $name_hover['weight'] ) && ! empty( $name_hover['weight'] ) ? 'font-weight:' . $name_hover['weight'] . ';' : null;
	$name_hoverStyleComoncss .= isset( $name_hover['size'] ) && ! empty( $name_hover['size'] ) ? 'font-size:' . $name_hover['size'] . 'px;' : null;

	if ( $name_hoverStyleComoncss ) {
		$style .= "#{$layoutID} .tlp-portfolio-item h3 a:hover, #{$layoutID} .tlp-portfolio-item h3:not(.color-white):hover {";
		$style .= $name_hoverStyleComoncss;
		$style .= '}';
	}
}

// Short Description
if ( is_array( $short_desc ) && ! empty( $short_desc ) ) {
	$short_descStyleComoncss  = isset( $short_desc['color'] ) && ! empty( $short_desc['color'] ) ? 'color:' . $short_desc['color'] . ';' : null;
	$short_descStyleComoncss .= isset( $short_desc['size'] ) && ! empty( $short_desc['size'] ) ? 'font-size:' . $short_desc['size'] . 'px;' : null;
	$short_descStyleComoncss .= isset( $short_desc['weight'] ) && ! empty( $short_desc['weight'] ) ? 'font-weight:' . $short_desc['weight'] . ';' : null;
	$short_descStyleComoncss .= isset( $short_desc['align'] ) && ! empty( $short_desc['align'] ) ? 'text-align:' . $short_desc['align'] . ';' : null;

	if ( $short_descStyleComoncss ) {
		$style .= "#{$layoutID} .tlp-portfolio-item .tlp-portfolio-sd {";
		$style .= $short_descStyleComoncss;
		$style .= '}';
	}
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


if ( $style ) {
	echo sanitize_text_field( $style );
}
