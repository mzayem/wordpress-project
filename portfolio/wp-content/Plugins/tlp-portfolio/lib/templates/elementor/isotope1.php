<?php
/**
 * Elementor Isotope Layout 1
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

$html  = null;
$html .= "<div class='tlp-item tlp-single-item tlp-isotope-item tlp-col-md-{$grid} tlp-col-sm-{$tgrid} tlp-col-xs-{$mgrid} {$catClass}'>";
$html .= '<div class="tlp-portfolio-item">';

if ( $img ) {
	$html .= '<div class="tlp-portfolio-thum tlp-item">';
	$html .= $img;
	$html .= '<div class="tlp-overlay">';
	$html .= '<p class="link-icon">';

	if ( $image_zoom ) {
		$html .= '<a class="tlp-zoom" href="' . $imgFull . '"><i class="demo-icon icon-zoom-in"></i></a>';
	}

	if ( ! empty( $enable_page_link ) ) {
		$html .= '<a target="' . $link_target . '" href="' . $plink . '"><i class="demo-icon icon-link-ext"></i></a>';
	}

	$html .= '</p>';
	$html .= '</div>';
	$html .= '</div>';
}

$description_html = sprintf( '<div class="tlp-portfolio-sd">%s</div>', $short_d );

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
		'<div class="tlp-content" ><div class="tlp-content-holder"> %s %s %s</div></div>',
		! empty( $title ) ? $display_title : '',
		! empty( $short_d ) ? $description_html : '',
		$optional_field
	);
}

$html .= '</div>';
$html .= '</div>';

echo wp_kses_post( $html );
