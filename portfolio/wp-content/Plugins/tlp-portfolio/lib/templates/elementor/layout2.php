<?php
/**
 * Elementor Layout 2
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

$html  = null;
$html .= "<div class='tlp-col-lg-{$grid} tlp-col-md-{$grid} tlp-col-sm-{$tgrid} tlp-col-xs-12 tlp-single-item tlp-grid-item tlp-equal-height'>";
$html .= '<div class="tlp-portfolio-item rt-row">';

if ( $img ) {
	$html .= '<div class="tlp-portfolio-thum tlp-item ' . $image_area . '">';
	$html .= '<figure>';
	$html .= $img;
	$html .= '</figure>';
	$html .= '<div class="tlp-overlay">';
	$html .= '<ul class="link-icon">';

	if ( $image_zoom ) {
		$html .= '<a class="tlp-zoom" href="' . $imgFull . '"><i class="demo-icon icon-zoom-in" ></i></a>';
	}

	if ( ! empty( $enable_page_link ) ) {
		$html .= '<a target="' . $link_target . '"  href="' . $plink . '"><i class="demo-icon icon-link-ext" ></i></a>';
	}

	$html .= '</ul>';
	$html .= '</div>';
	$html .= '</div>';
}

if ( ! empty( $enable_page_link ) ) {
	$display_title = sprintf(
		'<h3><a target="%s" href="%s">%s </a></h3>',
		$link_target,
		$plink,
		$title
	);
} else {
	$display_title = sprintf( '<h3>%s</h3>', $title );
}

$description_html = sprintf( '<div class="tlp-portfolio-sd">%s</div>', $short_d );

$optional_field   = null;
$optional_content = null;

if ( ! empty( $client_name ) ) {
	$optional_content .= '<li class="client-name"><label>' . esc_html__( 'Client Name', 'tlp-portfolio' ) . ':</label>' . $client_name . '</li>';
}

if ( ! empty( $project_url ) ) {
	$optional_content .= '<li class="client-name"><label>' . esc_html__( 'Project URL', 'tlp-portfolio' ) . ':</label><a  href="' . esc_url( $plink ) . '" target="_blank">' . esc_url( $plink ) . '</a></li>';
}

if ( ! empty( $completed_date ) ) {
	$optional_content .= '<li class="client-name"><label>' . esc_html__( 'Completed Date', 'tlp-portfolio' ) . ':</label>' . $completed_date . '</li>';
}

if ( ! empty( $categories ) ) {
	$optional_content .= '<li class="pfp-categories"><label>' . esc_html__( 'Categories :', 'tlp-portfolio' ) . '</label>' . $categories . '</li>';
}

if ( ! empty( $tools ) ) {
	$optional_content .= '<li class="client-name"><label>' . esc_html__( 'Tools', 'tlp-portfolio' ) . ':</label>' . $tools . '</li>';
}

if ( $optional_content ) {
	$optional_field = sprintf( '<ul>%s</ul>', $optional_content );
}

if ( ! empty( $title ) || ! empty( $short_d ) || ! empty( $optional_field ) ) {

	$html .= sprintf(
		'<div class="tlp-content tlp-content2 %s" ><div class="tlp-content-holder">%s %s %s</div></div>',
		$content_area,
		! empty( $title ) ? $display_title : '',
		! empty( $short_d ) ? $description_html : '',
		$optional_field
	);
}

$html .= '</div>';
$html .= '</div>';

echo wp_kses_post( $html );
