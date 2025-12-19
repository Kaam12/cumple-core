<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Cumple_Demo' ) ) {

    class Cumple_Demo {

        public static function create_demo_data() {
            Cumple_CPT::register_post_types();
            Cumple_CPT::register_taxonomies();

            $eventos_data = array(
                array( 'title' => 'Maria & Robert - Boda', 'fecha' => '2025-01-15', 'meta' => 1000000 ),
                array( 'title' => 'Pamela & Jose - Baby Shower', 'fecha' => '2025-01-28', 'meta' => 750000 ),
                array( 'title' => 'Rosa & Jose - Bautismo', 'fecha' => '2025-01-22', 'meta' => 500000 ),
            );

            $evento_ids = array();

            foreach ( $eventos_data as $evento_data ) {
                $existing = get_page_by_title( $evento_data['title'], OBJECT, 'evento' );
                if ( $existing ) {
                    $evento_id = $existing->ID;
                } else {
                    $evento_id = wp_insert_post( array(
                        'post_title'   => $evento_data['title'],
                        'post_type'    => 'evento',
                        'post_status'  => 'publish',
                        'post_content' => '',
                    ) );
                }

                if ( $evento_id && ! is_wp_error( $evento_id ) ) {
                    update_post_meta( $evento_id, '_fecha', $evento_data['fecha'] );
                    update_post_meta( $evento_id, '_meta', $evento_data['meta'] );
                }

                $evento_ids[] = $evento_id;
            }

            if ( ! empty( $evento_ids[0] ) ) {
                $evento_principal = $evento_ids[0];

                $regalos_data = array(
                    array( 'title' => 'Luna de miel Cancún', 'precio' => 500000 ),
                    array( 'title' => 'TV 55"', 'precio' => 300000 ),
                    array( 'title' => 'Cocina', 'precio' => 250000 ),
                );

                foreach ( $regalos_data as $regalo_data ) {
                    $existing_regalo = get_page_by_title( $regalo_data['title'], OBJECT, 'regalo' );
                    if ( $existing_regalo ) {
                        $regalo_id = $existing_regalo->ID;
                    } else {
                        $regalo_id = wp_insert_post( array(
                            'post_title'   => $regalo_data['title'],
                            'post_type'    => 'regalo',
                            'post_status'  => 'publish',
                            'post_content' => '',
                        ) );
                    }

                    if ( $regalo_id && ! is_wp_error( $regalo_id ) ) {
                        update_post_meta( $regalo_id, '_precio', $regalo_data['precio'] );
                        update_post_meta( $regalo_id, '_evento', $evento_principal );
                    }
                }
            }
        }
    }
}
