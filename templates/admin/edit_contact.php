<div class="wrap">
    <h1 class="wp-heading-inline"><?php esc_html_e( 'Edit Contact', '6amtech_task' ); ?></h1>
    <?php if ( isset( $_GET['contact-updated'] ) ) { ?>
        <div class="notice notice-success is-dismissible">
            <p><?php esc_html_e( 'Contact updated successfully.', '6amtech_task' ); ?></p>
        </div>
    <?php } ?>
    <p><?php esc_html_e( 'Change the required fields to update the contact' ); ?></p>
    <form action="" method="post" class="contact-form">
        <table class="form-table">
            <tr valign="top">
                <td scope="row"><label for="name"><?php esc_html_e( 'Name', '6amtech_task' ); ?></label></td>
                <td>
                    <input id="name" name="name" type="text" class="regular-text" value="<?php echo esc_attr( $contact->name ); ?>" />
                    <?php if ( $this->has_error( 'name' ) ) { ?>
                        <p class="description error"><?php echo esc_html( $this->get_error( 'name' ) ); ?></p>
                    <?php } ?>
                </td>
            </tr>
            <tr valign="top">
                <td scope="row"><label for="email"><?php esc_html_e( 'Email', '6amtech_task' ); ?></label></td>
                <td>
                    <input id="email" name="email" type="email" class="regular-text" value="<?php echo esc_attr( $contact->email ); ?>" />
                    <?php if ( $this->has_error( 'email' ) ) { ?>
                        <p class="description error"><?php echo esc_html( $this->get_error( 'email' ) ); ?></p>
                    <?php } ?>
                </td>
            </tr>
            <tr valign="top">
                <td scope="row"><label for="phone"><?php esc_html_e( 'Phone Number', '6amtech_task' ); ?></label></td>
                <td><input id="phone" name="phone" type="text" class="regular-text" value="<?php echo esc_attr( $contact->phone ); ?>" /></td>
            </tr>
            <tr valign="top">
                <td scope="row"><label for="address"><?php esc_html_e( 'Address', '6amtech_task' ); ?></label></td>
                <td><textarea id="address" name="address" class="regular-text"><?php echo esc_textarea( $contact->address ); ?></textarea></td>
            </tr>
        </table>

        <input type="hidden" name="id" value="<?php echo esc_attr( $contact->id ); ?>" />
        <?php wp_nonce_field( 'add_contact' ); ?>
        <?php submit_button( __( 'Update Contact', '6amtech_task' ), 'primary submit-contact', 'update_contact' ); ?>
    </form>
</div>
