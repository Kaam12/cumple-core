<?php
/**
 * Plugin Name: Cumple mis Deseos - Core
 * Description: Funcionalidades base para Cumple mis Deseos (roles, CPT, metaboxes y datos demo).
 * Version: 1.0.0
 * Author: Sustenta Web
 * Text Domain: cumple-core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Constantes
define( 'CUMPLE_PATH', plugin_dir_path( __FILE__ ) );
define( 'CUMPLE_URL', plugin_dir_url( __FILE__ ) );
define( 'CUMPLE_VERSION', '1.0.0' );

// Carga de archivos principales
require_once CUMPLE_PATH . 'includes/class-roles.php';
require_once CUMPLE_PATH . 'includes/class-cpt.php';
require_once CUMPLE_PATH . 'includes/class-metaboxes.php';
require_once CUMPLE_PATH . 'includes/class-demo.php';

if ( ! class_exists( 'Cumple_Core' ) ) {

    class Cumple_Core {

        /**
         * Instancia singleton
         *
         * @var Cumple_Core
         */
        private static $instance = null;

        /**
         * Obtener instancia
         *
         * @return Cumple_Core
         */
        public static function get_instance() {
            if ( null === self::$instance ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Constructor privado
         */
        private function __construct() {
            $this->init_hooks();
        }

        /**
         * Evitar clonación
         */
        private function __clone() {}

        /**
         * Evitar unserialize
         */
        private function __wakeup() {}

        /**
         * Hooks principales
         */
        private function init_hooks() {

            // Registrar CPT y taxonomías
            add_action( 'init', array( 'Cumple_CPT', 'register_post_types' ) );
            add_action( 'init', array( 'Cumple_CPT', 'register_taxonomies' ) );

            // Metaboxes
            add_action( 'add_meta_boxes', array( 'Cumple_Metaboxes', 'register_metaboxes' ) );
            add_action( 'save_post', array( 'Cumple_Metaboxes', 'save_evento_detalles' ) );
            add_action( 'save_post', array( 'Cumple_Metaboxes', 'save_regalo_detalles' ) );

            // Estilos admin
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
        }

        /**
         * Scripts y estilos de administración
         */
        public function enqueue_admin_assets( $hook ) {
            wp_enqueue_style(
                'cumple-admin',
                CUMPLE_URL . 'assets/admin.css',
                array(),
                CUMPLE_VERSION
            );
        }
    }
}

// Inicializar plugin
Cumple_Core::get_instance();

/**
 * Activación del plugin
 */
function cumple_core_activate() {

    // Crear roles
    Cumple_Roles::create_roles();

    // Registrar CPT y taxonomías antes de flush
    Cumple_CPT::register_post_types();
    Cumple_CPT::register_taxonomies();

    // Flush rewrites
    flush_rewrite_rules();

    // Crear datos demo
    Cumple_Demo::create_demo_data();
}
register_activation_hook( __FILE__, 'cumple_core_activate' );

/**
 * Desactivación del plugin
 */
function cumple_core_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'cumple_core_deactivate' );
