<?php

/*
 * @package WordPress
 * @subpackage BuddyPress, Woocommerce, BuddyForms
 * @author ThemKraft Dev Team
 * @copyright 2017, Themekraft
 * @link http://buddyforms.com/downloads/buddyforms-woocommerce-form-elements/
 * @license GPLv2 or later
 */

class bf_webcam_form_builder {

    private $load_script = false;

    public function __construct() {
        add_filter( 'buddyforms_add_form_element_select_option', array( $this, 'buddyforms_webcam_formbuilder_elements_select' ), 1 );
        add_filter( 'buddyforms_form_element_add_field', array( $this, 'buddyforms_webcam_create_new_form_builder_form_element' ), 1, 5 );

        add_action( 'admin_footer', array( $this, 'load_js_for_builder' ) );
    }

    public function load_js_for_builder( $hook ) {
        if ( $this->load_script ) {
            wp_enqueue_script( 'bf_woo_builder', BF_WOO_ELEM_JS_PATH . 'bf_woo_builder.js', array( "jquery" ), null, true );
            wp_enqueue_style( 'bf_woo_builder', BF_WOO_ELEM_CSS_PATH . 'buddyforms-woocommerce.css' );
        }
    }

    public function buddyforms_webcam_formbuilder_elements_select( $elements_select_options ) {
        global $post;

        if ( $post->post_type != 'buddyforms' ) {
            return;
        }


        $elements_select_options['extra']['fields']['webcam'] =
            array(
                'label' => __( 'Webcam', 'buddyforms' ),
            );


        return $elements_select_options;
    }

    public function buddyforms_webcam_create_new_form_builder_form_element( $form_fields, $form_slug, $field_type, $field_id ) {
        global $post, $buddyform;

        if ( $post->post_type != 'buddyforms' ) {
            return;
        }

        $field_id = (string) $field_id;

        $this->load_script = true;

        if( !$buddyform ){
            $buddyform         = get_post_meta( $post->ID, '_buddyforms_options', true );
        }

        //    if($buddyform['post_type'] != 'product')
        //        return;

        switch ( $field_type ) {
            case 'webcam':
                unset($form_fields);
                $form_fields['hidden']['name'] = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][name]", 'Webcam' );
                $form_fields['hidden']['slug'] = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][slug]", 'webcam' );

                $form_fields['hidden']['type'] = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][type]", $field_type );
                $height                          = isset( $buddyform['form_fields'][ $field_id ]['height'] ) ? stripslashes( $buddyform['form_fields'][ $field_id ]['height'] ) : '240';
                $form_fields['general']['webcam_height'] = new Element_Number( '<b>' . __( 'Height of the live camera viewer in pixels, by default \'240\'. ', 'buddyforms' ) . '</b>', "buddyforms_options[form_fields][" . $field_id . "][height]", array( 'value' =>  $height , 'id'    => 'webcam_height' . $field_id
                ) );
        }

        return $form_fields;
    }

}

