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
    const product_key = "____place_your_product_code___here_____";
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
            "http://hesk.async777.com"
        );
        $this->limit = count($this->domains);
        if (!defined("KEY_SOURCE")) {
            $this->key_source = "";
        } else {
            $this->key_source = KEY_SOURCE;
        }
    }


    /**
     * @param $order
     * @return mixed
     */
    private function getServerDomain($order)
    {
        return $this->domains[$order];
    }

    private function init_result($returned_json)
    {
        $this->result_object = json_decode($returned_json);
        //if (intval($this->result_object->result) > 1) throw new Exception($this->result_object->msg, $this->result_object->result);
        if (!$this->result_object->success) {
            throw new Exception($this->result_object->message, 11909);
        } else {
            $this->result_object = $this->result_object->license_detail;
        }
    }

    private function get_product_registration()
    {
        try {
            $cb = $this->curl_post($this->getServerDomain($this->order) . "api/license/registration",
                array(
                    "domain" => $_SERVER["HTTP_HOST"],
                    "product_key" => self::product_key
                ));
            $this->init_result($cb);
        } catch (Exception $e) {
            if ($this->limit > $this->order) {
                $this->order++;
                $this->get_product_registration();
            } else {
                throw $e;
            }
        }
    }

    /**
     * @return bool
     * @throws Exception
     */
    private function get_hash()
    {
        try {

            $cb = $this->curl_post($this->getServerDomain($this->order) . "/api/license/check",
                array(
                    "domain" => $_SERVER["HTTP_HOST"],
                    "key" => $this->key_source
                ));
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
        $defaults = array(
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POSTFIELDS => http_build_query($post),
            CURLOPT_SSL_VERIFYPEER => FALSE,
        );
        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        if (!$result = curl_exec($ch)) {
            // trigger_error(curl_error($ch));
            // self::outFail(19000 + curl_errno($ch), "CURL-curl_post error: " . curl_error($ch));
            //   inno_log_db::log_login_china_server_info(-1, 955, curl_error($ch), "-");
            throw new Exception(curl_errno($ch), 19000);
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
            } else
                $this->get_hash();
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
if (!$instance->get_result_arr()) {
    die("Error: " . $instance->get_error_message());
} else {
    define("LICENSE_FEATURE_BRAND_REMOVAL", $instance->brandingRemoval);
    define("LICENSE_FEATURE_DISPLAY_AS_DEMO", $instance->demoDisplay);
    add_action('wp_loaded', 'payload_implementation', 10);
    $destinations = NULL;
}
