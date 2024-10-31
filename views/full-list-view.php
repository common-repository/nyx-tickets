<div class="nyx-full-event-view">
    <?php if ( !empty( $events ) ): ?>
        <?php foreach ( $events as $k => $event ): ?>
            <div class="nyx-event nyx-mb-2" style="
            <?php echo($k >= 5 ? 'display:none;' : ''); ?>
                    background-color: <?php echo esc_html( $post_settings['nyx-box-bg-single-event-color'] ); ?>;
                    border:1px solid <?php echo esc_html( $post_settings['nyx-box-border-single-event-color'] ); ?>;
                    color: <?php echo esc_html( $post_settings['nyx-box-single-event-txt-color'] ); ?>;
                    border-radius: <?php echo esc_html( $post_settings['nyx-box-single-event-border-radius'] ); ?>px;
                    ">
                <div class="nyx-event-container">
                    <img src="<?php echo esc_url( $event->image->url ); ?>?max_width=800"
                         class="nyx-event-cover-photo" />
                    <div class="nyx-event-info nyx-w-full">
                        <div class="nyx-title-and-date">
                            <h2 class="nyx-event-title"
                                style="color: <?php echo esc_html( $post_settings['nyx-box-single-event-txt-color'] ); ?>;"><?php echo esc_html( $event->name ); ?></h2>
                            <p class="nyx-event-date"
                               style="color: <?php echo esc_html( $post_settings['nyx-box-single-event-txt-color'] ); ?>;"><?php echo esc_html( get_date_from_gmt( date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), esc_html( $event->start_time ) ), get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ) ); ?></p>
                        </div>
                        <div class="nyx-event-desc"
                             style="color: <?php echo esc_html( $post_settings['nyx-box-single-event-txt-color'] ); ?>;"><?php echo esc_textarea( strip_tags( $event->description ) ); ?></div>
                        <div class="nyx-event-info-footer">
                            <?php if ( esc_textarea( $event->expired ) == 0 ): ?>
                                <a class="nyx-buy-tickets"
                                   href="https://tickets.nyxapp.net/events/<?php echo esc_html( $event->link ); ?>"
                                   style="
                                           border-radius: <?php echo esc_html( $post_settings['nyx-box-single-event-btn-border-radius'] ); ?>px;
                                           color: <?php echo esc_html( $post_settings['nyx-box-border-single-event-btn-txt-color'] ); ?>;
                                           background-color: <?php echo esc_html( $post_settings['nyx-box-single-event-btn-color'] ); ?>;
                                           border: 1px solid <?php echo esc_html( $post_settings['nyx-box-bg-single-btn-border-color'] ); ?>"
                                   target="_blank"><?php echo isset( $post_settings['nyx-box-single-event-ticket-btn-standard-txt'] ) && !empty( $post_settings['nyx-box-single-event-ticket-btn-standard-txt'] ) ? esc_html( $post_settings['nyx-box-single-event-ticket-btn-standard-txt'] ) : esc_html_e( 'Go to ticket sale', 'nyx-ticket' ); ?></a>
                            <?php else: ?>
                                <p class="ticket-sales-ended"><?php esc_html_e( 'Ticket sale expired', 'nyx-ticket' ); ?></p>
                            <?php endif; ?>
                            <div class="nyx-host-info">
                                <div class="nyx-logo"
                                     style="border-color:<?php echo esc_html( $post_settings['nyx-box-border-single-event-circle-color'] ); ?>;">
                                    <img src="<?php echo esc_url( $event->host->identity->logo->url ); ?>?max_width=120" />
                                </div>
                                <p class="nyx-event-host-name"><?php echo esc_html( $event->host->identity->name ); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if ( count( $events ) > 5 ): ?>
            <span class="show-more-events"><?php esc_html_e( 'Show', 'nyx-ticket' ); ?> <?php echo count( $events ) - 5; ?> <?php esc_html_e( 'more events', 'nyx-ticket' ); ?></span>
        <?php endif; ?>

    <?php else: ?>

        <p class="nyx-no-events"><?php echo  esc_html_e( 'There is no upcoming events. Check back soon!', 'nyx-ticket' ); ?></p>

    <?php endif; ?>
</div>