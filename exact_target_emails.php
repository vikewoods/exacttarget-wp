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
require('include/lib/ET_Client.php');

class Exact_Target_Widget extends WP_Widget
{
    private $et_version = "1.0.1";

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


        var_dump($instance);

        echo '<div class="container">';
        echo '<div class="row">';
        echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
        echo '<div class="mj_addsection">';
        echo '<h2>'. $instance['etm_title'] .'</h2>';
        echo '<div class="mj_weight mj_bottompadder20">';

        echo '<form id="et_form" action="' . esc_url($_SERVER['REQUEST_URI']) . '" method="post">';
        echo '<div class="et_input_holder">';
        echo '<input type="text" name="exwemail" id="et_email" placeholder="' . $instance['etm_email_placeholder'] . '"/>';
        echo '<input type="submit" name="exwsubmit" id="et_button" value="' . $instance['etm_button'] . '"/>';
        echo '<p id="et_result" class="result"></p>';
        echo '</div>';
        echo '</form>';

        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        

        /*
         * Debug
         *
         */
//        echo '<pre>';
//        $myclient = new ET_Client();
//        $getList = new ET_List();
//        $getList->authStub = $myclient;
//        $getResponse = $getList->get();
//        var_dump($getResponse);
//        echo '</pre>';
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

        if (!empty($instance)) {
            $etm_title = $instance['etm_title'];
            $etm_email_placeholder = $instance['etm_email_placeholder'];
            $etm_button = $instance['etm_button'];
            $etm_username = $instance['etm_username'];
            // TODO: Find way to store password
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

/*
 * Adding CSS and JS to header
 */
function exact_target_load_resource()
{
    wp_enqueue_style('exact-target-styles', plugins_url('include/css/exact_target_widget.css', __FILE__), null, '1.0.2', 'all');
    wp_register_script('exact-target-scripts', plugins_url('include/js/exact_target_widget.js', __FILE__), array('jquery'), '1.0.2', false);
    wp_enqueue_script('exact-target-scripts');
}

add_action('wp_enqueue_scripts', 'exact_target_load_resource');

/*
 * AJAX Process request
 *
 * Handle ajax for both sides
 */
function exact_target_ajax_submit()
{

    $response = new WP_Ajax_Response;

    if (isset($_POST)) {

        $et_email = $_POST['exwemail'];

        if (!empty($et_email)) {
            if (!filter_var($et_email, FILTER_VALIDATE_EMAIL)) {

                //TODO: Work here with ExactTarget api to create new subscriber
                //TODO: Ask Tau for login details for marketing cloud (there are only 1 way to login with username & password)




                $response->add(
                    array(
                        'data' => 'error',
                        'supplemental' => array(
                            'message' => 'You should enter you real email.',
                        ),
                    )
                );
            } else {
                $response->add(
                    array(
                        'data' => 'success',
                        'supplemental' => array(
                            'message' => 'You are successfully subscribed.',
                        ),
                    )
                );
            }
        } else {
            $response->add(
                array(
                    'data' => 'error',
                    'supplemental' => array(
                        'message' => 'Something went wrong, sorry.',
                    ),
                )
            );
        }
    }

    //var_dump($_POST);
    $response->send();
    exit();

}

add_action('wp_ajax_nopriv_exact-target-ajax-submit', 'exact_target_ajax_submit');
add_action('wp_ajax_exact-target-ajax-submit', 'exact_target_ajax_submit');




