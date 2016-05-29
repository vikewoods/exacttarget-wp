<?php

/**
 * Plugin Name: Exact Target Email Form
 * Plugin URI: http://www.riseproject.com/
 * Version: 1.0.1
 * Author: Vik Ewoods
 * Description: Widget for subscription form from Exact Target (SalesForce)
 **/

/*
 * Including SOAP API
 */
require('include/php_soap_api/exacttarget_soap_client.php');

class Exact_Target_Widget extends WP_Widget
{

    /*
     * Define SOAP WSDL
     */
    private $soap_wsdl = "https://webservice.exacttarget.com/etframework.wsdl";

    /*
     * Init
     */
    public function __construct()
    {
        parent::__construct("exact_target_widget",
            __("Exact Target Widget", "exact_target_widget_domain"),
            array("description" => __("Widget for subscription form from Exact Target (SalesForce)", "exact_target_widget_domain"))
        );
    }

    /*
     * The widget() – display the widget on the blog
     */
    public function widget($args, $instance)
    {
        echo 'Hello world!';
    }

    /*
     * The form() method is used in the widget administration screen to display fields which you can later use
     * to alter the functionality of the widget on the site itself.
     *
     * @var: $instance
     */
    public function form($instance)
    {

        /*
         * Variables
         */
        $etm_title = '';
        $etm_email_placeholder = '';
        $etm_button = '';
        $etm_username = '';
        $etm_password = '';

        if(!empty($instance)){
            $etm_title = $instance['etm_title'];
            $etm_email_placeholder = $instance['etm_email_placeholder'];
            $etm_button = $instance['etm_button'];
            $etm_username = $instance['etm_username'];
            // TODO: Find way to store apssword
            $etm_password = $instance['etm_password'];
        }

        /*
         * Title input
         */
        $fieldTitleId = $this->get_field_id('etm_title');
        $fieldTitleName = $this->get_field_name('etm_title');

        echo '<p>';
        echo '<label for="' . $fieldTitleId . '">Title (left side header)</label>';
        echo '<input id="' . $fieldTitleId . '" class="widefat" type="text" name="' . $fieldTitleName . '" value="' . $etm_title . '">';
        echo '</p>';

        /*
         * Email placeholder
         */
        $fieldEmailId = $this->get_field_id('etm_email_placeholder');
        $fieldEmailName = $this->get_field_name('etm_email_placeholder');

        echo '<p>';
        echo '<label for="' . $fieldEmailId . '">Email placeholder text</label>';
        echo '<input id="' . $fieldEmailId . '" class="widefat" type="text" name="' . $fieldEmailName . '" value="' . $etm_email_placeholder . '">';
        echo '</p>';

        /*
         * Submit button name
         */
        $fieldButtonId = $this->get_field_id('etm_button');
        $fieldButtonName = $this->get_field_name('etm_button');

        echo '<p>';
        echo '<label for="' . $fieldButtonId . '">Submit button text</label>';
        echo '<input id="' . $fieldButtonId . '" class="widefat" type="text" name="' . $fieldButtonName . '" value="' . $etm_button . '">';
        echo '</p>';

        echo '<p>&nbsp;</p>';

        /*
         * User name for SalesForce
         */
        $fieldUserId = $this->get_field_id('etm_username');
        $fieldUserName = $this->get_field_name('etm_username');

        echo '<p>';
        echo '<label for="' . $fieldUserId . '">Username (SalesForce):</label>';
        echo '<input id="' . $fieldUserId . '" class="widefat" type="text" name="' . $fieldUserName . '" value="' . $etm_username . '">';
        echo '</p>';

        /*
         * Password for SalesForce
         */
        $fieldPasswordId = $this->get_field_id('etm_password');
        $fieldPasswordName = $this->get_field_name('etm_password');

        echo '<p>';
        echo '<label for="' . $fieldPasswordId . '">Password (SalesForce):</label>';
        echo '<input id="' . $fieldPasswordId . '" class="widefat" type="text" name="' . $fieldPasswordName . '" value="' . $etm_password . '">';
        echo '</p>';

    }



}


/*
 * Adding action to init widget
 */
function exact_target_load_widget()
{
    register_widget('exact_target_widget');
}

add_action('widgets_init', 'exact_target_load_widget');


