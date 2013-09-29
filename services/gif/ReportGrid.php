<?php
/**
 * Provides access to the Report Grid API platform.
 *
 **/

/*
 * PUT LICENSE HERE
 */

define ("BASE_URL", "http://api.reportgrid.com/services/analytics/v1/");
define ("GIF_URL",  "http://api.reportgrid.com/services/viz/gif/transparent.gif");

class ReportGridAPI {

    private $_tokenID = null;
    private $_baseUrl = null;
    public $isError = false;
    public $errorMessage = null;
    public $forwardIP = false;

    /*
     * Initialize a new ReportGridAPI object
     *
     * @param String $token_id
     *
     */
    public function __construct($token_id, $baseurl = BASE_URL) {
        $this->_tokenID = $token_id;
        $this->_baseUrl = $baseurl;
    }

    /*
     * Create a new token
     *
     * @param String path         The path, relative to the parent's path, that will be associated with this tokenId
     * @param String expires      The expiration date of the token, measured in milliseconds from the start of the Unix Epoch, UTC time
     * @param String read         Does this token have read permissions
     * @param String write        Does this token have write permissions
     * @param String share        Does this token have share permissions
     * @param String explore      Does this token have explore permissions
     * @param String order        The maximum number of sets in an intersection query
     * @param String limit        The maximum number of properties associated with an events
     * @param String depth        The maximum depth of properties associated with events
     * @param String lossless     A bool value
     *
     * @return String token
     */
    public function newToken($path = "", $expires = null, $read = null, $write = null, $share = null, $explore = null, $order = null, $limit = null, $depth = null, $tags = null, $lossless = null) {
        $params = array();
        $params['path'] = $path;

        $perms = array();
        if(null !== $read)
            $perms['read'] = $read;
        if(null !== $write)
            $perms['write'] = $write;
        if(null !== $share)
            $perms['share'] = $share;
        if(null !== $explore)
            $perms['explore'] = $explore;
        if(null !== $read)
            $params['permissions'] = $perms;
        if(null !== $expires)
            $params['expires'] = $expires;

        $limits = array();
        if(null !== $order)
            $limits['order'] = $order;
        if(null !== $limit)
            $limits['limit'] = $limit;
        if(null !== $depth)
            $limits['depth'] = $depth;
        if(null !== $tags)
            $limits['tags']  = $tags;
        if(null !== $lossless)
            $limits['lossless']  = $lossless;
        $params['limits'] = $limits;

        $return = $this->restHelper($this->_baseUrl . "tokens?tokenId=" . $this->_tokenID, $params, "POST");

        return $return;

    }

    /*
     * Return all tokens this->_tokenId is a parent of
     *
     * @returns Array - All tokens associated with this->_tokenId
     */
    public function tokens() {
        $path   = $this->_baseUrl . "tokens/children?tokenId=" . $this->_tokenID;
        $return = $this->restHelper($path, null, "GET");
        return $return;
    }

    /*
     * Return an array of data about a specific token
     *
     * @param String $token Token
     *
     * @return Mixed Array with all the information about this token or FALSE if the token does not exist.
     */
    public function token($token) {
        $path   = $this->_baseUrl . "tokens/" . $token . "?tokenId=" . $this->_tokenID;
        $return = $this->restHelper($path, null, "GET");
        return is_array($return) ? $return : false;
    }

    /*
     * Delete an existing token
     *
     * @param String - Token
     *
     * @return Boolean - success/failure
     */
    public function deleteToken($token) {
        $path   = $this->_baseUrl . "tokens/" . $token . "?tokenId=" . $this->_tokenID;
        $return = $this->restHelper($path, null, "DELETE");
        return $return;
    }

    /*
     * Record a new event
     *
     * @param String $path The path in which to store this event
     * @param Array $events event data
     * @param Array $options Tracking options
     *
     * @return Bool - success/failure
     */
    public function track($path, $events = array(), $options = null) {
        $path   = $this->_baseUrl . "vfs/" . $this->cleanPath($path) . "?tokenId=" . $this->_tokenID;
        if (null !== $options && array_key_exists('rollup', $options)) {
          $path = $path . "&rollup=" . $options['rollup'];
        }
        $return = $this->restHelper($path, $events, "POST");
        return $return !== false;
    }

    public function gifUrl($path, $events, $options = null) {
        $args = array("tokenId=" . $this->_tokenID, "path=" . urlencode($path), "event=" . urlencode(json_encode($events)));
        if(BASE_URL != $this->_baseUrl)
            $args[] = 'service=' . urlencode($this->_baseUrl);
        if($options) {
            foreach ($options as $key => $value) {
                $args[] = $key . "=" . urlencode($value);
            }
        }
        return GIF_URL . "?" . implode('&', $args);
    }

