<?php

class CPO_Theme {

	private $path;
	private $plugins;
	private $actions;
	
	function __construct() {

		$this->path = get_template_directory() . '/includes/';
		$this->load_dependencies();

		// Recomended Plugins
		$this->plugins = array(
			'kiwi-social-share' 		=> array( 'recommended' => true ),
			'uber-nocaptcha-recaptcha'	=> array( 'recommended' => false ),
		);

		// Recomendeed Actions
		$this->actions = array(
			$actions[] = array(
				'id'          => 'brilliance-req-ac-import-demo-content',
				'title'       => esc_html__( 'Import Demo Content', 'brilliance' ),
				'description' => esc_html__( 'Clicking the button below will add content, widgets and set static front page to your WordPress installation. Click advanced to customize the import process. This procces might take up to 1 min. Please don\'t close the window.', 'brilliance' ),
				'help'        => $this->generate_action_html(),
				'check'       => CPOTheme_Notify_System::check_content_import(),
			),
			array(
				"id"          => 'brilliance-req-ac-install-cpo-companion',
				"title"       => CPOTheme_Notify_System::create_plugin_requirement_title( __( 'Install: CPO Companion', 'brilliance' ), __( 'Activate: CPO Companion', 'brilliance' ), 'cpo-companion' ),
				"description" => __( 'It is highly recommended that you install the CPO Content Types plugin. It will help you manage all the special content types that this theme supports.', 'brilliance' ),
				"check"       => CPOTheme_Notify_System::has_plugin( 'cpo-companion' ),
				"plugin_slug" => 'cpo-companion',
			),
			array(
				"id"          => 'brilliance-req-ac-install-modula',
				"title"       => CPOTheme_Notify_System::create_plugin_requirement_title( __( 'Install: Modula', 'brilliance' ), __( 'Activate: Modula', 'brilliance' ), 'modula-best-grid-gallery' ),
				"description" => __( 'It is highly recommended that you install the Modula plugin.', 'brilliance' ),
				"check"       => CPOTheme_Notify_System::has_plugin( 'modula-best-grid-gallery' ),
				"plugin_slug" => 'modula-best-grid-gallery',
			),
			array(
				"id"          => 'brilliance-req-ac-install-shortpixel',
				"title"       => CPOTheme_Notify_System::create_plugin_requirement_title( __( 'Install: ShortPixel Image Optimizer', 'brilliance' ), __( 'Activate: ShortPixel Image Optimizer', 'brilliance' ), 'shortpixel-image-optimiser' ),
				"description" => __( 'It is highly recommended that you install the ShortPixel Image Optimizer plugin.', 'brilliance' ),
				"check"       => CPOTheme_Notify_System::has_plugin( 'shortpixel-image-optimiser' ),
				"plugin_slug" => 'shortpixel-image-optimiser',
			),
		);
		
		$this->init_epsilon();
		$this->init_welcome_screen();


		add_filter( 'cpo_companion_content', array( $this, 'content_path' ), 99 );
		add_filter( 'cpo_companion_widgets', array( $this, 'widgets_path' ), 99 );
		add_filter( 'cpo_companion_import_option', array( $this, 'import_option' ), 99 );

		add_action( 'customize_register', array( $this, 'customizer' ) );

	}

	private function load_dependencies() {

		require_once $this->path . 'libraries/epsilon-framework/class-epsilon-framework.php';
		require_once $this->path . 'notify-system-checks.php';
		require_once $this->path . 'libraries/welcome-screen/class-epsilon-welcome-screen.php';

	}

	private function init_epsilon() {

		$args = array(
			'controls' => array( 'toggle', 'upsell' ), // array of controls to load
			'sections' => array( 'recommended-actions', 'pro' ), // array of sections to load
			'path'     => '/includes/libraries',
			'backup'   => false,
		);

		new Epsilon_Framework( $args );

	}

	private function init_welcome_screen() {

		Epsilon_Welcome_Screen::get_instance(
			$config = array(
				'theme-name' => 'Brilliance',
				'theme-slug' => 'brilliance',
				'actions'    => $this->actions,
				'plugins'    => $this->plugins,
			)
		);

	}

