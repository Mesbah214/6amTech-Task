<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Address</th>
            <th scope="col">Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php
		global $wpdb;

        $paged    = isset( $_GET['paged'] ) ? max( 1, intval( $_GET['paged'] ) ) : 1;
        $per_page = -1;
        $offset   = ( $paged - 1 ) * $per_page;

        $contacts = contact_list_get_details( [
        	'number' => $per_page,
        	'offset' => $offset,
        ] );

        if ( ! empty( $contacts ) ) {
        	foreach ( $contacts as $index => $contact ) {
        		?>
            <tr>
                <th scope="row"><?php echo $index + 1; ?></th>
                <td><?php echo esc_html( $contact->name ); ?></td>
                <td><?php echo esc_html( $contact->email ); ?></td>
                <td><?php echo esc_html( $contact->phone ); ?></td>
                <td><?php echo esc_html( $contact->address ); ?></td>
                <td><?php echo esc_html( $contact->created_at ); ?></td>
            </tr>
        <?php
        	}
        } else {
        	?>
            <tr>
                <td colspan="5">No contacts found</td>
            </tr>
        <?php } ?>
    </tbody>
</table>
