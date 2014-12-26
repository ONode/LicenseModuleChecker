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
            "http://async777.com:3000"
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
        //    print_r($order);
        //    $print = $this->domains[$this->order];
        // print_r($print);
        return "async777.com";
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
            $array_var = array(
                "domain" => $_SERVER["HTTP_HOST"],
                "product_key" => self::product_key
            );
            //$cb = self::nGet($this->getServerDomain(), 3000, "/api/license/registration/", $array_var);
            $cb = self::curl_post("http://" . $this->getServerDomain() . ":3000/api/license/registration", $array_var);
            //  $cb = self::CallAPI("POST", "http://" . $this->getServerDomain() . ":3000", $array_var);
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
            $cb = self::curl_post("http://" . $this->getServerDomain() . ":3000/api/license/check", $array_var);
            // $cb = self::CallAPI("POST", "http://" . $this->getServerDomain() . ":3000", $array_var);
            //$cb = self::nGet($this->getServerDomain(), 3000, "/api/license/check/", $array_var);
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
// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

    protected static function CallAPI($method = "POST", $url, $data = false, $auth = false)
    {
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        if ($auth) {
            // Optional Authentication:
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, "username:password");
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        if (!$result) {
            throw new Exception("http connection setting: " . curl_error($curl) . "<br/>" . print_r(curl_version(), true) .
                $result
                , 19000);

        }
        curl_close($curl);

        return $result;
    }

    protected static function nGet($domain, $port, $interface, $vars)
    {
        $errno = "";
        $errstr = "";
        $content = http_build_query($vars);
        $httpStream = fsockopen($domain, $port, $errno, $errstr, 4);


        $out = "POST $interface HTTP/1.1\r\n";
        $out .= "Host: $domain\r\n";
        $out .= "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\r\n";

        $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out .= "Content-Length: " . strlen($content) . "\r\n\r\n";
        $out .= "Connection: close\r\n";


        if (!$httpStream) throw new Exception($errstr . $out . $content, $errno);

        fwrite($httpStream, $out);
        fwrite($httpStream, $content);

        $result = "";
        while (!feof($httpStream)) {
            $result = fgets($httpStream, 4096);
        }

        fclose($httpStream);
        return $result;
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
            //CURLOPT_URL => $url,
            // CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            // CURLOPT_FORBID_REUSE => 1,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13',
            // CURLOPT_VERBOSE => 1,
            // CURLOPT_TIMEOUT => 3,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
                'Content-type: application/json',
                'Content-Length: ' . strlen($json))
        );
        $ch = curl_init($url);
        curl_setopt_array($ch, ($options + $defaults));
        $result = curl_exec($ch);

        var_dump($result);


        if (!$result) {
            // trigger_error(curl_error($ch));
            // self::outFail(19000 + curl_errno($ch), "CURL-curl_post error: " . curl_error($ch));
            //   inno_log_db::log_login_china_server_info(-1, 955, curl_error($ch), "-");

            $message2 = $url;
            $message1 = print_r(($options + $defaults), true);

            // $this->message = $message1;
            throw new Exception("http connection setting: " . curl_error($ch) . "<br/>" .

                $message1

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
if (!$instance->get_result_arr()) {
    die("Error: " . $instance->get_error_message());
} else {
    define("LICENSE_FEATURE_BRAND_REMOVAL", $instance->brandingRemoval);
    define("LICENSE_FEATURE_DISPLAY_AS_DEMO", $instance->demoDisplay);
    add_action('wp_loaded', 'payload_implementation', 10);
    //die("Success: called");
}
