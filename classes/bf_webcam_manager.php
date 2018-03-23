<?php
/**
 * @package    WordPress
 * @subpackage Woocommerce, BuddyForms
 * @author     ThemKraft Dev Team
 * @copyright  2017, Themekraft
 * @link       http://buddyforms.com/downloads/buddyforms-woocommerce-form-elements/
 * @license    GPLv2 or later
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class bf_webcam_manager {

    protected static $version = '1.4.2';
    private static $plugin_slug = 'bf_webcam';

    public function __construct() {
        require_once BF_WOO_ELEM_INCLUDES_PATH . 'bf_webcam_log.php';
        new bf_webcam_log();
        try {
            $this->bf_webcam_fe_includes();
        } catch ( Exception $ex ) {
            bf_woo_elem_log::log( array(
                'action'         => get_class( $this ),
                'object_type'    => bf_webcam_manager::get_slug(),
                'object_subtype' => 'loading_dependency',
                'object_name'    => $ex->getMessage(),
            ) );

        }
    }

    public function bf_webcam_fe_includes() {
        require_once BF_WOO_ELEM_INCLUDES_PATH . 'bf_webcam_form_builder.php';
        new bf_webcam_form_builder();
        require_once BF_WOO_ELEM_INCLUDES_PATH . 'bf_webcam_form_elements.php';
        new bf_woo_elem_form_element();
        //require_once BF_WOO_ELEM_INCLUDES_PATH . 'bf_woo_elem_form_elements_save.php';
        //new bf_woo_elem_form_elements_save();


    }

    public static function get_slug() {
        return self::$plugin_slug;
    }

    static function get_version() {
        return self::$version;
    }

    /**
     * @return array
     */
    public static function get_unhandled_tabs() {
        $unhandled = array();
        if ( class_exists( 'WC_Vendors' ) ) {
            $unhandled['commission'] = array( 'label' => 'WC Vendors' );
        }

        return apply_filters( 'bf_woo_element_woo_unhandled_tabs', $unhandled );
    }
}