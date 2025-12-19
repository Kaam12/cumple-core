<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Cumple_Metaboxes' ) ) {

    class Cumple_Metaboxes {

        public static function register_metaboxes() {
            add_meta_box( 'evento_detalles', __( 'Detalles del evento', 'cumple-core' ), array( __CLASS__, 'render_evento_detalles' ), 'evento', 'normal', 'high' );
            add_meta_box( 'regalo_detalles', __( 'Detalles del regalo', 'cumple-core' ), array( __CLASS__, 'render_regalo_detalles' ), 'regalo', 'normal', 'high' );
        }

        public static function render_evento_detalles( $post ) {
            wp_nonce_field( 'cumple_evento_detalles_nonce_action', 'cumple_evento_detalles_nonce' );
            $f1    = get_post_meta( $post->ID, '_f1', true );
            $f2    = get_post_meta( $post->ID, '_f2', true );
            $fecha = get_post_meta( $post->ID, '_fecha', true );
            $meta  = get_post_meta( $post->ID, '_meta', true );
            ?>
            <div class="cumple-metabox">
                <p class="cumple-field"><label for="cumple_f1"><?php _e( 'Campo F1', 'cumple-core' ); ?></label><br><input type="text" id="cumple_f1" name="cumple_f1" value="<?php echo esc_attr( $f1 ); ?>"></p>
                <p class="cumple-field"><label for="cumple_f2"><?php _e( 'Campo F2', 'cumple-core' ); ?></label><br><input type="text" id="cumple_f2" name="cumple_f2" value="<?php echo esc_attr( $f2 ); ?>"></p>
                <p class="cumple-field"><label for="cumple_fecha"><?php _e( 'Fecha del evento', 'cumple-core' ); ?></label><br><input type="date" id="cumple_fecha" name="cumple_fecha" value="<?php echo esc_attr( $fecha ); ?>"></p>
                <p class="cumple-field"><label for="cumple_meta"><?php _e( 'Meta (monto)', 'cumple-core' ); ?></label><br><input type="number" id="cumple_meta" name="cumple_meta" value="<?php echo esc_attr( $meta ); ?>" step="1" min="0"></p>
            </div>
            <?php
        }

        public static function save_evento_detalles( $post_id ) {
            if ( ! isset( $_POST['cumple_evento_detalles_nonce'] ) || ! wp_verify_nonce( $_POST['cumple_evento_detalles_nonce'], 'cumple_evento_detalles_nonce_action' ) ) return;
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
            if ( isset( $_POST['post_type'] ) && 'evento' === $_POST['post_type'] && current_user_can( 'edit_post', $post_id ) ) {
                isset( $_POST['cumple_f1'] ) && update_post_meta( $post_id, '_f1', sanitize_text_field( $_POST['cumple_f1'] ) );
                isset( $_POST['cumple_f2'] ) && update_post_meta( $post_id, '_f2', sanitize_text_field( $_POST['cumple_f2'] ) );
                isset( $_POST['cumple_fecha'] ) && update_post_meta( $post_id, '_fecha', sanitize_text_field( $_POST['cumple_fecha'] ) );
                isset( $_POST['cumple_meta'] ) && update_post_meta( $post_id, '_meta', floatval( $_POST['cumple_meta'] ) );
            }
        }

        public static function render_regalo_detalles( $post ) {
            wp_nonce_field( 'cumple_regalo_detalles_nonce_action', 'cumple_regalo_detalles_nonce' );
            $precio = get_post_meta( $post->ID, '_precio', true );
            $evento = get_post_meta( $post->ID, '_evento', true );
            $eventos = get_posts( array( 'post_type' => 'evento', 'posts_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'title', 'order' => 'ASC' ) );
            ?>
            <div class="cumple-metabox">
                <p class="cumple-field"><label for="cumple_precio"><?php _e( 'Precio del regalo', 'cumple-core' ); ?></label><br><input type="number" id="cumple_precio" name="cumple_precio" value="<?php echo esc_attr( $precio ); ?>" step="1" min="0"></p>
                <p class="cumple-field"><label for="cumple_evento"><?php _e( 'Evento asociado', 'cumple-core' ); ?></label><br><select id="cumple_evento" name="cumple_evento"><option value=""><?php _e( 'Seleccionar evento', 'cumple-core' ); ?></option><?php if ( $eventos ) { foreach ( $eventos as $ev ) { ?><option value="<?php echo esc_attr( $ev->ID ); ?>" <?php selected( $evento, $ev->ID ); ?>><?php echo esc_html( get_the_title( $ev->ID ) ); ?></option><?php } } ?></select></p>
            </div>
            <?php
        }

        public static function save_regalo_detalles( $post_id ) {
            if ( ! isset( $_POST['cumple_regalo_detalles_nonce'] ) || ! wp_verify_nonce( $_POST['cumple_regalo_detalles_nonce'], 'cumple_regalo_detalles_nonce_action' ) ) return;
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
            if ( isset( $_POST['post_type'] ) && 'regalo' === $_POST['post_type'] && current_user_can( 'edit_post', $post_id ) ) {
                isset( $_POST['cumple_precio'] ) && update_post_meta( $post_id, '_precio', floatval( $_POST['cumple_precio'] ) );
                isset( $_POST['cumple_evento'] ) && update_post_meta( $post_id, '_evento', intval( $_POST['cumple_evento'] ) );
            }
        }
    }
}
