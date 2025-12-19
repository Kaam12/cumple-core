<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Cumple_CPT' ) ) {

    class Cumple_CPT {

        /**
         * Registrar Custom Post Types
         */
        public static function register_post_types() {

            // CPT Evento
            $labels_evento = array(
                'name'               => __( 'Eventos', 'cumple-core' ),
                'singular_name'      => __( 'Evento', 'cumple-core' ),
                'add_new'            => __( 'Añadir nuevo', 'cumple-core' ),
                'add_new_item'       => __( 'Añadir nuevo evento', 'cumple-core' ),
                'edit_item'          => __( 'Editar evento', 'cumple-core' ),
                'new_item'           => __( 'Nuevo evento', 'cumple-core' ),
                'all_items'          => __( 'Todos los eventos', 'cumple-core' ),
                'view_item'          => __( 'Ver evento', 'cumple-core' ),
                'search_items'       => __( 'Buscar eventos', 'cumple-core' ),
                'not_found'          => __( 'No se encontraron eventos', 'cumple-core' ),
                'not_found_in_trash' => __( 'No se encontraron eventos en la papelera', 'cumple-core' ),
                'menu_name'          => __( 'Eventos', 'cumple-core' ),
            );

            $args_evento = array(
                'labels'             => $labels_evento,
                'public'             => true,
                'has_archive'        => true,
                'show_in_rest'       => true,
                'supports'           => array( 'title', 'editor', 'thumbnail', 'author' ),
                'menu_icon'          => 'dashicons-calendar-alt',
                'rewrite'            => array( 'slug' => 'evento' ),
            );

            register_post_type( 'evento', $args_evento );

            // CPT Regalo
            $labels_regalo = array(
                'name'               => __( 'Regalos', 'cumple-core' ),
                'singular_name'      => __( 'Regalo', 'cumple-core' ),
                'add_new'            => __( 'Añadir nuevo', 'cumple-core' ),
                'add_new_item'       => __( 'Añadir nuevo regalo', 'cumple-core' ),
                'edit_item'          => __( 'Editar regalo', 'cumple-core' ),
                'new_item'           => __( 'Nuevo regalo', 'cumple-core' ),
                'all_items'          => __( 'Todos los regalos', 'cumple-core' ),
                'view_item'          => __( 'Ver regalo', 'cumple-core' ),
                'search_items'       => __( 'Buscar regalos', 'cumple-core' ),
                'not_found'          => __( 'No se encontraron regalos', 'cumple-core' ),
                'not_found_in_trash' => __( 'No se encontraron regalos en la papelera', 'cumple-core' ),
                'menu_name'          => __( 'Regalos', 'cumple-core' ),
            );

            $args_regalo = array(
                'labels'             => $labels_regalo,
                'public'             => false,
                'show_ui'            => true,
                'show_in_rest'       => true,
                'supports'           => array( 'title', 'thumbnail' ),
                'menu_icon'          => 'dashicons-heart',
                'rewrite'            => false,
            );

            register_post_type( 'regalo', $args_regalo );
        }

        /**
         * Registrar taxonomías
         */
        public static function register_taxonomies() {

            // Taxonomía tipo_evento para evento
            $labels = array(
                'name'              => __( 'Tipos de evento', 'cumple-core' ),
                'singular_name'     => __( 'Tipo de evento', 'cumple-core' ),
                'search_items'      => __( 'Buscar tipos de evento', 'cumple-core' ),
                'all_items'         => __( 'Todos los tipos de evento', 'cumple-core' ),
                'edit_item'         => __( 'Editar tipo de evento', 'cumple-core' ),
                'update_item'       => __( 'Actualizar tipo de evento', 'cumple-core' ),
                'add_new_item'      => __( 'Añadir nuevo tipo de evento', 'cumple-core' ),
                'new_item_name'     => __( 'Nuevo tipo de evento', 'cumple-core' ),
                'menu_name'         => __( 'Tipo de evento', 'cumple-core' ),
            );

            $args = array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => 'tipo-evento' ),
            );

            register_taxonomy( 'tipo_evento', array( 'evento' ), $args );

            // Insertar términos por defecto
            $default_terms = array( 'Boda', 'Baby Shower', 'Bautismo', 'Cumpleaños' );

            foreach ( $default_terms as $term ) {
                if ( ! term_exists( $term, 'tipo_evento' ) ) {
                    wp_insert_term( $term, 'tipo_evento' );
                }
            }
        }
    }
}
