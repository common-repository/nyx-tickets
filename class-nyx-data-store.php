<?php


class Nyx_Data_store
{

    private $data;

    public function set_data( $data )
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Saves event data to database.
     */
    public function save()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'nyx_ticket_events';

        //Always delete events before syncing.
        $wpdb->query( "DELETE FROM `$table_name`" );

        foreach ( $this->data as $event ) {
            $wpdb->insert(
                $table_name,
                array(
                    'foreign_id'  => sanitize_text_field( $event->id ),
                    'is_expired'  => sanitize_text_field( $event->expired ),
                    'title'       => sanitize_textarea_field( $event->name ),
                    'cover_image' => esc_url_raw( $event->image->url ),
                    'host_logo'   => esc_url_raw( $event->host->identity->logo->url ),
                    'host'        => sanitize_text_field( $event->host->identity->name ),
                    'description' => sanitize_textarea_field( $event->description ),
                    'link'        => sanitize_text_field( $event->link ),
                    'start_at'    => date( 'Y-m-d H:i:s', sanitize_text_field( $event->start_time ) ),
                ),
                array(
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                )
            );

        }

    }

}