<?php
/**
 * Get Help Page.
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

global $TLPportfolio;
?>
	<style>
		.rtport-help-wrapper {
			width: 60%;
			margin: 0 auto;
		}
		.rtport-help-section .embed-wrapper {
			position: relative;
			display: block;
			width: calc(100% - 40px);
			padding: 0;
			overflow: hidden;
		}
		.rtport-help-section .embed-wrapper::before {
			display: block;
			content: "";
			padding-top: 56.25%;
		}
		.rtport-help-section iframe {
			position: absolute;
			top: 0;
			bottom: 0;
			left: 0;
			width: 100%;
			height: 100%;
			border: 0;
		}
		.rtport-help-wrapper .rt-document-box .rt-box-title {
			margin-bottom: 30px;
		}
		.rtport-help-wrapper .rt-document-box .rt-box-icon {
			margin-top: -6px;
		}
		.rtport-help-wrapper .rtport-help-section {
			margin-top: 30px;
		}
		.rtport-feature-list ul {
			column-count: 2;
			column-gap: 30px;
			margin-bottom: 0;
		}
		.rtport-feature-list ul li {
			padding: 0 0 12px;
			margin-bottom: 0;
			width: 100%;
			font-size: 14px;
		}
		.rtport-feature-list ul li:last-child {
			padding-bottom: 0;
		}
		.rtport-feature-list ul li i {
			color: #4C6FFF;
		}
		.rtport-pro-feature-content {
			display: flex;
			flex-wrap: wrap;
		}
		.rtport-pro-feature-content .rt-document-box + .rt-document-box {
			margin-left: 30px;
		}
		.rtport-pro-feature-content .rt-document-box {
			flex: 0 0 calc(33.3333% - 60px);
			margin-top: 30px;
		}
		.rtport-testimonials {
			display: flex;
			flex-wrap: wrap;
		}
		.rtport-testimonials .rtport-testimonial + .rtport-testimonial  {
			margin-left: 30px;
		}
		.rtport-testimonials .rtport-testimonial  {
			flex: 0 0 calc(50% - 30px)
		}
		.rtport-testimonial .client-info {
			display: flex;
			flex-wrap: wrap;
			font-size: 14px;
			align-items: center;
		}
		.rtport-testimonial .client-info img {
			width: 60px;
			height: 60px;
			object-fit: cover;
			border-radius: 50%;
			margin-right: 10px;
		}
		.rtport-testimonial .client-info .rtport-star {
			color: #4C6FFF;
		}
		.rtport-testimonial .client-info .client-name {
			display: block;
			color: #000;
			font-size: 16px;
			font-weight: 600;
			margin: 8px 0 5px;
		}
		.rtport-call-to-action {
			background-size: cover;
			background-repeat: no-repeat;
			background-position: center;
			height: 150px;
			color: #ffffff;
			margin: 30px 0;
		}
		.rtport-call-to-action a {
			color: inherit;
			display: flex;
			flex-wrap: wrap;
			width: 100%;
			height: 100%;
			flex: 1;
			align-items: center;
			font-size: 28px;
			font-weight: 700;
			text-decoration: none;
			margin-left: 130px;
			position: relative;
			outline: none;
			-webkit-box-shadow: none;
			box-shadow: none;
		}
		.rtport-call-to-action a::before {
			content: "";
			position: absolute;
			left: -30px;
			top: 50%;
			height: 30%;
			width: 5px;
			background: #fff;
			-webkit-transform: translateY(-50%);
			transform: translateY(-50%);
		}
		.rtport-call-to-action:hover a {
			text-decoration: underline;
		}
		.rtport-testimonial p {
			text-align: justify;
		}
		@media all and (max-width: 1400px) {
			.rtport-help-wrapper {
				width: 80%;
			}
		}
		@media all and (max-width: 1025px) {
			.rtport-pro-feature-content .rt-document-box {
				flex: 0 0 calc(50% - 55px)
			}
			.rtport-pro-feature-content .rt-document-box + .rt-document-box + .rt-document-box {
				margin-left: 0;
			}
		}
		@media all and (max-width: 991px) {
			.rtport-help-wrapper {
				width: calc(100% - 40px);
			}
			.rtport-call-to-action a {
				justify-content: center;
				margin-left: auto;
				margin-right: auto;
				text-align: center;
			}
			.rtport-call-to-action a::before {
				content: none;
			}
		}
		@media all and (max-width: 600px) {
			.rt-document-box .rt-box-content .rt-box-title {
				line-height: 28px;
			}
			.rtport-help-section .embed-wrapper {
				width: 100%;
			}
			.rtport-feature-list ul {
				column-count: 1;
			}
			.rtport-feature-list ul li {
				width: 100%;
			}
			.rtport-call-to-action a {
				padding-left: 25px;
				padding-right: 25px;
				font-size: 20px;
				line-height: 28px;
				width: 80%;
			}
			.rtport-testimonials {
				display: block;
			}
			.rtport-testimonials .rtport-testimonial + .rtport-testimonial {
				margin-left: 0;
				margin-top: 30px;
				padding-top: 30px;
				border-top: 1px solid #ddd;
			}
			.rtport-pro-feature-content .rt-document-box {
				width: 100%;
				flex: auto;
			}
			.rtport-pro-feature-content .rt-document-box + .rt-document-box {
				margin-left: 0;
			}

			.rtport-help-wrapper .rt-document-box {
				display: block;
				position: relative;
			}

			.rtport-help-wrapper .rt-document-box .rt-box-icon {
				position: absolute;
				left: 20px;
				top: 30px;
				margin-top: 0;
			}

			.rt-document-box .rt-box-content .rt-box-title {
				margin-left: 45px;
			}
		}
	</style>
	<div class="rtport-help-wrapper" >
		<div class="rtport-help-section rt-document-box">
			<div class="rt-box-icon"><i class="dashicons dashicons-media-document"></i></div>
			<div class="rt-box-content">
				<h3 class="rt-box-title">Thank you for installing Portfolio Plugin</h3>
				<div class="embed-wrapper">
					<iframe src="https://www.youtube.com/embed/tuOnwHWkgPQ" title="Portfolio Plugin" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			</div>
		</div>
		<div class="rt-document-box">
			<div class="rt-box-icon"><i class="dashicons dashicons-megaphone"></i></div>
			<div class="rt-box-content rtport-feature-list">
				<h3 class="rt-box-title">Pro Features</h3>
				<ul>
					<li><i class="dashicons dashicons-saved"></i> 57 Amazing Layouts with Grid, Masonry, Slider, Isotope.</li>
					<li><i class="dashicons dashicons-saved"></i> Gallery Image View.</li>
					<li><i class="dashicons dashicons-saved"></i> Even and Masonry Grid.</li>
					<li><i class="dashicons dashicons-saved"></i> Layout Preview in Shortcode Settings.</li>
					<li><i class="dashicons dashicons-saved"></i> Taxonomy support (Category, Tag).</li>
					<li><i class="dashicons dashicons-saved"></i> All Text and Color control.</li>
					<li><i class="dashicons dashicons-saved"></i> Custom image size control.</li>
					<li><i class="dashicons dashicons-saved"></i> AJAX Pagination (Numbered, Load more and Load on Scrolling).</li>
					<li><i class="dashicons dashicons-saved"></i> Popup Support for detail page.</li>
					<li><i class="dashicons dashicons-saved"></i> Search field on Isotope.</li>
					<li><i class="dashicons dashicons-saved"></i> Order by Name, Id, Date, Random and Menu order.</li>
					<li><i class="dashicons dashicons-saved"></i> Related Portfolio</li>
					<li><i class="dashicons dashicons-saved"></i> Responsive Display Control.</li>
					<li><i class="dashicons dashicons-saved"></i> More Features...</li>
				</ul>
			</div>
		</div>
		<div class="rtport-call-to-action" style="background-image: url('<?php echo esc_url( $TLPportfolio->assetsUrl ); ?>images/admin/banner.png')">
			<a href="https://www.radiustheme.com/downloads/tlp-portfolio-pro-for-wordpress/" target="_blank" class="rt-update-pro-btn">
				Update to Pro & Get More Features
			</a>
		</div>
		<div class="rt-document-box">
			<div class="rt-box-icon"><i class="dashicons dashicons-thumbs-up"></i></div>
			<div class="rt-box-content">
				<h3 class="rt-box-title">Happy clients of the Portfolio Plugin</h3>
				<div class="rtport-testimonials">
					<div class="rtport-testimonial">
						<p>Plugin is easy to use, shortcode generator is very useful. I bought the pro version, and had a feature request. Emailed them & the team replied within a few days with the updated code that worked perfectly. Many thanks to the team!</p>
						<div class="client-info">
							<img src="<?php echo esc_url( $TLPportfolio->assetsUrl ); ?>images/admin/client1.png">
							<div>
								<div class="rtport-star">
									<i class="dashicons dashicons-star-filled"></i>
									<i class="dashicons dashicons-star-filled"></i>
									<i class="dashicons dashicons-star-filled"></i>
									<i class="dashicons dashicons-star-filled"></i>
									<i class="dashicons dashicons-star-filled"></i>
								</div>
								<span class="client-name">lioweee</span>
							</div>
						</div>
					</div>
					<div class="rtport-testimonial">
						<p>This plugin is exactly what we needed, and when we required a little help, RadiusTheme came through with flying colours. Fast response and went the extra mile. Thanks again !</p>
						<div class="client-info">
							<img src="<?php echo esc_url( $TLPportfolio->assetsUrl ); ?>images/admin/client2.png">
							<div>
								<div class="rtport-star">
									<i class="dashicons dashicons-star-filled"></i>
									<i class="dashicons dashicons-star-filled"></i>
									<i class="dashicons dashicons-star-filled"></i>
									<i class="dashicons dashicons-star-filled"></i>
									<i class="dashicons dashicons-star-filled"></i>
								</div>
								<span class="client-name">rollypollyjimmy</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="rtport-pro-feature-content">
			<div class="rt-document-box">
				<div class="rt-box-icon"><i class="dashicons dashicons-media-document"></i></div>
				<div class="rt-box-content">
					<h3 class="rt-box-title">Documentation</h3>
					<p>Get started by spending some time with the documentation we included step by step process with screenshots with video.</p>
					<a href="https://www.radiustheme.com/how-to-setup-and-configure-tlp-portfolio-free-version-for-wordpress/" target="_blank" class="rt-admin-btn">Documentation</a>
				</div>
			</div>
			<div class="rt-document-box">
				<div class="rt-box-icon"><i class="dashicons dashicons-sos"></i></div>
				<div class="rt-box-content">
					<h3 class="rt-box-title">Need Help?</h3>
					<p>Stuck with something? Please create a
						<a href="https://www.radiustheme.com/contact/">ticket here</a> or post on <a href="https://www.facebook.com/groups/234799147426640/">facebook group</a>. For emergency case join our <a href="https://www.radiustheme.com/">live chat</a>.</p>
					<a href="https://www.radiustheme.com/contact/" target="_blank" class="rt-admin-btn">Get Support</a>
				</div>
			</div>
			<div class="rt-document-box">
				<div class="rt-box-icon"><i class="dashicons dashicons-smiley"></i></div>
				<div class="rt-box-content">
					<h3 class="rt-box-title">Happy Our Work?</h3>
					<p>If you happy with <strong>Portfolio Plugin</strong> plugin, please add a rating. It would be glad to us.</p>
					<a href="https://wordpress.org/support/plugin/tlp-portfolio/reviews/?filter=5#new-post" class="rt-admin-btn" target="_blank">Post Review</a>
				</div>
			</div>
		</div>
	</div>
<?php
