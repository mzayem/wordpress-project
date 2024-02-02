<?php
/**
 * Elementor Isotope Layout 2
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

$html = null;

if ( $img ) {
	$linkTarget = ( $link_target ? " target='" . esc_attr( $link_target ) . "'" : null );
	$html      .= "<div class='tlp-single-item tlp-isotope-item tlp-col-md-{$grid} tlp-col-sm-{$tgrid} tlp-col-xs-{$mgrid} {$catClass}' >";
	$html      .= '<div class="tlp-portfolio-item rt-row">';
	$html      .= '<div class="tlp-portfolio-thum tlp-item tlp-col-lg-5 tlp-col-md-5 tlp-col-sm-6 tlp-col-xs-12 ">';

	if ( $img ) {
		$html .= $img;
	}

	$html .= '<div class="tlp-overlay">';
	$html .= '<div class="tlp-overlay-inner">';

	$link_icon = null;

	if ( $enable_page_link ) {
		$link_icon .= '<a ' . $linkTarget . ' href="' . esc_url( $plink ) . '"><i class="icon-link-ext"></i></a>';
	}

	if ( $image_zoom ) {
		$link_icon .= '<a class="tlp-zoom" title="' . esc_html( $title ) . '" href="' . $imgFull . '"><i class="demo-icon icon-zoom-in"></i></a>';
	}

	if ( $link_icon ) {
		$html .= '<p class="link-icon">' . $link_icon . '</p>';
	}

	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';

	if ( $title ) {
		$html .= '<div class="tlp-content tlp-content2 tlp-col-lg-7 tlp-col-md-7 tlp-col-sm-6 tlp-col-xs-12 tlp-info">';
		$html .= '<div class="tlp-content-holder">';

		if ( $enable_page_link ) {
			$html .= '<h3 class="title"><a class="tlp-item-details"  ' . $linkTarget . ' title="' . esc_html( $title ) . '" href="' . esc_url( $plink ) . '">' . esc_html( $title ) . '</a></h3>';
		} else {
			$html .= '<h3 class="title">' . esc_html( $title ) . '</h3>';
		}

		if ( ! empty( $short_d ) ) {
			$html .= '<div class="tlp-portfolio-sd">' . $short_d . '</div>';
		}

		$external = '';

		if ( ! empty( $client_name ) ) {
			$external .= '<li class="client-name"><label>' . esc_html__( 'Client Name :', 'tlp-portfolio' ) . '</label>' . $client_name . '</li>';
		}

		if ( ! empty( $completed_date ) ) {
			$external .= '<li class="completed-date"><label>' . esc_html__( 'Completed Date :', 'tlp-portfolio' ) . '</label>' . $completed_date . '</li>';
		}

		if ( ! empty( $project_url ) ) {
			$external .= '<li class="project-url"><label>' . esc_html__( 'Project URL :', 'tlp-portfolio' ) . '</label><a  href="' . esc_url( $plink ) . '" target="_blank">' . esc_url( $plink ) . '</a></li>';
		}

		if ( ! empty( $categories ) ) {
			$external .= '<li class="tools"><label>' . esc_html__( 'Categories :', 'tlp-portfolio' ) . '</label>' . $categories . '</li>';
		}

		if ( ! empty( $tools ) ) {
			$external .= '<li class="tools"><label>' . esc_html__( 'Tools :', 'tlp-portfolio' ) . '</label>' . $tools . '</li>';
		}

		if ( ! empty( $external ) ) {
			$html .= '<ul>' . $external . '</ul>';
		}

		$html .= '</div>';
		$html .= '</div>';
	}

	$html .= '</div>';
	$html .= '</div>';
}

echo wp_kses_post( $html );
