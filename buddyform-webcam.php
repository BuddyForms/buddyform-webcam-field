<?php
/**
 * Plugin Name: Buddyform -> Webcam
 * Plugin URI:  https://github.com/gfirem/buddyform-webcam-field
 * Description: Buddyform Webcam - Integrate Buddyform with Webcam field.
 * Author:      ThemeKraft
 * Author URI: https://profiles.wordpress.org/svenl77
 * Version:     1.0.4
 * Licence:     GPLv3
 * Text Domain: buddyform_webcam
 * Domain Path: /languages
 *
 * @package buddyform_webcam
 *
 *****************************************************************************
 *
 * This script is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ****************************************************************************
 */


if ( ! defined( 'WPINC' ) ) {
    die;
}

if ( ! class_exists( 'bf_webcam' ) ) {

    require_once dirname( __FILE__ ) . '/classes/bf_webcam_fs.php';
    new bf_webcam_fs();

    class bf_webcam {

        /**
         * Instance of this class
         *
         * @var $instance bf_woo_elem
         */
        protected static $instance = null;

        private function __construct() {
            $this->constants();
            $this->load_plugin_textdomain();
           // require_once BF_WOO_ELEM_INCLUDES_PATH . 'bf_woo_elem_requirements.php';
            //new bf_woo_elem_requirements();
            require_once BF_WEBCAM_ELEM_INCLUDES_PATH . 'bf_webcam_manager.php';
            new bf_webcam_manager();
           // if ( bf_woo_elem_requirements::is_buddy_form_active() && bf_woo_elem_requirements::is_woocommerce_active() ) {



        //	register_activation_hook( __FILE__, array( $this, 'activation' ) );
        //	register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );
        //	self::getFreemius()->add_action('after_uninstall', array($this, 'uninstall_cleanup') );
          //  }
        }

        private function constants() {
            define( 'BF_WEBCAM_ELEM_BASE_NAME', plugin_basename( __FILE__ ) );
            define( 'BF_WEBCAM_ELEM_BASE_NAMEBASE_FILE', trailingslashit( wp_normalize_path( plugin_dir_path( __FILE__ ) ) ) . 'loader.php' );
            define( 'BF_WEBCAM_ELEM_CSS_PATH', plugin_dir_url( __FILE__ ) . 'assets/css/' );
            define( 'BF_WEBCAM_ELEM_JS_PATH', plugin_dir_url( __FILE__ ) . 'assets/js/' );
            define( 'BF_WEBCAM_ELEM_VIEW_PATH', dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR );
            define( 'BF_WEBCAM_ELEM_TEMPLATES_PATH', dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR );
            define( 'BF_WEBCAM_ELEM_INCLUDES_PATH', dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR );
        }

        /**
         * Return an instance of this class.
         *
         * @return object A single instance of this class.
         */
        public static function get_instance() {
            // If the single instance hasn't been set, set it now.
            if ( null === self::$instance ) {
                self::$instance = new self;
            }

            return self::$instance;
        }

        public function load_plugin_textdomain() {
            load_plugin_textdomain( 'bf_woo_elem_locale', false, basename( dirname( __FILE__ ) ) . '/languages' );
        }

    }

    add_action( 'plugins_loaded', array( 'bf_webcam', 'get_instance' ), 1 );
}
