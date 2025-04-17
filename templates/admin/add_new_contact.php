<div class="wrap">
    <h1 class="wp-heading-inline"><?php esc_html_e( 'Add New Contact', '6amtech_task' ); ?></h1>
    <p><?php esc_html_e( 'Fill up the form to add new contact to the contact list.' ); ?></p>
    <form action="" method="post" class="contact-form">
        <table class="form-table">
            <tr valign="top">
                <td scope="row"><label for="name"><?php esc_html_e( 'Name', '6amtech_task' ); ?></label></td>
                <td>
                    <input id="name" name="name" type="text" class="regular-text" />
                    <?php if ( $this->has_error( 'name' ) ) { ?>
                        <p class="description error"><?php echo esc_html( $this->get_error( 'name' ) ); ?></p>
                    <?php } ?>
                </td>
            </tr>
            <tr valign="top">
                <td scope="row"><label for="email"><?php esc_html_e( 'Email', '6amtech_task' ); ?></label></td>
                <td>
                    <input id="email" name="email" type="email" class="regular-text" />
                    <?php if ( $this->has_error( 'email' ) ) { ?>
                        <p class="description error"><?php echo esc_html( $this->get_error( 'email' ) ); ?></p>
                    <?php } ?>
                </td>
            </tr>
            <tr valign="top">
                <td scope="row"><label for="phone"><?php esc_html_e( 'Phone Number', '6amtech_task' ); ?></label></td>
                <td><input id="phone" name="phone" type="text" class="regular-text" /></td>
            </tr>
            <tr valign="top">
                <td scope="row"><label for="address"><?php esc_html_e( 'Address', '6amtech_task' ); ?></label></td>
                <td><textarea id="address" name="address" class="regular-text"></textarea></td>
            </tr>
        </table>

        <?php wp_nonce_field( 'add_contact' ); ?>
        <?php submit_button( __( 'Add Contact', '6amtech_task' ), 'primary submit-contact', 'add_contact' ); ?>
    </form>
</div>
