<?php wp_nonce_field( 'ticket_area_nonce', 'ticket_area_nonce' ); ?>

<div id="nyx-ticket-admin-boxes" class="nyx-w-full">

    <div class="nyx-w-full">

        <div class="nyx-grid nyx-grid-cols-2 nyx-gap-4">
            <div class="nyx-col-span-2">
                <label class="nyx-mb-2 nyx-block"><strong><?php esc_html_e( 'Style of box', 'nyx-ticket' ); ?></strong></label>
                <select name="nyx-box[style]" class="nyx-w-full" required>
                    <option value="compact" <?php echo get_post_meta( $post->ID, 'nyx-box-style', true ) == 'compact' ? 'selected' : ''; ?>><?php esc_html_e( 'Compact', 'nyx-ticket' ); ?></option>
                    <option value="full" <?php echo get_post_meta( $post->ID, 'nyx-box-style', true ) == 'full' ? 'selected' : ''; ?>><?php esc_html_e( 'Full', 'nyx-ticket' ); ?></option>
                </select>
            </div>
        </div>

        <hr class="nyx-mb-2 nyx-mt-2 nyx-block" />
        <p><strong><?php esc_html_e( 'Single event box style', 'nyx-ticket' ); ?></strong></p>
        <div class="nyx-grid nyx-grid-cols-4 nyx-gap-4">
            <div class="nyx-col-span-1">
                <label class="nyx-mb-2 nyx-block"><strong><?php esc_html_e( 'Text color', 'nyx-ticket' ); ?></strong></label>
                <input type="text"
                       value="<?php echo esc_attr( get_post_meta( $post->ID, 'nyx-box-single-event-txt-color', true ) ); ?>"
                       name="nyx-box[single-event-txt-color]" data-alpha-enabled="true"
                       class="my-color-field nyx-w-full" autocomplete="off" />
            </div>
            <div class="nyx-col-span-1">
                <label class="nyx-mb-2 nyx-block"><strong><?php esc_html_e( 'Background color', 'nyx-ticket' ); ?></strong></label>
                <input type="text"
                       value="<?php echo esc_attr( get_post_meta( $post->ID, 'nyx-box-bg-single-event-color', true ) ); ?>"
                       name="nyx-box[bg-single-event-color]" data-alpha-enabled="true" class="my-color-field nyx-w-full"
                       autocomplete="off" />
            </div>
            <div class="nyx-col-span-1">
                <label class="nyx-mb-2 nyx-block"><strong><?php esc_html_e( 'Border color', 'nyx-ticket' ); ?></strong></label>
                <input type="text"
                       value="<?php echo esc_attr( get_post_meta( $post->ID, 'nyx-box-border-single-event-color', true ) ); ?>"
                       name="nyx-box[border-single-event-color]" data-alpha-enabled="true"
                       class="my-color-field nyx-w-full" autocomplete="off" />
            </div>
            <div class="nyx-col-span-1">
                <label class="nyx-mb-2 nyx-block"><strong><?php esc_html_e( 'Logo circle Border color', 'nyx-ticket' ); ?></strong></label>
                <input type="text"
                       value="<?php echo empty( get_post_meta( $post->ID, 'nyx-box-border-single-event-circle-color', true ) ) ? '#4c515a' : esc_attr( get_post_meta( $post->ID, 'nyx-box-border-single-event-circle-color', true ) ); ?>"
                       name="nyx-box[border-single-event-circle-color]" data-alpha-enabled="true"
                       class="my-color-field nyx-w-full" autocomplete="off" />
            </div>
        </div>
        <div class="nyx-grid nyx-grid-cols-3 nyx-gap-4 nyx-mt-2">
            <div class="nyx-col-span-1">
                <label class="nyx-mb-2 nyx-block"><strong><?php esc_html_e( 'Ticket button color', 'nyx-ticket' ); ?></strong></label>
                <input type="text"
                       value="<?php echo esc_attr( get_post_meta( $post->ID, 'nyx-box-single-event-btn-color', true ) ); ?>"
                       name="nyx-box[single-event-btn-color]" data-alpha-enabled="true"
                       class="my-color-field nyx-w-full" autocomplete="off" />
            </div>
            <div class="nyx-col-span-1">
                <label class="nyx-mb-2 nyx-block"><strong><?php esc_html_e( 'Ticket button border color', 'nyx-ticket' ); ?></strong></label>
                <input type="text"
                       value="<?php echo esc_attr( get_post_meta( $post->ID, 'nyx-box-bg-single-btn-border-color', true ) ); ?>"
                       name="nyx-box[bg-single-btn-border-color]" data-alpha-enabled="true"
                       class="my-color-field nyx-w-full" autocomplete="off" />
            </div>
            <div class="nyx-col-span-1">
                <label class="nyx-mb-2 nyx-block"><strong><?php esc_html_e( 'Ticket button text color', 'nyx-ticket' ); ?></strong></label>
                <input type="text"
                       value="<?php echo esc_attr( get_post_meta( $post->ID, 'nyx-box-border-single-event-btn-txt-color', true ) ); ?>"
                       name="nyx-box[border-single-event-btn-txt-color]" data-alpha-enabled="true"
                       class="my-color-field nyx-w-full" autocomplete="off" />
            </div>
        </div>

        <div class="nyx-grid nyx-grid-cols-2 nyx-gap-4 nyx-mt-2">
            <div class="nyx-col-span-1">
                <label class="nyx-mb-2 nyx-block"><strong><?php esc_html_e( 'Border radius in PX', 'nyx-ticket' ); ?></strong></label>
                <input type="number"
                       value="<?php echo esc_attr( get_post_meta( $post->ID, 'nyx-box-single-event-border-radius', true ) ); ?>"
                       name="nyx-box[single-event-border-radius]" class="nyx-w-full" autocomplete="off" />
            </div>
            <div class="nyx-col-span-1">
                <label class="nyx-mb-2 nyx-block"><strong><?php esc_html_e( 'Ticket button border radius in PX', 'nyx-ticket' ); ?></strong></label>
                <input type="number"
                       value="<?php echo esc_attr( get_post_meta( $post->ID, 'nyx-box-single-event-btn-border-radius', true ) ); ?>"
                       name="nyx-box[single-event-btn-border-radius]" class="nyx-w-full" autocomplete="off" />
            </div>
        </div>
        <hr class="nyx-mb-2 nyx-mt-2 nyx-block" />
        <div class="nyx-grid nyx-grid-cols-1 nyx-gap-4 nyx-mt-2">
            <div class="nyx-col-span-1">
                <label class="nyx-mb-2 nyx-block"><strong><?php esc_html_e( 'Ticket button standard text', 'nyx-ticket' ); ?></strong></label>
                <input type="text"
                       value="<?php echo empty( get_post_meta( $post->ID, 'nyx-box-single-event-ticket-btn-standard-txt', true ) ) ? 'Buy tickets' : esc_attr( get_post_meta( $post->ID, 'nyx-box-single-event-ticket-btn-standard-txt', true ) ); ?>"
                       name="nyx-box[single-event-ticket-btn-standard-txt]" class="nyx-w-full" autocomplete="off" />
            </div>
        </div>

    </div>

</div>
