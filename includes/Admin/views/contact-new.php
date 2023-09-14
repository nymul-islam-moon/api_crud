<div class="wrap">
    <h1><?php _e('New Contacts', 'api_crud'); ?></h1>

    <form action="" method="POST">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="name"><?php _e( 'Name', 'api_crud' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="name" id="name" class="regular-text" placeholder="Enter Your Name" value="">
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="e-mail"><?php _e( 'E-mail', 'api_crud' ); ?></label>
                    </th>
                    <td>
                        <input type="email" name="email" id="email" class="regular-text" placeholder="Enter Your E-mail" value="">
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="address"><?php _e( 'Address', 'api_crud' ); ?></label>
                    </th>
                    <td>
                        <textarea class="regular-text" name="address" id="address"></textarea>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php wp_nonce_field( 'new_contact' ) ?>
        <?php submit_button( __( 'Add Contact', 'api_crud' ), 'primary', 'submit_contact' ); ?>
    </form>

</div>