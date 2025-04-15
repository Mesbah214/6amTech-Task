<!-- TODO: Add pagination to the contact list table -->
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Address</th>
            <th scope="col">Created At</th>
            <th scope="col">Actions</th>
            <!-- Add more columns as needed based on your database structure -->
        </tr>
    </thead>
    <tbody>
        <?php
        global $wpdb;

        $paged = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
        $per_page = 5;
        $offset = ($paged - 1) * $per_page;

        $total = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}contact_list");
        $total_pages = ceil($total / $per_page);

        $contacts = contact_list_get_details([
            'number' => $per_page,
            'offset' => $offset,
        ]);

        if (!empty($contacts)) :
            foreach ($contacts as $index => $contact) :
        ?>
            <tr>
                <th scope="row"><?php echo $index + 1; ?></th>
                <td><?php echo esc_html($contact->name); ?></td>
                <td><?php echo esc_html($contact->email); ?></td>
                <td><?php echo esc_html($contact->phone); ?></td>
                <td><?php echo esc_html($contact->address); ?></td>
                <td><?php echo esc_html($contact->created_at); ?></td>
                <td>
                    <a href="<?php echo esc_url(admin_url('admin.php?page=6amtech_task_add_new_contact&action=edit&id=' . $contact->id)); ?>" class="btn btn-primary">Edit</a>
                    <a href="<?php echo esc_url(admin_url('admin.php?page=6amtech_task_add_new_contact&action=delete&id=' . $contact->id)); ?>" class="btn btn-danger">Delete</a>
                </td>
                <!-- Add more cells as needed based on your database structure -->
            </tr>
        <?php
            endforeach;
        else :
        ?>
            <tr>
                <td colspan="5">No contacts found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php if ($total_pages > 1): ?>
    <nav>
        <ul class="pagination">
            <?php global $wp; ?>
            <?php $current_url = home_url(add_query_arg(array(), $wp->request)); ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo ($i === $paged) ? 'active' : ''; ?>">
                    <a class="page-link" href="<?php echo esc_url(add_query_arg('paged', $i, $current_url)); ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>
