<?php
/**
 * Icon Picker Customizer Control - O2 Customizer Library
 *
 * This control adds an icon picker which allows you to easily pick
 * icons from Font Awesome, Genericons and Dashicons.
 *
 * Icon Picker is a part of O2 library, which is a
 * free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this library. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package O2 Customizer Library
 * @subpackage Icon Picker
 * @since 0.1
 */
if( !function_exists('remedial_icon_add_icon_picker_control') ) :
	function remedial_icon_add_icon_picker_control( $wp_customize ) {
		class Remedial_Icon_Customizer_Icon_Picker_Control extends WP_Customize_Control {

			public $type = 'icon-picker'; 
	 
			public function enqueue() {
				wp_enqueue_script( 'icon-picker-js', trailingslashit( get_template_directory_uri() ) . 'js/fontawesome-iconpicker.min.js', array( 'jquery' )  );
			    wp_enqueue_style( 'icon-picker-css', trailingslashit( get_template_directory_uri() ) . 'css/fontawesome-iconpicker.min.css' );
			    wp_enqueue_style( 'font-awesome', trailingslashit( get_template_directory_uri() ) . 'css/font-awesome.min.css' );
			   // wp_enqueue_script( 'icon-picker-jsss', trailingslashit( get_template_directory_uri() ) . 'js/aaa.js',  array( 'jquery' )  );
			}

			public function render_content() {
			

			?>
				<label data-title="Inline picker">
	                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	                <input type="text" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> class="faip" data-placement="inline"/>
	            </label>
	            <script type="text/javascript">
					jQuery(function($) {  
						//$('.faip').click(function() {
							$('.faip').iconpicker(); 
						   // $('.iconpicker-popover').toggle();
					    //});
					});
				</script>
			<?php }

		}
	}
endif;
add_action( 'customize_register', 'remedial_icon_add_icon_picker_control' );
