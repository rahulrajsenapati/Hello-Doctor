<?php

defined( 'ABSPATH' ) || die;

class WPFAS_Product_Menu {
	public static function create_menu() {
		$products = add_submenu_page( 'ap_system', 'Premium Products', 'Premium Products', 'manage_options', 'wpfas_products', array( 'WPFAS_Product_Menu', 'products' ) );
		add_action( 'admin_print_styles-' . $products, array( 'WPFAS_Product_Menu', 'products_assets' ) );
	}

	public static function products() { ?>
		<div class="wpfrank-products-container">
			<div class="wpfrank-products-title"><h1>Our Premium Products</h1></div>
			<div class="wpfrank-products">
				<div class="wpfrank-product">
					<div class="wpfrank-product-title">WP Video Album Gallery Pro</div>
					<img class="wpfrank-product-image" src="<?php echo WPFRANK_A_P_SYSTEM . "images/products/WP-Video-Album-Gallery-Pro.jpg"; ?>">
					<div class="wpfrank-product-tagline">Premium Plugin To Add Eye Catching Video Galleries On WordPress Website</div>
					<div class="wpfrank-product-links">
						<a target="_blank" href="https://wpfrank.com/demo/wp-video-album-gallery-pro/" class="wpfrank-link-button wpfrank-try-now">Try Now</a>
						<a target="_blank" href="https://wpfrank.com/account/signup/wp-video-album-gallery-pro" class="wpfrank-link-button wpfrank-buy-now">Buy Now</a>
					</div>
				</div>
				<div class="wpfrank-product">
					<div class="wpfrank-product-title">WP Photo Gallery Pro</div>
					<img class="wpfrank-product-image" src="<?php echo WPFRANK_A_P_SYSTEM . "images/products/WP-Photo-Gallery-Pro.jpg"; ?>">
					<div class="wpfrank-product-tagline">Premium Plugin To Add Eye Catching Photo Galleries On WordPress Website</div>
					<div class="wpfrank-product-links">
						<a target="_blank" href="https://wpfrank.com/demo/wp-photo-gallery-pro/" class="wpfrank-link-button wpfrank-try-now">Try Now</a>
						<a target="_blank" href="https://wpfrank.com/account/signup/wp-photo-gallery-pro" class="wpfrank-link-button wpfrank-buy-now">Buy Now</a>
					</div>
				</div>
				<div class="wpfrank-product">
					<div class="wpfrank-product-title">Appointment Scheduler Pro</div>
					<img class="wpfrank-product-image" src="<?php echo WPFRANK_A_P_SYSTEM . "images/products/Appointment-Scheduler-Pro.jpg"; ?>">
					<div class="wpfrank-product-tagline">Premium Appointment Plugin To Add Booking System On WordPress Website</div>
					<div class="wpfrank-product-links">
						<a target="_blank" href="https://wpfrank.com/demo/appointment-scheduler-pro/" class="wpfrank-link-button wpfrank-try-now">Try Now</a>
						<a target="_blank" href="https://wpfrank.com/account/signup/appointment-scheduler-pro" class="wpfrank-link-button wpfrank-buy-now">Buy Now</a>
					</div>
				</div>
				<div class="wpfrank-product">
					<div class="wpfrank-product-title">Ultimate Responsive Image Slider Pro</div>
					<img class="wpfrank-product-image" src="<?php echo WPFRANK_A_P_SYSTEM . "images/products/Ultimate-Responsive-Image-Slider-Pro.jpg"; ?>">
					<div class="wpfrank-product-tagline">Premium WordPress Slider Plugin With Five Elegant Design Layouts</div>
					<div class="wpfrank-product-links">
						<a target="_blank" href="https://wpfrank.com/demo/ultimate-responsive-image-slider-pro/" class="wpfrank-link-button wpfrank-try-now">Try Now</a>
						<a target="_blank" href="https://wpfrank.com/account/signup/ultimate-responsive-image-slider-pro" class="wpfrank-link-button wpfrank-buy-now">Buy Now</a>
					</div>
				</div>
				<div class="wpfrank-product">
					<div class="wpfrank-product-title">Flickr Album Gallery Pro</div>
					<img class="wpfrank-product-image" src="<?php echo WPFRANK_A_P_SYSTEM . "images/products/Flickr-Album-Gallery-Pro.jpg"; ?>">
					<div class="wpfrank-product-tagline">Premium Flickr Plugin To Fetch And Display Albums On WordPress Website</div>
					<div class="wpfrank-product-links">
						<a target="_blank" href="https://wpfrank.com/demo/flickr-album-gallery-pro/" class="wpfrank-link-button wpfrank-try-now">Try Now</a>
						<a target="_blank" href="https://wpfrank.com/account/signup/flickr-album-gallery-pro" class="wpfrank-link-button wpfrank-buy-now">Buy Now</a>
					</div>
				</div>
				<div class="wpfrank-product">
					<div class="wpfrank-product-title">WP Lightbox Gallery Pro</div>
					<img class="wpfrank-product-image" src="<?php echo WPFRANK_A_P_SYSTEM . "images/products/WP-Lightbox-Gallery-Pro.jpg"; ?>">
					<div class="wpfrank-product-tagline">Premium Plugin To Add Photo Galleries with Lightbox On WordPress Website</div>
					<div class="wpfrank-product-links">
						<a target="_blank" href="https://wpfrank.com/demo/wp-lightbox-gallery-pro/" class="wpfrank-link-button wpfrank-try-now">Try Now</a>
						<a target="_blank" href="https://wpfrank.com/account/signup/wp-lightbox-gallery-pro" class="wpfrank-link-button wpfrank-buy-now">Buy Now</a>
					</div>
				</div>
				<div class="wpfrank-product">
					<div class="wpfrank-product-title">All In One Premium Plugins Bundle</div>
					<img class="wpfrank-product-image" src="<?php echo WPFRANK_A_P_SYSTEM . "images/products/All-In-One Premium-Plugins-Bundle.jpg"; ?>">
					<div class="wpfrank-product-tagline">All In One Premium Plugins Bundle Package for WordPress Website</div>
					<div class="wpfrank-product-links">
						<a target="_blank" href="https://wpfrank.com/demo/" class="wpfrank-link-button wpfrank-try-now">Try Now</a>
						<a target="_blank" href="https://wpfrank.com/account/signup/wordpress-premium-plugins-bundle" class="wpfrank-link-button wpfrank-buy-now">Buy Now</a>
					</div>
				</div>
			</div>
		</div>
	<?php
	}

	public static function products_assets() {
		wp_enqueue_style( 'wpfrank-products', WPFRANK_A_P_SYSTEM . 'css/wpfrank-products.css', array(), '1.0', 'all' );
	}
}
add_action( 'admin_menu' , array( 'WPFAS_Product_Menu', 'create_menu' ) );
?>