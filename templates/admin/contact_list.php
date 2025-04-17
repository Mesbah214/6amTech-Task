<div class="wrap">
    <h1><?php esc_html_e( 'Contact List', '6amtech_task' ); ?></h1>
    <p>
        <?php esc_html_e( 'To show the contact list on the frontend, use the following shortcode:', '6amtech_task' ); ?>
        <code>[contact_list]</code>
    </p>
    <?php if ( isset( $_GET['inserted'] ) ) { ?>
        <div class="notice notice-success is-dismissible">
            <p><?php esc_html_e( 'Contact added successfully.', '6amtech_task' ); ?></p>
        </div>
    <?php } ?>
    <?php if ( isset( $_GET['contact-deleted'] ) ) { ?>
        <div class="notice notice-success is-dismissible">
            <p><?php esc_html_e( 'Contact deleted successfully.', '6amtech_task' ); ?></p>
        </div>
    <?php } ?>
    <form action="" method="post">
        <?php
			$table = new _6amTech\Task\Admin\ContactList();
            $table->prepare_items();
            $table->display();
        ?>
    </form>
</div>
