<?php
/**
 * Peanut Theme Customizer
 *
 * @package Peanut
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function peanut_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'peanut_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'peanut_customize_partial_blogdescription',
			)
		);
	}
}
add_action( 'customize_register', 'peanut_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function peanut_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function peanut_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function peanut_customize_preview_js() {
	wp_enqueue_script( 'peanut-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'peanut_customize_preview_js' );

/**
 * Provide the option to customize sections on the front page.
 */
add_action('customize_register','peanut_customizer_options');
function peanut_customizer_options( $wp_customize ) {

	// 'Peanut' Panel
	$wp_customize->add_panel('peanut_fp_panel',array(
		'title'=>'Front Page Layout',
		'description'=> 'Customize various elements of the Peanut Front Page',
		'priority'=> 10,
	));

		// 'Carousel' Section
		$wp_customize->add_section('carousel_section',array(
			'title'=>'Carousel Section',
			'priority'=>10,
			'panel'=>'peanut_fp_panel',
			'description' => __( 'A default stock image will always appear in the first slide until you replace it with your own. <i>There is no option to hide the carousel.</i>', 'peanut' ),
		));

			$wp_customize->add_setting(
				'carousel_img_1',
				array(
					'type' => 'theme_mod',
					'sanitize_callback' => 'peanut_sanitize_function',
					'default_image' => ''
					)
			);

			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize, 'carousel_img_1',
					array(
					'label' => __( 'Image One:', 'peanut' ),
					'section' => 'carousel_section',
					'mime_type' => '',
			) ) );

			$wp_customize->add_setting(
				'carousel_img_2',
				array(
					'type' => 'theme_mod',
					'sanitize_callback' => 'peanut_sanitize_function',
					)
			);

			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize, 'carousel_img_2',
					array(
					'label' => __( 'Image Two:', 'peanut' ),
					'section' => 'carousel_section',
					'mime_type' => 'image',
			) ) );

			$wp_customize->add_setting(
				'carousel_img_3',
				array(
					'type' => 'theme_mod',
					'sanitize_callback' => 'peanut_sanitize_function',
					)
			);

			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize, 'carousel_img_3',
					array(
					'label' => __( 'Image Three:', 'peanut' ),
					'section' => 'carousel_section',
					'mime_type' => 'image',
			) ) );

			$wp_customize->add_setting(
				'carousel_img_4',
				array(
					'type' => 'theme_mod',
					'sanitize_callback' => 'peanut_sanitize_function',
					)
			);

			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize, 'carousel_img_4',
					array(
					'label' => __( 'Image Four:', 'peanut' ),
					'section' => 'carousel_section',
					'mime_type' => 'image',
			) ) );

			$wp_customize->add_setting(
				'carousel_img_5',
				array(
					'type' => 'theme_mod',
					'sanitize_callback' => 'peanut_sanitize_function',
					)
			);

			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize, 'carousel_img_5',
					array(
					'label' => __( 'Image Five:', 'peanut' ),
					'section' => 'carousel_section',
					'mime_type' => 'image',
			) ) );

			$floating_prompt_destination = array(
				'\#portfolio' => 'Portfolio',
				'\#about' => 'About',
				'\#contact' => 'Contact',
				'' => 'N/A'
			);

			$wp_customize->add_setting(
				'floating_prompt_destination',
				array(
					'default' => '\#portfolio',
					'type' => 'theme_mod',
					'sanitize_callback' => 'peanut_sanitize_function',
					)
			);

			$wp_customize->add_control(
				'floating_prompt_destination',
				array(
					'label' => __( 'Select floating prompt destination section.', 'peanut' ),
					'description' => 'To hide, select \'N/A\'',
					'section' => 'carousel_section',
					'settings' => 'floating_prompt_destination',
					'type' => 'select',
					'choices' => $floating_prompt_destination
				)
			);

		// 'Portfolio' Section
		$wp_customize->add_section('portfolio_section',array(
			'title'=>'Portfolio Section',
			'priority'=>10,
			'panel'=>'peanut_fp_panel',
			'description' => __( 'To populate this section, create and publish a new \'Photo Collection\' post type (included with this theme), making sure to include a featured image. Then find your newly created collection in <i><b>Photo Collections > All Photo Collections</b></i> and in the quick edit menu, select <i><b>Stick to Front Page Portfolio</b></i> under \'Peanut Theme Options\'. <br/><br/> This section formats best when populated with collections in multiples of 3.', 'peanut' ),
		));

			// 'Portfolio' Settings
			$wp_customize->add_setting(
				'display_portfolio_section',
				array(
					'default' => true,
					'type' => 'theme_mod',
					'sanitize_callback' => 'peanut_sanitize_function',
					)
			);

			$wp_customize->add_control(
				'display_portfolio_section',
				array(
					'label' => __( 'Display \'Portfolio\' Section?', 'peanut' ),
					'section' => 'portfolio_section',
					'settings' => 'display_portfolio_section',
					'type' => 'checkbox'
				)
			);

			$wp_customize->add_setting(
				'portfolio_section_header',
				array(
					'default' => 'Selected Works',
					'type' => 'theme_mod',
					'sanitize_callback' => 'peanut_sanitize_function',
					)
			);

			$wp_customize->add_control(
				'portfolio_section_header',
				array(
					'label' => __( '\'Portfolio\' Section Header', 'peanut' ),
					'description' => 'Leave empty to hide this header.',
					'section' => 'portfolio_section',
					'settings' => 'portfolio_section_header',
					'type' => 'text'
				)
			);

			$wp_customize->add_setting(
				'portfolio_archive_button_text',
				array(
					'default' => 'See portfolio',
					'type' => 'theme_mod',
					'sanitize_callback' => 'peanut_sanitize_function',
					)
			);

			$wp_customize->add_control(
				'portfolio_archive_button_text',
				array(
					'label' => __( 'Archive Button Text', 'peanut' ),
					'description' => 'Leave empty to hide this button.',
					'section' => 'portfolio_section',
					'settings' => 'portfolio_archive_button_text',
					'type' => 'text'
				)
			);

		// 'About' Section
		$wp_customize->add_section('about_section',array(
			'title'=>'About Section',
			'priority'=>10,
			'panel'=>'peanut_fp_panel',
		));

			// 'About' Settings
			$wp_customize->add_setting(
				'display_about_section',
				array(
					'default' => true,
					'type' => 'theme_mod',
					'sanitize_callback' => 'peanut_sanitize_function',
					)
			);

			$wp_customize->add_control(
				'display_about_section',
				array(
					'label' => __( 'Display \'About\' Section?', 'peanut' ),
					'section' => 'about_section',
					'settings' => 'display_about_section',
					'type' => 'checkbox'
				)
			);

			$wp_customize->add_setting(
				'about_section_header',
				array(
					'default' => 'About Me',
					'type' => 'theme_mod',
					'sanitize_callback' => 'peanut_sanitize_function',
					)
			);

			$wp_customize->add_control(
				'about_section_header',
				array(
					'label' => __( '\'About\' Section Header', 'peanut' ),
					'section' => 'about_section',
					'settings' => 'about_section_header',
					'type' => 'text'
				)
			);

			$wp_customize->add_setting(
				'about_section_img',
				array(
					'type' => 'theme_mod',
					'sanitize_callback' => 'peanut_sanitize_function',
					)
			);

			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize, 'about_section_img',
					array(
					'label' => __( 'Profile Picture', 'peanut' ),
					'section' => 'about_section',
					'description' => 'By default this field is empty.',
					'mime_type' => 'image',
			) ) );

			$wp_customize->add_setting(
				'about_section_bio',
				array(
					'default' => 'This is a little something about me.',
					'type' => 'theme_mod',
					'sanitize_callback' => 'peanut_sanitize_function',
					)
			);

			$wp_customize->add_control(
				'about_section_bio',
				array(
					'label' => __( 'Bio', 'peanut' ),
					'section' => 'about_section',
					'description' => 'Leave empty to hide this text area.',
					'settings' => 'about_section_bio',
					'type' => 'textarea'
				)
			);

		// 'Contact' Section
		$wp_customize->add_section('contact_section',array(
			'title'=>'Contact Section',
			'priority'=>10,
			'panel'=>'peanut_fp_panel',
		));

			// 'Contact' Settings
			$wp_customize->add_setting(
				'display_contact_section',
				array(
					'default' => true,
					'type' => 'theme_mod',
					'sanitize_callback' => 'peanut_sanitize_function',
				)
			);

			$wp_customize->add_control(
				'display_contact_section',
				array(
					'label' => __( 'Display \'Contact\' Section?', 'peanut' ),
					'section' => 'contact_section',
					'settings' => 'display_contact_section',
					'type' => 'checkbox'
				)
			);

			$wp_customize->add_setting(
				'contact_section_header',
				array(
					'default' => 'Contact Me',
					'type' => 'theme_mod',
					'sanitize_callback' => 'peanut_sanitize_function',
					)
			);

			$wp_customize->add_control(
				'contact_section_header',
				array(
					'label' => __( '\'Contact\' Section Header', 'peanut' ),
					'description' => 'Leave empty to hide this header.',
					'section' => 'contact_section',
					'settings' => 'contact_section_header',
					'type' => 'text'
				)
			);

			$wp_customize->add_setting(
				'contact_section_textarea',
				array(
					'default' => 'Get in touch, I\'d love to chat.',
					'type' => 'theme_mod',
					'sanitize_callback' => 'peanut_sanitize_function',
					)
			);

			$wp_customize->add_control(
				'contact_section_textarea',
				array(
					'label' => __( 'Contact Area Blurb', 'peanut' ),
					'description' => 'Leave empty to hide this text area.',
					'section' => 'contact_section',
					'settings' => 'contact_section_textarea',
					'type' => 'textarea'
				)
			);

			$wp_customize->add_setting(
				'display_contact_form',
				array(
					'default' => true,
					'type' => 'theme_mod',
					'sanitize_callback' => 'peanut_sanitize_function',
					)
			);

			$wp_customize->add_control(
				'display_contact_form',
				array(
					'label' => __( 'Display the Contact Form?', 'peanut' ),
					'section' => 'contact_section',
					'settings' => 'display_contact_form',
					'type' => 'checkbox'
				)
			);

	// Custom Colors and Fonts Panel
	$wp_customize->add_panel( 'peanut_fonts_colors', array(
		'title'       => __( 'Colors and Fonts', 'peanut' ),
		'description'=> 'Fully customise the theme colors and choose from common Google Fonts',
		'priority'       => 24,
	) );

		// Color Picker Section
		$wp_customize->add_section('peanut_color_picker_section',array(
			'title'=>'Theme Colors',
			'priority'=>10,
			'panel'=>'peanut_fonts_colors',
			'description' => __( 'Choose the theme\'s five main colors.' ),
		));

		// Add in custom color settings and controls (repeats five times)
		$wp_customize->add_setting(
			'peanut_neutral_color', //give it an ID
			array(
				'default' => '#f0f0f0', // Give it a default
			)
		);
		
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'peanut_custom_neutral_color', //give it an ID
				array(
					'label'      => __( 'Neutral Color', 'peanut' ), //set the label to appear in the Customizer
					'section'    => 'peanut_color_picker_section', //select the section for it to appear under  
					'settings'   => 'peanut_neutral_color' //pick the setting it applies to
				)
			)
		);

		$wp_customize->add_setting(
			'peanut_dark_color', //give it an ID
			array(
				'default' => '#0e1111', // Give it a default
			)
		);
		
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'peanut_custom_dark_color', //give it an ID
				array(
					'label'      => __( 'Dark Color', 'peanut' ), //set the label to appear in the Customizer
					'section'    => 'peanut_color_picker_section', //select the section for it to appear under  
					'settings'   => 'peanut_dark_color' //pick the setting it applies to
				)
			)
		);

		$wp_customize->add_setting(
			'peanut_midtone_color', //give it an ID
			array(
				'default' => '#e9e9e9', // Give it a default
			)
		);
		
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'peanut_custom_midtone_color', //give it an ID
				array(
					'label'      => __( 'Midtone Color', 'peanut' ), //set the label to appear in the Customizer
					'section'    => 'peanut_color_picker_section', //select the section for it to appear under  
					'settings'   => 'peanut_midtone_color' //pick the setting it applies to
				)
			)
		);

		$wp_customize->add_setting(
			'peanut_accent_color_1', //give it an ID
			array(
				'default' => '#26867c', // Give it a default
			)
		);
		
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'peanut_custom_accent_color_1', //give it an ID
				array(
					'label'      => __( 'First Accent Color', 'peanut' ), //set the label to appear in the Customizer
					'section'    => 'peanut_color_picker_section', //select the section for it to appear under  
					'settings'   => 'peanut_accent_color_1' //pick the setting it applies to
				)
			)
		);

		$wp_customize->add_setting(
			'peanut_accent_color_2', //give it an ID
			array(
				'default' => '#545454', // Give it a default
			)
		);
		
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'peanut_custom_accent_color_2', //give it an ID
				array(
					'label'      => __( 'Second Accent Color', 'peanut' ), //set the label to appear in the Customizer
					'section'    => 'peanut_color_picker_section', //select the section for it to appear under  
					'settings'   => 'peanut_accent_color_2' //pick the setting it applies to
				)
			)
		);

		// Font Picker Section
		$wp_customize->add_section('peanut_font_picker_section',array(
			'title'=>'Google Fonts',
			'priority'=>10,
			'panel'=>'peanut_fonts_colors',
			'description' => __( 'Choose the fonts for the theme\'s headings and paragraph text. For more information head to <a href="https://google.com/fonts">Google Fonts</a>.' )
		));

		$font_choices = array(
			'Cormorant Garamond:300,300italic,400,400italic,700,700italic' => 'Cormorant Garamond',
			'Josefin Sans:300,300italic,400,400italic,700,700italic' => 'Josefin Sans',
			'Lato:300,300italic,400,400italic,700,700italic' => 'Lato',
			'Merriweather:300,300italic,400,400italic,700,700italic' => 'Merriweather',
			'Montserrat:300,300italic,400,400italic,700,700italic' => 'Montserrat',
			'Open Sans:300,300italic,400,400italic,700,700italic' => 'Open Sans',
			'Raleway:300,300italic,400,400italic,700,700italic' => 'Raleway',
			'Roboto:300,300italic,400,400italic,700,700italic' => 'Roboto',
			'Source Serif Pro:300,300italic,400,400italic,700,700italic' => 'Source Serif Pro',
			'Spectral:300,300italic,400,400italic,700,700italic' => 'Spectral',
		);

		$font_weight_choices = array(
			'300' => 'Light',
			'400' => 'Normal',
			'700' => 'Heavy',
		);

		$wp_customize->add_setting( 'peanut_headings_fonts', array(
			'default' => 'Cormorant Garamond:300,300italic,400,400italic,700,700italic',
			'sanitize_callback' => 'peanut_sanitize_fonts',
			'type' => 'theme_mod',
			)
		);

		$wp_customize->add_control(
			'peanut_headings_fonts',
			array(
				'type' => 'select',
				'description' => __('Select a font for all heading text.', 'peanut'),
				'section' => 'peanut_font_picker_section',
				'choices' => $font_choices
			)
		);

		$wp_customize->add_setting( 'peanut_headings_fonts_sizes', array(
			'default' => '300',
			'type' => 'theme_mod',
			'sanitize_callback' => 'peanut_sanitize_function',
			)
		);

		$wp_customize->add_control(
			'peanut_headings_fonts_sizes',
			array(
				'type' => 'select',
				'description' => __('Select a thickness for the heading font.', 'peanut'),
				'section' => 'peanut_font_picker_section',
				'choices' => $font_weight_choices
			)
		);

		$wp_customize->add_setting( 'peanut_body_fonts', array(
			'default' => 'Roboto:300,300italic,400,400italic,700,700italic',
			'sanitize_callback' => 'peanut_sanitize_fonts',
			'type' => 'theme_mod',
			)
		);

		$wp_customize->add_control( 'peanut_body_fonts', array(
				'type' => 'select',
				'description' => __( 'Select a font for all body text.', 'peanut' ),
				'section' => 'peanut_font_picker_section',
				'choices' => $font_choices
			)
		);

		$wp_customize->add_setting( 'peanut_body_fonts_sizes', array(
			'default' => '300',
			'type' => 'theme_mod',
			'sanitize_callback' => 'peanut_sanitize_function',
			)
		);

		$wp_customize->add_control(
			'peanut_body_fonts_sizes',
			array(
				'type' => 'select',
				'description' => __('Select a thickness for the body font.', 'peanut'),
				'section' => 'peanut_font_picker_section',
				'choices' => $font_weight_choices
			)
		);

	function peanut_sanitize_function( $input ) {
		return wp_kses_post( force_balance_tags( $input ) );
	}

}


/**
 * Remove header image and widgets option from theme customizer.
 */
add_action( 'customize_register', 'peanut_remove_customizer_elements' );
function peanut_remove_customizer_elements( $wp_customize ) {
 $wp_customize->remove_control( 'show_on_front' );
 $wp_customize->remove_control( 'header_image' );
 $wp_customize->remove_section( 'background_image' );
 $wp_customize->remove_section( 'static_front_page' );
 $wp_customize->remove_section( 'colors' );
}
