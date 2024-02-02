<?php
/**
 * Isotope Layout 1
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

$exFeature = $visit_url = $imgHtml = $project_title = $zoom_image_icon = $short_description = null;

if ( in_array( 'zoom_image', $items ) && $imgFull ) {
	$zoom_image_icon .= sprintf( '<a class="tlp-zoom" href="%s"><i class="demo-icon icon-zoom-in"></i></a>', esc_url( $imgFull ) );
}

$link_target = $link_target ? " target='" . esc_attr( $link_target ) . "'" : null;

if ( in_array( 'name', $items ) && $title ) {
	$project_title = $link ? sprintf( '<h3><a href="%s" %s >%s</a></h3>', esc_url( $item_link ), $link_target, $title ) : sprintf( '<h3>%s</h3>', $title );
}

if ( $item_link ) {
	$visit_url = $link ? sprintf( '<a href="%s"%s><i class="demo-icon icon-link-ext"></i></a>', esc_url( $item_link ), $link_target ) : null;
}

if ( in_array( 'short_description', $items ) && $short_d ) {
	$short_description = '<div class="tlp-portfolio-sd">' . $short_d . '</div>';
}

if ( in_array( 'client_name', $items ) && $client_name ) {
	$exFeature .= '<li class="client-name"><label>' . esc_html__( 'Client Name :', 'tlp-portfolio' ) . '</label>' . $client_name . '</li>';
}

if ( in_array( 'completed_date', $items ) && $completed_date ) {
	$exFeature .= '<li class="completed-date"><label>' . esc_html__( 'Completed Date :', 'tlp-portfolio' ) . '</label>' . $completed_date . '</li>';
}

if ( in_array( 'project_url', $items ) && $project_url ) {
	$exFeature .= '<li class="project-url"><label>' . esc_html__( 'Project URL :', 'tlp-portfolio' ) . '</label><a  href="' . esc_url( $item_link ) . '" target="_blank">' . esc_url( $item_link ) . '</a></li>';
}

if ( in_array( 'categories', $items ) && $categories ) {
	$exFeature .= '<li class="tools"><label>' . esc_html__( 'Categories :', 'tlp-portfolio' ) . '</label>' . $categories . '</li>';
}

if ( in_array( 'tools', $items ) && $tools ) {
	$exFeature .= '<li class="tools"><label>' . esc_html__( 'Tools :', 'tlp-portfolio' ) . '</label>' . $tools . '</li>';
}

if ( $exFeature ) {
	$exFeature = sprintf( '<div class="extra-features"> %s <ul>%s</ul></div>', $short_description, $exFeature );
} elseif ( $short_description ) {
	$exFeature = sprintf( '<div class="extra-features"> %s </div>', $short_description );
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
		$visit_url,
	);
}
$grid = $grid . $isoFilter;
?>
<div class="<?php echo esc_attr( $grid ); ?>">
	<div class="tlp-portfolio-item">
		<?php if ( ! empty( $project_title ) || ! empty( $exFeature ) ) { ?>
			<?php
			$imgHtml .= sprintf(
				'<div class="tlp-content">
					<div class="tlp-content-holder">
						%s
						%s
					</div>
				</div>',
				$project_title,
				$exFeature
			);
			?>
		<?php } ?>
		<?php echo wp_kses_post( $imgHtml ); ?>
	</div>
</div>
