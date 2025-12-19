<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Cumple_Roles' ) ) {

    class Cumple_Roles {

        /**
         * Crear roles personalizados
         */
        public static function create_roles() {

            // Rol "festejado"
            add_role(
                'festejado',
                __( 'Festejado', 'cumple-core' ),
                array(
                    'read'          => true,
                    'edit_posts'    => true,
                    'delete_posts'  => true,
                    'publish_posts' => true,
                    'upload_files'  => true,
                )
            );

            // Rol "donante"
            add_role(
                'donante',
                __( 'Donante', 'cumple-core' ),
                array(
                    'read' => true,
                )
            );
        }
    }
}
