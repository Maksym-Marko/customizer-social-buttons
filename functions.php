<?php
// customizer Social Buttons

// create control class
function mx_add_class_social_buttons() {

	class MX_WP_Customize_Social_Control extends WP_Customize_Control {

		public function render_content() {

			$social_buttons_array = maybe_unserialize( $this->value() );

			$name = '_customize-radio-' . $this->id;

			?>

			<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/font-awesome/css/font-awesome.min.css'; ?>">

			<style>
				.mx-template-social-button-el {
					display: none;
				}
				.mx-social-button {
					position: relative;
				}
				.mx-delete-social-button {
					position: absolute;
					top: -5px;
					right: -10px;

				}
			</style>

			<div class="mx-template-social-button-el mx-social-button">
				<i class="" data-icon=""></i>
				<input type="text" value="">
				<button class="mx-delete-social-button">DEL</button>
			</div>

			<!-- main container -->
			<div class="mx-social-buttons-wrap">

				<?php if( $this->value() ) : ?>	

					<?php foreach ($social_buttons_array as $key => $value) { ?>

						<div class="mx-social-button">
							<i class="icon-<?php echo $value['icon'] ?>" data-icon="<?php echo $value['icon'] ?>"></i>
							<input type="text" value="<?php echo $value['url'] ?>">

							<button class="mx-delete-social-button">DEL</button>
						</div>
						
						<!-- var_dump( $value ); -->

					<?php } ?>

				<?php endif; ?>

			</div>

			<br><br>
			<h3>Add new button</h3>
			<!-- add new button -->
			<div class="mx-add-new-social-button">
				
				<label for="mx_add_new_button_icon">Icon</label>
				<select id="mx_add_new_button_icon">
					<option value="facebook">Facebook</option>
					<option value="instagram">Instagram</option>
					<option value="twitter">Twitter</option>
					<option value="youtube">Youtube</option>
				</select>
				<br>
				<label for="mx_add_new_button_url">Url</label>
				<input type="url" id="mx_add_new_button_url" value="" required="required" />

				<button class="mx_add_new_social_button">Add Button</button>

			</div>

			<!-- create input -->
			<br>
			<input type="hidden" id="mx_social_button_input"  name="<?php echo esc_attr( $name ); ?>" <?php echo $this->link(); ?> value="<?php echo $this->value(); ?>" />

			<input type="hidden" id="mx_nonce_request" value="<?php echo wp_create_nonce( 'mx_nonce_request' ); ?>">


		<?php }

	}


}

add_action( 'customize_register', 'mx_add_class_social_buttons' );

// wp ajax
add_action( 'wp_ajax_social_buttons', 'mx_update_social_buttons' );

function mx_update_social_buttons() {

	if( empty( $_POST['nonce'] ) ) wp_die( '0' );

	if( wp_verify_nonce( $_POST['nonce'], 'mx_nonce_request' ) ){

		// code
		$serialize_data = maybe_serialize( $_POST['social_data'] );

		echo $serialize_data;

	}

	wp_die();

}



function mx_theme_customize_register( $wp_customize ) {

	// create panel
	$wp_customize->add_panel(

		'mx_social_buttons_panel',
		array(

			'priority'		=> 10,
			'title'			=> 'Social Buttons',
			'description'	=> 'Set social buttons.'

		)

	);

		// create section
		$wp_customize->add_section(

			'mx_social_buttons_section',
			array(
				'panel'		=> 'mx_social_buttons_panel',
				'title'		=> 'Change Social Buttons',
				'priority'	=> 10
			)
		);


			// create setting
			$social_button_serialized_data = maybe_serialize( 
				array(
					array(
						'icon' => 'facebook',
						'url'	=> 'https://www.facebook.com/'
					),
					array(
						'icon' => 'instagram',
						'url'	=> 'https://www.instagram.com/'
					),
				)
			);

			$wp_customize->add_setting(
				'mx_social_buttons_setting',
				array(

					'default'		=> $social_button_serialized_data,

				)
			);

				// create control
				$wp_customize->add_control(

					new MX_WP_Customize_Social_Control(

						$wp_customize,
						'mx_social_buttons',
						array(
							'label'			=> 'Control Social buttons',
							'type'			=> 'hidden',
							'section'		=> 'mx_social_buttons_section',
							'settings'		=> 'mx_social_buttons_setting'
						)

					)					

				);

}

add_action( 'customize_register', 'mx_theme_customize_register' );

// enqueue
function mx_social_buttons_customizer_live_preview()
{
	wp_enqueue_script( 
		  'mx_social_buttons-themecustomizer',			//Give the script an ID
		  get_template_directory_uri() . '/js/social-customize.js',//Point to file
		  array( 'jquery' ),	//Define dependencies
		  time(),						//Define a version (optional) 
		  true						//Put script in footer?
	);

	wp_localize_script(
		'mx_social_buttons-themecustomizer',
		'social_button_obj',
		array(
			'ajaxurl' => admin_url( 'admin-ajax.php' )
		)
	);

}
add_action( 'customize_controls_enqueue_scripts', 'mx_social_buttons_customizer_live_preview' );