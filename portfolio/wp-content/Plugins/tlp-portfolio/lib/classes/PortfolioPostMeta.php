<?php
/**
 * Post Meta class.
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( ! class_exists( 'PortfolioPostMeta' ) ) :
	/**
	 * Post Meta class.
	 */
	class PortfolioPostMeta {
		public function __construct() {
			add_action( 'add_meta_boxes', [ $this, 'portfolio_met_boxs' ] );
			add_action( 'save_post', [ $this, 'save_profile_meta_data' ], 10, 3 );
			add_action( 'admin_print_scripts-post-new.php', [ $this, 'tpl_portfolio_script' ], 11 );
			add_action( 'admin_print_scripts-post.php', [ $this, 'tpl_portfolio_script' ], 11 );
			add_action( 'edit_form_after_title', [ $this, 'portfolio_after_title' ] );
		}

		public function portfolio_after_title( $post ) {
			global $TLPportfolio;

			if ( $TLPportfolio->post_type !== $post->post_type ) {
				return;
			}
			?>
			<div class="postbox" style="margin-bottom: 0;">
				<div class="inside">
					<p style="text-align: center;"><a style="color: red; text-decoration: none; font-size: 14px;" href="<?php echo esc_url( TLPPortfolio()->pro_version_link() ); ?>" target="_blank">Please check the pro features</a></p>
				</div>
			</div>
			<?php
		}

		public function portfolio_met_boxs() {
			add_meta_box(
				'tlp_portfolio_meta',
				esc_html__( 'Portfolio Details', 'tlp-portfolio' ),
				[ $this, 'tlp_portfolio_meta' ],
				'portfolio',
				'normal',
				'high'
			);
		}

		public function tlp_portfolio_meta( $post ) {
			global $TLPportfolio;

			wp_nonce_field( $TLPportfolio->nonceText(), 'tlp_nonce' );

			$meta              = get_post_meta( $post->ID );
			$short_description = ! isset( $meta['short_description'][0] ) ? '' : $meta['short_description'][0];
			$project_url       = ! isset( $meta['project_url'][0] ) ? '' : $meta['project_url'][0];
			$external_url      = ! isset( $meta['external_url'][0] ) ? '' : $meta['external_url'][0];
			$client_name       = ! isset( $meta['client_name'][0] ) ? '' : $meta['client_name'][0];
			$completed_date    = ! isset( $meta['completed_date'][0] ) ? '' : $meta['completed_date'][0];

			$tools = ! isset( $meta['tools'][0] ) ? '' : $meta['tools'][0];
			?>
			<div class="portfolio-field-holder">
				<div class="rt-field-wrapper">
					<div class="rt-label">
						<label for="short_description"><?php esc_html_e( 'Short Description', 'tlp-portfolio' ); ?></label>
					</div>
					<div class="rt-field">
						<textarea id='short_description' name="short_description" cols="40" rows="5"
								class="rt-from-control"><?php echo wp_kses_post( $short_description ); ?></textarea>
						<p class="description"><?php esc_html_e( 'Add some short description for hint view', 'tlp-portfolio' ); ?></p>
					</div>
				</div>
				<div class="rt-field-wrapper">
					<div class="rt-label">
						<label for="client_name"><?php esc_html_e( 'Client Name', 'tlp-portfolio' ); ?></label>
					</div>
					<div class="rt-field">
						<input id="client_name" type="text" name="client_name" class="rt-from-control"
							value="<?php echo esc_attr( $client_name ); ?>">
					</div>
				</div>
				<div class="rt-field-wrapper">
					<div class="rt-label">
						<label for="completed_date"><?php esc_html_e( 'Completed Date', 'tlp-portfolio' ); ?></label>
					</div>
					<div class="rt-field">
						<input id='completed_date' type="text" name="completed_date" class="tlp-date rt-from-control"
							value="<?php echo esc_attr( $completed_date ); ?>">
					</div>
				</div>

				<div class="rt-field-wrapper">
					<div class="rt-label">
						<label for="project_url"><?php esc_html_e( 'Project Url', 'tlp-portfolio' ); ?></label>
					</div>
					<div class="rt-field">
						<input id='project_url' type="url" name="project_url" class="rt-from-control"
							value="<?php echo esc_url( $project_url ); ?>">
					</div>
				</div>

				<div class="rt-field-wrapper">
					<div class="rt-label">
						<label for="external_url"><?php esc_html_e( 'External URL (Custom detail link)', 'tlp-portfolio' ); ?> <span style="color:red;"><?php esc_html_e( 'Pro feature', 'tlp-portfolio' ); ?></span> </label>
					</div>
					<div class="rt-field">
						<input id='external_url' type="url" name="external_url" class="rt-from-control"
							value="<?php echo esc_url( $external_url ); ?>" disabled='disabled'>
					</div>
				</div>

				<div class="rt-field-wrapper">
					<div class="rt-label">
						<label for="tools"><?php esc_html_e( 'Tools Used', 'tlp-portfolio' ); ?></label>
					</div>
					<div class="rt-field">
						<input type="text" name="tools" id="tools" class="rt-from-control regular-text" value="<?php echo ! empty( $tools ) ? esc_attr( $tools ) : ''; ?>">
						<p class="description"><?php esc_html_e( 'Add the tools which are used in this project', 'tlp-portfolio' ); ?></p>
					</div>
				</div>
			</div>
			<?php
		}

		public function save_profile_meta_data( $post_id, $post, $update ) {

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			global $TLPportfolio;

			if ( ! isset( $_REQUEST['tlp_nonce'] ) || ! wp_verify_nonce( $_REQUEST['tlp_nonce'], $TLPportfolio->nonceText() ) ) {
				return;
			}

			if ( $TLPportfolio->post_type != $post->post_type ) {
				return;
			}

			$meta['short_description'] = ( isset( $_POST['short_description'] ) ? wp_kses_post( wp_unslash( $_POST['short_description'] ) ) : '' );
			$meta['project_url']       = ( isset( $_POST['project_url'] ) ? sanitize_text_field( wp_unslash( $_POST['project_url'] ) ) : '' );
			$meta['external_url']      = ( isset( $_POST['external_url'] ) ? '' : '' );
			$meta['client_name']       = ( isset( $_POST['client_name'] ) ? sanitize_text_field( wp_unslash( $_POST['client_name'] ) ) : '' );
			$meta['completed_date']    = ( isset( $_POST['completed_date'] ) ? sanitize_text_field( wp_unslash( $_POST['completed_date'] ) ) : '' );
			$meta['tools']             = ( isset( $_POST['tools'] ) ? sanitize_text_field( wp_unslash( $_POST['tools'] ) ) : '' );

			foreach ( $meta as $key => $value ) {
				update_post_meta( $post->ID, $key, $value );
			}
		}

		public function tpl_portfolio_script() {
			global $post_type, $TLPportfolio;

			if ( $post_type == 'portfolio' ) {
				$TLPportfolio->tlp_style();
				$TLPportfolio->tlp_script();
			}
		}
	}
endif;
