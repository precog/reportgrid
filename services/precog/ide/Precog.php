<?php
/**
 * Provides access to the Precog API platform.
 *
 * Author: Alissa Pajer
 **/

define ("BASE_URL", "http://api.precog.io/v1/");

class PrecogAPI {
 
    private $_tokenID = null;
    private $_baseUrl = null;

    /*
     * Initialize a new PrecogAPI object
     *
     * @param String $token_id
     * @param String $baseurl
     *
     */
    public function __construct($token_id, $baseurl = BASE_URL) 
    {
        $this->_tokenID = $token_id;
        $this->_baseUrl = $baseurl;
    }

     /*
     * Record a new event
     *
     * @param String $path The path in which to store this event
     * @param Array $events event data
     *
     * @return Bool - success/failure
     */
    public function store($path, $events = array()) 
    {
        $path2  = $this->_baseUrl . "vfs/" . $this->cleanPath($path) . "?tokenId=" . $this->_tokenID;
        $return = $this->restHelper($path2, $events, "POST");
        return $return !== false;
    }

    /*
     * Returns the value of the query
     * @params String - raw Quirrel
     *
     * @return Array - an array of values
     */
    public function query($quirrel)
    {
        $path2  = $this->_baseUrl . "vfs/?tokenId=" . $this->_tokenID . "&q=" . urlencode($quirrel);
        $return = $this->restHelper($path2, null, "GET");
        return $return;
    }

    /*********************************
     **** PRIVATE helper function ****
     *********************************/
    private function restHelper($json_endpoint, $params = null, $verb = 'GET') {
        $return = null;

        $http_params = array(
            'http' => array(
                'method' => $verb,
                'ignore_errors' => false
        ));
        if ($params !== null) {
            if ( ($verb == 'POST') || ($verb == 'PUT') ) {


                $header = "Content-Type: application/json";
                $http_params['http']['content'] = json_encode($params);
                $http_params['http']['header'] = $header;
                // workaround for php bug where http headers don't get sent in php 5.2
                if(version_compare(PHP_VERSION, '5.3.0') == -1){
                    ini_set('user_agent', 'PHP-SOAP/' . PHP_VERSION . "\r\n" . $header);
                }
            }//end if
        }//end if ($params !== null)

        $stream_context = stream_context_create($http_params);
        $file_pointer = @fopen($json_endpoint, 'rb', false, $stream_context);
        if (!$file_pointer) {
            $stream_contents = false;
        } else {
            $stream_meta_data = stream_get_meta_data($file_pointer);
            $stream_contents = stream_get_contents($file_pointer);
        }
        if ($stream_contents !== false) {

            /*
             * In the case of we're receiving stream data back from the API,
             * json decode it here.
             */
            if (strlen($stream_contents) > 0) {

                $result = json_decode($stream_contents, true);

                if ($result === null) {
                    error_log("Exception:  " . $stream_contents);
                } else {
                    $return = $result;
                }
            /*
             * In the case of posting data (recordEvent) the API will return a 0
             * length response, in this scenario we're looking for the http 200
             * header code to indicate the data was successfully received.
             */
            } else {

                if (stripos($stream_meta_data['wrapper_data'][0], "200") !== false) {
                    $return = true;
                } else {
                    $return = false;
                }//end inner else
            }//end middle else

        } else {

            /*
             * If there's an error message in the response
             * headers...send that back to the user
             */
            if (isset($http_response_header[0])) {

                $this->isError = true;
                $this->errorMessage = $http_response_header[0];
                $return = false;

            } else {
                throw new Exception("$verb $json_endpoint failed");
            }

        }//end outer else
        return $return;
    }//end restHelper

    private function cleanPath($path)
    {
        return trim($path, '/');
    }
}
?>
