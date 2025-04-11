<div class="wrap">
	<h1><?php esc_attr_e( 'Welcome Message', '6amtech_task' ); ?></h1>
	<p><?php esc_attr_e( 'Enter the custom welcome message to display at the top of every post!', '6amtech_task' ); ?></p>
    <form method="post" action="options.php">
        <?php
		// Output security fields for the registered setting "welcome_message"
		settings_fields( 'welcome_message_options_group' );

        // Output setting sections and their fields
        do_settings_sections( 'welcome_message' );

        // Output save settings button
        submit_button( __( 'Save Settings', '6amtech_task' ), 'primary', 'submit', true, [ 'id' => 'submit' ] );
        ?>
    </form>

</div> <!-- .wrap -->