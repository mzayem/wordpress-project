<?php
/** ELPT
 * Shortcodes 
 *
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Powerfolio_Shortcodes {

	//Create shortcode
	static function powerfolio_shortcode($atts, $content = null) {
		$assets_dir =  plugin_dir_url( __DIR__ );		
		
		extract(shortcode_atts(array(
			//"id" => '',
			"postsperpage" => '',
			"showfilter" => '',
			"taxonomy" => '',
			"type" => '',
			"style" => '',
			"columns" => '',
			"columns_mobile" => '',			
			"margin" => '',
			"linkto" => '',
			"hover" => '',
			"zoom_effect" => '',
			"post_type" => '',
			"tax_text" => '',
			"showallbtn" => '',		
			"hide_item_title" => '',
			"hide_item_category" => '',		
		), $atts));

		// Let's escape and validate the attributes before rendering on the page
		$postsperpage = esc_attr($postsperpage);
		$showfilter = esc_attr($showfilter);
		$taxonomy = esc_attr($taxonomy);
		$type = esc_attr($type);
		$style = esc_attr($style);
		$columns = esc_attr($columns);
		$columns_mobile = esc_attr($columns_mobile);
		$margin = esc_attr($margin);
		$linkto = esc_attr($linkto);
		$hover = esc_attr($hover);
		$zoom_effect = esc_attr($zoom_effect);
		$post_type = esc_attr($post_type);
		$tax_text = esc_attr($tax_text);
		$showallbtn = esc_attr($showallbtn);
		$hide_item_title = esc_attr($hide_item_title);
		$hover = esc_attr($hover);
		$hide_item_category = esc_attr($hide_item_category);
		
		////Isotope			
		wp_enqueue_script( 'jquery-isotope',  $assets_dir. 'vendor/isotope/js/isotope.pkgd.js', array('jquery', 'imagesloaded'), '20151215', true );
		wp_enqueue_script( 'jquery-packery', $assets_dir. 'vendor/isotope/js/packery-mode.pkgd.min.js', array('jquery', 'imagesloaded', 'jquery-isotope'), '20151215', true );

		//Image Lightbox
		if ( apply_filters( 'elpt-enable-simple-lightbox', TRUE ) === TRUE ) {
			wp_enqueue_script( 'simple-lightbox-js',  $assets_dir.  'vendor/simplelightbox/dist/simple-lightbox.min.js', array('jquery'), '20151218', true );
			wp_enqueue_style( 'simple-lightbox-css', $assets_dir .  'vendor/simplelightbox/dist/simplelightbox.min.css' );
			wp_enqueue_script( 'elpt-portfoliojs-lightbox', $assets_dir . 'js/custom-portfolio-lightbox.js', array('jquery'), '20151215', true );
		}
		
		//Custom JS
		wp_enqueue_script( 'elpt-portfoliojs', $assets_dir . 'js/custom-portfolio.js', array('jquery'), '20151215', true );
	
		//Custom CSS
		wp_enqueue_style( 'elpt-portfolio-css', $assets_dir .  'css/powerfolio_css.css' );
		
		$portfolio_type = $type;
		$portfolio_isotope = 'elpt-portfolio-content-isotope';
		$rel_id = rand(0, 9999);
		$taxonomy = explode(",", $taxonomy);

		if(! $post_type || $post_type == '') {
			$post_type = 'elemenfolio';
		}
	
		if ( $portfolio_type == 'yes') {
			$args = array(
				'post_type' => $post_type,
				'posts_per_page' => $postsperpage,		
				'suppress_filters' => false,  
				'tax_query' => array(
					array(
						'taxonomy' => 'elemenfoliocategory',
						'field'    => 'id',
						'terms'    => $taxonomy,
					),
				),		
				//'p' => $id
			); 	
		} else { 
			$args = array(
				'post_type' => $post_type,
				'posts_per_page' => $postsperpage,	
				'suppress_filters' => false,  
			);			
		}
	
		$portfolioposts = get_posts($args);
		
		if(count($portfolioposts)){    
	
			global $post;
	
				$retour ='';	
	
				$retour .='<div class="elpt-portfolio">';			
	
					//Filter
					if ($showfilter != 'no' && $post_type == 'elemenfolio') {

						$retour .='<div class="elpt-portfolio-filter">';						

						//All text filters and variables
						$tax_text = apply_filters( 'elpt_tax_text', $tax_text );
						$tax_text_filter = apply_filters( 'elpt_tax_text_filter', '*' );
						
						if ($tax_text =='') {
							$tax_text = __('All', 'elemenfolio');
						}
						
						if ($showallbtn != 'no') {
							if ($portfolio_type == 'yes' && is_array($taxonomy) && count($taxonomy) > 1 ) {
								$retour .='<button class="portfolio-filter-item item-active" data-filter="'.$tax_text_filter.'" style="background-color:' .';">'.$tax_text.'</button>';
							}
							else if ($portfolio_type != 'yes') {
								$retour .='<button class="portfolio-filter-item item-active" data-filter="'.$tax_text_filter.'" style="background-color:' .';">'.$tax_text.'</button>';
							} 
						}					
								
						$terms = get_terms( array(
							'taxonomy' => 'elemenfoliocategory',
							'hide_empty' => false,
						) );

						$terms = apply_filters( 'elpt_tax_terms_list', $terms );
						

						foreach ( $terms as $term ) {
							$thisterm = $term->name;
							$thistermslug = $term->slug;

							if ($portfolio_type == 'yes' && is_array($taxonomy) && in_array($term->term_id, $taxonomy) && count($taxonomy) > 1 ) {
								$retour .='<button class="portfolio-filter-item" style="background-color:' .';" data-filter=".elemenfoliocategory-'.esc_attr($thistermslug).'">'.esc_html($thisterm).'</button>';
							}
							else if ($portfolio_type != 'yes') {
								$retour .='<button class="portfolio-filter-item" style="background-color:' .';" data-filter=".elemenfoliocategory-'.esc_attr($thistermslug).'">'.esc_html($thisterm).'</button>';
							}
						}									

						$retour .='</div>';						
					}							

					//Columns
					if ($columns == '2') {
						$portfoliocolumns = 'elpt-portfolio-columns-2';
					}
					else if ($columns == '3') {
						$portfoliocolumns = 'elpt-portfolio-columns-3';
					}
					else if ($columns == '5') {
						$portfoliocolumns = 'elpt-portfolio-columns-5';
					}
					else if ($columns == '6') {
						$portfoliocolumns = 'elpt-portfolio-columns-6';
					}
					else {
						$portfoliocolumns = 'elpt-portfolio-columns-4';
					}

					//Columns Mobile
					$portfoliocolumns_mobile = '';

					if ($columns_mobile == '2') {
						$portfoliocolumns_mobile = 'elpt-portfolio-columns-mobile-2';
					}
					else if ($columns_mobile == '3') {
						$portfoliocolumns_mobile = 'elpt-portfolio-columns-mobile-3';
					}

					//Margin
					if ($margin == 'yes' ) {
						$portfoliomargin = 'elpt-portfolio-margin';
					}
					else {
						$portfoliomargin = '';
					}

					//Portfolio style
					if ($style == 'masonry' ) {
						$portfoliostyle = 'elpt-portfolio-style-masonry';
					}
					else if ($style == 'specialgrid1' ) {
						$portfoliostyle = 'elpt-portfolio-special-grid-1';
					}
					else if ($style == 'specialgrid2' ) {
						$portfoliostyle = 'elpt-portfolio-special-grid-2';
					}
					else if ($style == 'specialgrid3' ) {
						$portfoliostyle = 'elpt-portfolio-special-grid-3';
					}
					else if ($style == 'specialgrid4' ) {
						$portfoliostyle = 'elpt-portfolio-special-grid-4';
					}
					else if ($style == 'specialgrid5' ) {
						$portfoliostyle = 'elpt-portfolio-special-grid-5';
					}	
					else if ($style == 'specialgrid6' ) {
						$portfoliostyle = 'elpt-portfolio-special-grid-6';
					}	
					else if ($style == 'purchasedgrid' ) {
						$portfoliostyle = apply_filters( 'powerfolio_custom_style_class_filter', 'elpt-portfolio-purchased-grid');
						$portfolio_isotope = apply_filters( 'powerfolio_custom_isotope_class_filter', 'elpt-portfolio-content-isotope');
						$portfoliocolumns = apply_filters( 'powerfolio_custom_cols_class_filter', 'elpt-portfolio-columns-3');
					}	
					else if ($style == 'grid_builder' ) {
						$portfoliostyle = 'elpt-portfolio-grid-builder';
						$portfolio_isotope = 'elpt-portfolio-content-packery';
					}					
					else {
						$portfoliostyle = 'elpt-portfolio-style-box';
					}
				
	
					$retour .='<div class="elpt-portfolio-content '.$portfolio_isotope.' '.$portfoliostyle.' '.$zoom_effect.' '.$hover.' '.$portfoliocolumns.' '.$portfoliocolumns_mobile.' '. $portfoliomargin.'">';
	
						foreach($portfolioposts as $post){
	
							$postid = $post->ID;
	
							$portfolio_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '' );	
	
							$portfolio_image_ready = '';

							if (is_array($portfolio_image)) {
								$portfolio_image_ready = $portfolio_image[0];
							}
							
	
							//Fancybox or link
							$portfolio_link = get_the_permalink();
	
							$portfolio_link_class = '';
							$portfolio_link_rel = '';
							if ( $linkto == 'image') {
								$portfolio_link = $portfolio_image_ready;
								$portfolio_link_class = 'elpt-portfolio-lightbox';
								$portfolio_link_rel = 'rel=elpt-portfolio_'.$rel_id;
	
							}
							else if ( $linkto == 'image_elementor') {
								$portfolio_link = $portfolio_image_ready;
								$portfolio_link_class = 'elpt-portfolio-elementor-lightbox';
								$portfolio_link_rel = 'rel="elpt-portfolio_'.$rel_id.'"';
	
							}
							
							$classes = join( '  ', get_post_class($postid) ); 
							
							$retour .='<div class="portfolio-item-wrapper '.$classes.'">';
								$retour .='<a href="'.esc_url($portfolio_link) .'" class="portfolio-item '.esc_attr($portfolio_link_class) .'" '.esc_attr($portfolio_link_rel) .' style="background-image: url('.esc_url($portfolio_image_ready).')" title="'.get_the_title().'">';
									$retour .='<img src="'.esc_url($portfolio_image_ready) .'" title="'.get_the_title().'" alt="'.get_the_title().'"/>';
									$retour .='<div class="portfolio-item-infos-wrapper" style="background-color:' .';"><div class="portfolio-item-infos">';
										
										if ($hide_item_title != 'yes' ) {
											$retour .='<div class="portfolio-item-title"><span class="portfolio-item-title-span">'.get_the_title().'</span></div>';
										}

										if ($hide_item_category != 'yes' ) {
											$retour .='<div class="portfolio-item-category">';
												$terms = get_the_terms( $post->ID , 'elemenfoliocategory' );
												if (is_array($terms) || is_object($terms)) {
												foreach ( $terms as $term ) :
														$thisterm = $term->name;
														$retour .='<span class="elpt-portfolio-cat">' .esc_html($thisterm) .'</span>';
													endforeach;
												}									
											$retour .='</div>';
										}
										
									$retour .='</div></div>';
								$retour .='</a>';
							$retour .='</div>';
	
						}
	
					$retour .='</div>';
	
				$retour .='</div>';		
			
			return $retour;
	
			//Reset Query
			wp_reset_postdata();
	
		}	
		
	}

	//Register the shortcode shortcode
	public function powerfolio_add_shortcodes() {	
	  add_shortcode("powerfolio", array( __CLASS__, 'powerfolio_shortcode') );
      add_shortcode("elemenfolio", array( __CLASS__, 'powerfolio_shortcode') );
	}	
}

//Run functions
$shortcodes = new Powerfolio_Shortcodes(); 
$shortcodes->powerfolio_add_shortcodes();