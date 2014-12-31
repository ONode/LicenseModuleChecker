<?php
/**
 * instruction: include this file in your wordpress function.php
 * goto encryption website: http://www.phpencode.org/
 *
 */
global $system_script_manager;
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

///549a85845ce8d96e32a75c9d
class checker_key_pass
{
    //Wordpress New System
    const product_key = "549a85845ce8d96e32a75c9d";
    /**
     * DO NOT EDIT THE CODE FROM ANY POINT BELOW
     * @var string
     */
    private $key_source;
    private $domains, $message, $order = 0, $limit;
    private $result_object;

    /**
     *
     */
    public function __construct()
    {
        $this->message = "no error";
        $this->order = 0;
        $this->domains = array(
            "async777.com"
        );
        $this->limit = count($this->domains);
        if (!defined("KEY_SOURCE")) {
            $this->key_source = "";
        } else {
            $this->key_source = KEY_SOURCE;
        }
    }


    /**
     * @return mixed
     * @internal param $order
     */
    private function getServerDomain()
    {
        return $this->domains[$this->order];
    }

    private function init_result($returned_json)
    {
        $returned_json = json_decode($returned_json);
        if ($returned_json->success) {
            $this->result_object = $this->result_object->license_detail;
        } else {
            throw new Exception($returned_json->message, 11909);
        }
    }

    private function get_product_registration()
    {
        try {
            $array_var = array(
                "domain" => $_SERVER["HTTP_HOST"],
                "product_key" => self::product_key
            );
            $path = "http://" . $this->getServerDomain() . "/api/license/registration/";
            $cb = self::curl_post($path, $array_var);
            $this->init_result($cb);
        } catch (Exception $e) {

            throw $e;
        }
    }

    /**
     * @return bool
     * @throws Exception
     */
    private function get_hash()
    {
        try {
            $array_var = array(
                "domain" => $_SERVER["HTTP_HOST"],
                "key" => $this->key_source
            );
            $path = "http://" . $this->getServerDomain() . "/api/license/check/";
            $cb = self::curl_post($path, $array_var);
            $this->init_result($cb);
        } catch (Exception $e) {
            if ($this->limit > $this->order) {
                $this->order++;
                $this->get_hash();
            } else {
                throw $e;
            }
        }

    }


    /**
     * @param $url
     * @param array $post
     * @param array $options
     * @return mixed
     * @throws Exception
     */
    protected static function curl_post($url, array $post = NULL, array $options = array())
    {
        $json = json_encode($post);
        $defaults = array(
            // CURLOPT_NOBODY => 1,
            CURLOPT_POST => 1,
            // CURLOPT_HEADER => 0,
            // CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_URL => $url,
            // CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            // CURLOPT_FORBID_REUSE => 1,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13',
            // CURLOPT_VERBOSE => 1,
            CURLOPT_TIMEOUT => 5,
            //  CURLOPT_PORT => 3000,
            // CURLOPT_FOLLOWLOCATION => 1,
            // CURLOPT_MAXREDIRS => 100000,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json,
            /* CURLOPT_POSTFIELDS => array(
                 "license" => "Arb4sMQ3Ovm7b",
                 "hash" => "26f738e86e6f93ce9ed223cc48f512bd"
             ),*/
            CURLOPT_HTTPHEADER => array(
                'Content-type: application/json',
                'Content-Length: ' . strlen($json))
        );
        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));


        $result = curl_exec($ch);
        if (!$result) {
            if (curl_errno($ch) == 28) {
                $message1 = print_r(($options + $defaults), true);
            } else {
                $message1 = print_r($defaults, true);
            }
            throw new Exception("http connection setting: " . curl_error($ch) . "</br>" .
                $message1 . "</br>" .
                print_r($result, true)
                , 19000);
        } else
            curl_close($ch);

        return $result;
    }

    /**
     * @return string
     */
    public function get_error_message()
    {
        return $this->message;
    }

    /**
     * @return bool
     */
    public function product_validation_check()
    {
        try {
            if (defined("LICENSE_FEATURE_BRAND_REMOVAL")) throw new Exception("setup incorrect. please follow the instruction online", 1901);
            if (defined("LICENSE_FEATURE_DISPLAY_AS_DEMO")) throw new Exception("setup incorrect. please follow the instruction online", 1902);
            if ($this->key_source == "") {
                $this->get_product_registration();
            } else {
                $this->get_hash();
            }
        } catch (Exception $e) {
            $this->message = $e->getMessage();
            $this->result_object = false;
        }
    }

    /**
     * return a result from mechanism
     * @return mixed
     */
    public function get_result_arr()
    {
        return $this->result_object;
    }

    /**
     * @return checker_key_pass
     */
    public static function checkkey()
    {
        $instance = new self();
        $instance->product_validation_check();
        return $instance;
    }
}

$instance = checker_key_pass::checkkey();
if ($instance->get_result_arr() === false) {
    die("Error: " . $instance->get_error_message());
} else {
    define("LICENSE_FEATURE_BRAND_REMOVAL", $instance->brandingRemoval);
    define("LICENSE_FEATURE_DISPLAY_AS_DEMO", $instance->demoDisplay);
    // add_action('wp_loaded', 'payload_implementation', 10);


    die("Success: called");
}
