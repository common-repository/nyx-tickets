<?php wp_nonce_field( 'nyx_settings_nonce', 'nyx_settings_nonce' ); ?>

<h1 class="wp-heading-inline"><?php esc_html_e( 'Nyx settings', 'nyx-ticket' ); ?></h1>
<div class="nyx-bg-white nyx-rounded nyx-mt-8 nyx-p-8 nyx-half-width">

    <div class="nyx-w-full">

        <div class="nyx-grid nyx-grid-cols-1 nyx-gap-4">
            <div class="nyx-col-span-1">
                <label class="nyx-block nyx-mb-2"><strong><?php esc_html_e( 'API key', 'nyx-ticket' ); ?></strong></label>
                <input type="text" name="nyx-api-key" id="nyx-api-key" class="nyx-w-full"
                       value="<?php echo esc_attr( get_option( 'nyx-api-key' ) ); ?>" />
            </div>
        </div>

        <button class="nyx-half-width nyx-block nyx-mt-8 nyx-button nyx-bg-transparent"
                id="make-connection"><?php esc_html_e( 'Save and connect', 'nyx-ticket' ); ?></button>
    </div>

</div>
