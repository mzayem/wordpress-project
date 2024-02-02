<?php
/**
 * Elementor Carousel Layout 1
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

$exFeature  = $imgHtml = $zoom_image_icon = null;
$linkTarget = $link_target ? " target='" . esc_attr( $link_target ) . "'" : null;

if ( $image_zoom ) {
	$zoom_image_icon .= sprintf( '<a class="tlp-zoom" href="%s"><i class="demo-icon icon-zoom-in"></i></a>', esc_url( $imgFull ) );
}

if ( $img ) {
	$imgHtml = sprintf(
		'<div class="tlp-portfolio-thum tlp-item">
				%s
				<div class="tlp-overlay">
					<p class="link-icon">
						%s
						%s
					</p>
				</div>
			</div>',
		$img,
		$zoom_image_icon,
		$enable_page_link ? sprintf( '<a href="%s" %s><i class="demo-icon icon-link-ext"></i></a>', esc_url( $plink ), $linkTarget ) : null
	);
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

if ( ! empty( $client_name ) ) {
	$exFeature .= '<li class="client-name"><label>' . esc_html__( 'Client Name :', 'tlp-portfolio' ) . '</label>' . esc_html( $client_name ) . '</li>';
}

if ( ! empty( $completed_date ) ) {
	$exFeature .= '<li class="completed-date"><label>' . esc_html__( 'Completed Date :', 'tlp-portfolio' ) . '</label>' . esc_html( $completed_date ) . '</li>';
}

if ( ! empty( $project_url ) ) {
	$exFeature .= '<li class="project-url"><label>' . esc_html__( 'Project URL :', 'tlp-portfolio' ) . '</label><a  href="' . esc_url( $plink ) . '" target="_blank">' . esc_url( $plink ) . '</a></li>';
}

if ( ! empty( $categories ) ) {
	$exFeature .= '<li class="tools"><label>' . esc_html__( 'Categories :', 'tlp-portfolio' ) . '</label>' . $categories . '</li>';
}

if ( ! empty( $tools ) ) {
	$exFeature .= '<li class="tools"><label>' . esc_html__( 'Tools :', 'tlp-portfolio' ) . '</label>' . $tools . '</li>';
}

if ( $exFeature ) {
	$exFeature = sprintf( '<div class="extra-features"> <ul>%s</ul></div>', $exFeature );
}
?>
<div class='tlp-col-xs-12 tlp-single-item tlp-grid-item tlp-equal-height'>
	<div class="tlp-portfolio-item">
		<?php if ( ! empty( $title ) || ! empty( $short_d ) || ! empty( $exFeature ) ) { ?>
			<?php
			$imgHtml .= sprintf(
				'<div class="tlp-content"><div class="tlp-content-holder">%s %s %s</div> </div>',
				! empty( $title ) ? $display_title : '',
				! empty( $short_d ) ? $description_html : '',
				$exFeature
			);
			?>
		<?php } ?>
		<?php echo wp_kses_post( $imgHtml ); ?>
	</div>
</div>