	public function customizer( $wp_customize ) {

		$wp_customize->add_section(
		  new Epsilon_Section_Recommended_Actions(
		    $wp_customize,
		    'cpo_recomended_section',
		    array(
		      'title'                        => esc_html__( 'Recomended Actions', 'brilliance' ),
		      'social_text'                  => esc_html__( 'We are social', 'brilliance' ),
		      'plugin_text'                  => esc_html__( 'Recomended Plugins', 'brilliance' ),
		      'actions'                      => $this->actions,
		      'plugins'                      => $this->plugins,
		      'theme_specific_option'        => 'brilliance_show_required_actions',
		      'theme_specific_plugin_option' => 'brilliance_show_recommended_plugins',
		      'facebook'                     => 'https://www.facebook.com/cpothemes',
		      'twitter'                      => 'https://twitter.com/cpothemes',
		      'wp_review'                    => true,
		      'priority'                     => 0
		    )
		  )
		);

	}

	private function generate_action_html(){

		$import_actions = array(
		    'import_content'       => esc_html__( 'Import Content', 'brilliance' ),
			'import_widgets'       => esc_html__( 'Import Widgets', 'brilliance' ),
		);

		$import_plugins = array(
			'cpo-companion' => esc_html__( 'CPO Companion', 'brilliance' ),
			'modula-best-grid-gallery' => esc_html__( 'Modula Gallery', 'brilliance' ),
			'shortpixel-image-optimiser' => esc_html__( 'ShortPixel Image Optimizer', 'brilliance' ),
		);

		$plugins_html = '';

		if ( is_customize_preview() ) {
			$url  = 'themes.php?page=%1$s-welcome&tab=%2$s';
			$html = '<a class="button button-primary" id="" href="' . esc_url( admin_url( sprintf( $url, 'brilliance', 'recommended-actions' ) ) ) . '">' . __( 'Import Demo Content', 'brilliance' ) . '</a>';
		} else {
			$html  = '<p><a class="button button-primary cpo-import-button epsilon-ajax-button" data-action="import_demo" id="add_default_sections" href="#">' . __( 'Import Demo Content', 'brilliance' ) . '</a>';
			$html .= '<a class="button epsilon-hidden-content-toggler" href="#welcome-hidden-content">' . __( 'Advanced', 'brilliance' ) . '</a></p>';
			$html .= '<div class="import-content-container" id="welcome-hidden-content">';
			
			foreach ( $import_plugins as $id => $label ) {
				if ( ! CPOTheme_Notify_System::has_plugin( $id ) ) {
					$plugins_html .= $this->generate_checkbox( $id, $label, 'plugins', true );
				}
			}

			if ( '' != $plugins_html ) {
				$html .= '<div class="plugins-container">';
				$html .= '<h4>' . __( 'Plugins', 'brilliance' ) . '</h4>';
				$html .= '<div class="checkbox-group">';
				$html .= $plugins_html;
				$html .= '</div>';
				$html .= '</div>';
			}
			
			$html .= '<div class="demo-content-container">';
			$html .= '<h4>' . __( 'Demo Content', 'brilliance' ) . '</h4>';
			$html .= '<div class="checkbox-group">';
			foreach ( $import_actions as $id => $label ) {
				$html .= $this->generate_checkbox( $id, $label );
			}
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
		}

		return $html;

	}

	private function generate_checkbox( $id, $label, $name = 'options', $block = false ) {
		$string = '<label><input checked type="checkbox" name="%1$s" class="demo-checkboxes"' . ( $block ? ' disabled ' : ' ' ) . 'value="%2$s">%3$s</label>';
		return sprintf( $string, $name, $id, $label );
	}

	// Path to demo content
	public function content_path() {
		return get_template_directory() . '/demo/content.xml';
	}

	public function widgets_path() {
		return get_template_directory() . '/demo/widgets.wie';
	}

	public function import_option() {
		return 'brilliance_content_imported';
	}

}

new CPO_Theme();