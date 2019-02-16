<?php
/**
 * clean Theme Customizer
 *
 * @package Remedial     
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function remedial_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'remedial_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function remedial_customize_preview_js() {
	wp_enqueue_script( 'remedial_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'remedial_customize_preview_js' );


add_action( 'wp_head','remedial_customizer_service_color' );

function remedial_customizer_service_color() {
	for ($i=1; $i < 7; $i++) { 
		switch ($i) {
			case '1':
				$color = '#5daae0';
				break;
			case '3':
				$color = '#00ba71';
				break;
			default:
				$color = '#ea4640';
				break;
		}
		if( get_theme_mod('service_color_'.$i,$color) ) {
				
			$service_color = get_theme_mod( 'service_color_'.$i,$color);  ?>
			
			<style type="text/css">
				.services-wrapper .service:nth-of-type(<?php echo $i; ?>) .service-content:hover h4 a	
			    {
					color: <?php echo esc_html($service_color); ?>;
				}
				.services-wrapper .service:nth-of-type(<?php echo $i; ?>) .service-content:hover p a	
			    {
					background-color: <?php echo esc_html($service_color); ?>;
				}
				.services-wrapper .service:nth-of-type(<?php echo $i; ?>) .icon-wrapper .fa
				{
					color: <?php echo esc_html($service_color); ?>;
				}

			</style><?php
		}

	}
}