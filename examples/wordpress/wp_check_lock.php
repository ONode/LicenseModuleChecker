<?php


include_once 'vendor/checker_key_final.class.php';


/**
 * instruction: include this file in your wordpress function.php
 * goto encryption website: http://www.phpencode.org/
 *
 */
function payload_implementation()
{
    if (LICENSE_FEATURE_BRAND_REMOVAL) {
        /**
         * your implementation code here
         * your very important initiation codes here
         * put all your secret mechanism in here
         */
    }
    if (LICENSE_FEATURE_DISPLAY_AS_DEMO) {
        /**
         * your implementation code here
         * your very important initiation codes here
         * put all your secret mechanism in here
         */
    }
    if (LICENSE_FEATURE_BRAND_REMOVAL && LICENSE_FEATURE_DISPLAY_AS_DEMO) {
        /**
         * your implementation code here
         * your very important initiation codes here
         * put all your secret mechanism in here
         */
    }
}

$instance = checker_key_pass::checkkey("549a85845ce8d96e32a75c9d");
if ($instance->get_result_arr() === false) {
    die("Error: " . $instance->get_error_message());
} else {
    define("LICENSE_FEATURE_BRAND_REMOVAL", $instance->brandingRemoval);
    define("LICENSE_FEATURE_DISPLAY_AS_DEMO", $instance->demoDisplay);
    add_action('wp_loaded', 'payload_implementation', 10);
    // die("Success: called");
}
