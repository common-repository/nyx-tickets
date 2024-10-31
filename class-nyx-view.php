<?php


class Nyx_View
{

    /**
     * Returns a view file and allows for variable injection
     * @param $name
     * @param array $args
     */
    public static function view( $name, array $args = array() )
    {
        $args = apply_filters( 'nyx_view_arguments', $args, $name );

        foreach ( $args as $key => $val ) {
            $$key = $val;
        }

        $file = NYX__PLUGIN_DIR . 'views/' . $name . '.php';

        include($file);
    }

}