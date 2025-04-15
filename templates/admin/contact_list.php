<div class="wrap">
    <h1><?php esc_html_e( 'Contact List', '6amtech_task' ); ?></h1>
    <p><?php _e( 'The shortcode for the contact list table is [contact_list]', '6amtech_task' ); ?></p>
    <?php if ( isset( $_GET[ 'inserted' ] ) ) : ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Contact added successfully.', '6amtech_task' ); ?></p>
        </div>
    <?php endif ; ?>
    <?php if ( isset( $_GET[ 'contact-deleted' ] ) ) : ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Contact deleted successfully.', '6amtech_task' ); ?></p>
        </div>
    <?php endif ; ?>
    <form action="" method="post">
        <?php
            $table = new _6amTech\Task\Admin\ContactList();
            $table->prepare_items();
            $table->display();
        ?>
    </form>
</div>