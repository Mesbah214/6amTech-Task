<div class="wrap">
    <h1><?php esc_html_e( 'Contact List', '6amtech_task' ); ?></h1>
    <form action="" method="post">
        <?php
            $table = new _6amTech\Task\Admin\ContactList();
            $table->prepare_items();
            $table->display();
        ?>
    </form>
</div>