    /*
     * Returns the children of the path
     * @params String - path
     * @params String - 'all', 'path' or 'property'
     * @params String - property name
     *
     * @return Array - values
     */
    public function children($path, $type = 'all', $property = '')
    {
        $type   = $property ? 'property' : $type;
        $path   = $this->_baseUrl . "vfs/" . $this->cleanPath($path) . ($property ? "/" . $this->normalizeProperty($property) : "") . "?tokenId=" . $this->_tokenID;
        $return = $this->restHelper($path, null, "GET");
        if($type == 'path')
        {
            $return = array_filter($return, array($this, 'notDotFilter'));
        } else if($type == 'property') {
            $return = array_filter($return, array($this, 'dotFilter'));
        }
        return $return;
    }

    /*
     * Returns the count of the specified event, event + property or event + property + value
     * @params String - path
     * @params String - 'all', 'path' or 'property'
     * @params String - property name
     * @params String - value
     * @params Int - start timestamp in milliseconds
     * @params Int - end timestamp in milliseconds
     *
     * @return Int - count
     */
    public function count($path, $event, $property = '', $value = '', $start = '', $end = '')
    {
        $value  = $value ? "/values/" . urlencode(json_encode($value)) : '';
        $time   = $start ? '&start=$start&end=$end' : '';
        $path   = $this->_baseUrl . "vfs/" . $this->cleanPath($path) . "/" . $this->normalizeProperty($event).$this->normalizeProperty($property).$value."/count?tokenId=" . $this->_tokenID . $time;
        $return = $this->restHelper($path, null, "GET");
        return is_array($return) ? 0 : $return;
    }

    /*
     * Returns the values for the event + property combination
     * @params String - path
     * @params String - event name
     * @params String - property name
     * @params Int - limit of values to return
     * @params Bool - sets the order descending (from top to bottom - default) or ascending (from bottom to top)
     *
     * @return Array - values
     */
    public function values($path, $event, $property, $limit = 0, $descending = true)
    {
        $bounds = $limit ? ($descending ? "/top/$limit" : "/bottom/$limit") : '';
        $path   = $this->_baseUrl . "vfs/" . $this->cleanPath($path) . "/" . $this->normalizeProperty($event).$this->normalizeProperty($property)."/values$bounds?tokenId=" . $this->_tokenID;
        $return = $this->restHelper($path, null, "GET");
        return $return;
    }

    /*
     * Returns the count of the specified event, event + property or event + property +value
     * @params String - path
     * @params String - 'all', 'path' or 'property'
     * @params String - property name
     * @params String - value
     * @params String - periodicity: 'eternity', 'year', 'month', 'week', 'day', 'hour', minute
     * @params Int - start timestamp in milliseconds
     * @params Int - end timestamp in milliseconds
     *
     * @return Array - values
     */
    public function series($path, $event, $property = '', $value = '', $periodicity = 'day', $start = '', $end = '')
    {
        $value  = $value ? "/values/" . urlencode(json_encode($value)) : '';
        $start  = $this->defaultStart($start);
        $end    = $this->defaultEnd($end);
        $time   = "&start=$start&end=$end";
        $path   = $this->_baseUrl . "vfs/" . $this->cleanPath($path) . "/" . $this->normalizeProperty($event).$this->normalizeProperty($property).$value."/series/$periodicity?tokenId=" . $this->_tokenID . $time;
        $return = $this->restHelper($path, null, "GET");
        return $return;
    }

    /*
     * Returns the "mean" of the specified property over time
     * @params String - path
     * @params String - event
     * @params String - property name
     * @params String - periodicity: year', 'month', 'week', 'day', 'hour', minute
     * @params Int - start timestamp in milliseconds
     * @params Int - end timestamp in milliseconds
     *
     * @return Array - values
     */
    public function means($path, $event, $property, $periodicity = 'day', $start = '', $end = '')
    {
        return $this->stats("means", $path, $event, $property, $periodicity, $start, $end);
    }

    /*
     * Returns the "standard deviations" of the specified property over time
     * @params String - path
     * @params String - event
     * @params String - property name
     * @params String - periodicity: year', 'month', 'week', 'day', 'hour', minute
     * @params Int - start timestamp in milliseconds
     * @params Int - end timestamp in milliseconds
     *
     * @return Array - values
     */
    public function standardDeviations($path, $event, $property, $periodicity = 'day', $start = '', $end = '')
    {
        return $this->stats("standardDeviations", $path, $event, $property, $periodicity, $start, $end);
    }

    function stats($type, $path, $event, $property, $periodicity, $start, $end)
    {
        $start  = ($periodicity == 'eternity' && !$start) ? '' : $this->defaultStart($start);
        $end    = ($periodicity == 'eternity' && !$end) ? '' : $this->defaultEnd($end);
        $time   = $start ? "&start=$start&end=$end" : '';
        $path   = $this->_baseUrl . "vfs/" . $this->cleanPath($path) . "/" . $this->normalizeProperty($event).$this->normalizeProperty($property)."/series/$periodicity/$type?tokenId=" . $this->_tokenID . $time;
        $return = $this->restHelper($path, null, "GET");
        return $return;
    }

