<?php

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

function marketing_cta_menu() {
	add_options_page(
            'Marketing CTA',
            'Marketing CTA',
            'administrator',
            'marketing-cta',
            'marketing_cta_settings_page'
    );
}

function marketing_cta_settings_page() {
	?>
	<div class="wrap">
		<h1>Marketing CTA</h1>
		<form method="post" action="options.php">
			<?php
			settings_fields("content");
            settings_fields("cta_settings");
			do_settings_sections("marketing-cta");
			submit_button();
			?>
		</form>
	</div>
	<?php
}

function cta_text_display() {
	printf(
		wp_editor(
			get_option('cta_text'),
			'cta_text',
			[
				'textarea_rows' => 10
			]
		)
	);
}

function cta_paragraph_display() {
    printf(
        '<input type="number" name="cta_paragraph" value="%s" />',
        get_option('cta_paragraph')
    );
}

function cta_enabled_display() {
    printf(
        '<input type="checkbox" name="cta_enabled" value="1" %s />',
        get_option('cta_enabled') ? 'checked' : ''
    );
}

function cta_tag_filter_display() {
    printf(
        '<input type="text" name="cta_tag_filter" value="%s" />',
        get_option('cta_tag_filter')
    );
}

function marketing_cta_register_settings_fields() {

    // Content
	add_settings_section(
            "content",
            "Contenuto",
            null,
            "marketing-cta"
    );
	add_settings_field(
            "cta_content",
            "Contenuto CTA",
            "cta_text_display",
            "marketing-cta",
            "content"
    );

    register_setting(
            "content",
            "cta_text"
    );

    // Settings
	add_settings_section(
            "cta_settings",
            "Impostazioni",
            null,
            "marketing-cta"
    );
    add_settings_field(
            "cta_enabled",
            "Abilita CTA",
            "cta_enabled_display",
            "marketing-cta",
            "cta_settings"
    );
	add_settings_field(
            "cta_paragraph",
            "Paragrafo",
            "cta_paragraph_display",
            "marketing-cta",
            "cta_settings"
    );
    add_settings_field(
            'cta_tag_filter',
            "Tag su cui abilitare (separati da virgole)",
            "cta_tag_filter_display",
            "marketing-cta",
            "cta_settings"
    );
    register_setting( "cta_settings","cta_paragraph");
    register_setting( "cta_settings", "cta_enabled");
    register_setting("cta_settings", "cta_tag_filter" );
}

//Register menu and settings
add_action('admin_menu', 'marketing_cta_menu');
add_action('admin_init', 'marketing_cta_register_settings_fields');
