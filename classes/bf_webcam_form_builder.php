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

        add_action( 'admin_enqueue_scripts', array( $this, 'load_js_for_builder' ),10 );
        add_action("custom_column_default",array($this,"webcam_custom_column_default"),1,2);
    }

    public function webcam_custom_column_default($item, $column_name ){

        global $buddyforms;
        $column_val = get_post_meta( $item['ID'], $column_name, true );
        $result = $column_val;
        $formSlug= $_GET['form_slug'];
        $buddyFData = isset($buddyforms[$formSlug]['form_fields']) ?$buddyforms[$formSlug]['form_fields']:[] ;
        foreach ($buddyFData as $key=>$value){
            $field = $value['slug'];
            $type  = $value['type'];
            if( $field == $column_name && $type == 'webcam'){

                $url = wp_get_attachment_url( $column_val );
                $result = " <a style='vertical-align: top;' target='_blank' href='" .  $url . "'>$column_val</a>";

            }
        }
			echo  $result;
    }
    public function load_js_for_builder() {

       // wp_enqueue_script( 'buddyforms_webcam', BF_WEBCAM_ELEM_JS_PATH.'webcam.js', array( 'jquery' ) );
        wp_enqueue_script( 'buddyforms_camera_admin', BF_WEBCAM_ELEM_JS_PATH.'camera_admin.js', array( 'jquery' ) );

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
                $width                           = isset( $buddyform['form_fields'][ $field_id ]['width'] ) ? stripslashes( $buddyform['form_fields'][ $field_id ]['width'] ) : '320';
                $fps                             = isset( $buddyform['form_fields'][ $field_id ]['fps'] ) ? stripslashes( $buddyform['form_fields'][ $field_id ]['fps'] ) : '30';
                $quality                             = isset( $buddyform['form_fields'][ $field_id ]['quality'] ) ? stripslashes( $buddyform['form_fields'][ $field_id ]['quality'] ) : '90';
                $height_element = new Element_Number( '<b>' . __( 'Height of the live camera viewer in pixels, by default \'240\'. ', 'buddyforms' ) . '</b>', "buddyforms_options[form_fields][" . $field_id . "][height]", array(  'class'=>'gfirem_webcam_admin', 'value' =>  $height , 'id'    => 'height_' . $field_id  ) );

                $height_element->setAttribute('onchange',"changeHeigthRatio('".$field_id."')");
                $form_fields['general']['webcam_height'] = $height_element;

                $width_element = new Element_Number( '<b>' . __( 'Width of the live camera viewer in pixels, by default \'320\'. ', 'buddyforms' ) . '</b>', "buddyforms_options[form_fields][" . $field_id . "][width]", array( 'field_id'=>$field_id ,'class'=>'gfirem_webcam_admin', 'value' =>  $width , 'id'    => 'width_' . $field_id
                ) );
                $width_element->setAttribute('onchange',"changeWidthRatio('".$field_id."')");
                $form_fields['general']['webcam_width'] = $width_element;
                $form_fields['general']['webcam_fps'] =  new Element_Number( '<b>' . __( "Set the desired fps (frames per second) capture rate, by default '30'. ", 'buddyforms' ) . '</b>', "buddyforms_options[form_fields][" . $field_id . "][fps]", array( 'class'=>'gfirem_webcam_admin', 'value' =>  $fps , 'id'    => 'fps_' . $field_id
                ) );
                $form_fields['general']['webcam_quality'] =  new Element_Number( '<b>' . __( "This is the desired quality, from 0 (worst) to 100 (best), by default '90'. ", 'buddyforms' ) . '</b>', "buddyforms_options[form_fields][" . $field_id . "][quality]", array( 'class'=>'gfirem_webcam_admin', 'value' =>  $quality , 'id'    => 'quality_' . $field_id
                ) );



        }

        return $form_fields;
    }

}