    /*
     * Returns a timeseries or count (when used with the eternity periodicity - defaul) of occurrences of the event when one or more properties
     * are set to a certain value. You can use the 'where' parameter to set the conditions of the query.
     * @params String - path
     * @params String - where, associative array where the keys are the property names prefixed with the event and the value is the filter.
     * @params String - periodicity: 'eternity', 'year', 'month', 'week', 'day', 'hour', minute
     * @params Int - start timestamp in milliseconds
     * @params Int - end timestamp in milliseconds
     *
     * @return Array - values
     */
    public function search($path, $where, $periodicity = 'eternity', $start = '', $end = '')
    {
        $start  = ($periodicity == 'eternity' && !$start) ? '' : $this->defaultStart($start);
        $end    = ($periodicity == 'eternity' && !$end) ? '' : $this->defaultEnd($end);
        $time   = $start ? "&start=$start&end=$end" : '';
        $url    = $this->_baseUrl . "search?tokenId=" . $this->_tokenID . $time;
        $return = $this->restHelper($url, array(
            'select' => $periodicity == 'eternity' ? "count" : "series/$periodicity",
            'from'   => $path,
            'where'  => $this->whereArray($where)
        ), "POST");
        return $return;
    }

    /*
     * Returns the intersections of the specified properties. The "properties" argument must be an array of associative arrays that contains the
     * following key/value pairs: property (event name + property name), limit (integer value), order ('descending' or 'ascending')
     * @params String - path
     * @params Array - properties
     * @params String - periodicity: 'eternity', 'year', 'month', 'week', 'day', 'hour', minute
     * @params Int - start timestamp in milliseconds
     * @params Int - end timestamp in milliseconds
     *
     * @return Array - values
     */
    public function intersect($path, $properties, $periodicity = 'eternity', $start = '', $end ='')
    {
        $start  = ($periodicity == 'eternity' && !$start) ? '' : $this->defaultStart($start);
        $end    = ($periodicity == 'eternity' && !$end) ? '' : $this->defaultEnd($end);
        $time   = $start ? "&start=$start&end=$end" : '';
        $url    = $this->_baseUrl . "intersect?tokenId=" . $this->_tokenID . $time;
        $return = $this->restHelper($url, array(
            'select' => $periodicity == 'eternity' ? "count" : "series/$periodicity",
            'from'   => $path,
            'properties'  => $properties
        ), "POST");
        return $return;
    }

    /*
     * Returns the histogram count for each value in the specified event + property pair.
     * @params String - path
     * @params String - event name
     * @params String - property name
     * @params Int - start timestamp in milliseconds
     * @params Int - end timestamp in milliseconds
     *
     * @return Array - values
     */
    public function histogram($path, $event, $property, $start = null, $end = null)
    {
        $time   = $start ? '&start=$start&end=$end' : '';
        $path   = $this->_baseUrl . "vfs/" . $this->cleanPath($path) . "/" . $this->normalizeProperty($event).$this->normalizeProperty($property)."/histogram?tokenId=" . $this->_tokenID . $time;
        $return = $this->restHelper($path, null, "GET");
        return $return;
    }

/****************************************************************************/
/****************************************************************************/
    private function whereArray($ob)
    {
        $where = array();
        foreach($ob as $key => $value)
            $where[] = array('variable' => $key, 'value' => $value);
        return $where;
    }

    private function defaultStart($start)
    {
        return $start ? $start : (time() - 7 * 24 * 60 * 60) * 1000;
    }

    private function defaultEnd($end)
    {
        return $end ? $end : (time() + 24 * 60 * 60) * 1000;
    }

    private function dotFilter($v)
    {
        return $v[0] == '.';
    }

    private function notDotFilter($v)
    {
        return $v[0] != '.';
    }

    private function normalizeProperty($p)
    {
        return $p ? ($p[0] == '.' ? $p : ".$p") : '';
    }

    /*********************************
     **** PRIVATE helper function ****
     *********************************/
    private function ip()
    {
        $headers = @apache_request_headers();
        if($headers && isset($headers['X-Forwarded-For']))
            return trim(array_shift(explode(',', $headers['X-Forwarded-For'])));
        return array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)
            ? $_SERVER['HTTP_X_FORWARDED_FOR']
            : (array_key_exists('REMOTE_ADDR', $_SERVER)
            ? $_SERVER['REMOTE_ADDR']
            : null);
    }

    private function restHelper($json_endpoint, $params = null, $verb = 'GET') {
        $return = null;

        $http_params = array(
            'http' => array(
                'method' => $verb,
                'ignore_errors' => false
        ));
        if ($params !== null) {
            if ( ($verb == 'POST') || ($verb == 'PUT') ) {
                $header = "Content-Type: application/json\r\n";
                $http_params['http']['content'] = json_encode($params);
                $http_params['http']['header'] = $header;
                if($this->forwardIP && ($ip = $this->ip())) {
                    $http_params['http']['header'] .= "X-Forwarded-For: $ip\r\n";
                }
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
