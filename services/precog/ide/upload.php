<?php

define('ISCLI', PHP_SAPI === 'cli');
$GLOBALS['allowedformats'] = array("json");

// UTILS
function get_request_headers() {
    $headers = array();
    foreach($_SERVER as $key => $value) {
        if(strpos($key, 'HTTP_') === 0) {
            $headers[str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))))] = $value;
        }
    }
    return $headers;
}

function message($msg) {
    header('Content-Type: application/json');
    jsonmessage(json_encode($msg));
}

function jsonmessage($msg) {
	die($msg);
}

function error($msg) {
	header('HTTP/1.1 500 Internal Server');
	message(array('error' => $msg, 'code' => 500));
}

function jsonerror($msg) {
	header('HTTP/1.1 500 Internal Server');
	jsonmessage($msg);
}

function statusfile($contentfile) {
	return $contentfile . ".status.json";
}

function writestatus($file, $content) {
	file_put_contents(statusfile($file), json_encode($content));
}

function changestatuspermissions($file) {
	chmod(statusfile($file), 0666);
}

function removestatus($file) {
	unlink(statusfile($file));
}

function tmpstatusfile($id) {
	$dir = sys_get_temp_dir();
	if("/" != substr($dir, -1)) $dir .= "/";
	return "$dir/$id";
}

function cliterminate($file) {
	unlink($file);
	sleep(5);
	removestatus($file);
	die;
}

function clierror($file, $error) {
	writestatus($file, array("error" => $error, "code" => 500 ));
	cliterminate($file);
}

function clistatus($file, $done, $total, $failures) {
	writestatus($file, array("done" => $done, "total" => $total , "failures" => $failures ));
	if($done == $total)
		cliterminate($file);
}

// ACTIONS
function status($id) {
	$file = statusfile(tmpstatusfile($id));
	if(is_file($file)) {
		$content = file_get_contents($file);
		$json = json_decode($content, true);
		if(isset($json["error"]))
			jsonerror($content);
		else
			jsonmessage($content);
	} else {
		error("error creating status file");
	}
}

function parsejson($content) {
	$records = array();
	$errors  = 0;
	$total   = 0;
	try {
		$json = json_decode($content, true);
		if(null == $json) {
			throw new Exception("Invalid JSON", 1);
		}
		if(isset($json[0])) // is indexed
			$records = $json;
		else
			$records[] = array($json);
	} catch(Exception $e) {
		// try one json per line
		$lines = explode("\n", $content);
		foreach ($lines as $key => $value) {
			if(!$value) continue;
			$value = trim($value);
			$total++;
			if(!(substr($value, 0, 1) == '{' && substr($value, -1) == '}') || null == ($record = json_decode($value, true)))
				$errors++;
			else
				$records[] = $record;
		}
	}
	if($errors == $total) // all errors, invalid file format
		return null;
	else
		return array( "records" => $records, "failures" => $errors);
}

function track($file, $format, $path, $token, $service) {
	require("Precog.php");
	// open file
	$content = file_get_contents($file);
	$result;
	// parse contents
	switch($format) {
		case "json":
			$result = parsejson($content);
			break;
	}
	if(null == $result) {
		clierror($file, "invalid content for " . $format);
	}
	// calculate totals
	$total = count($result['records']) + $result['failures'];
	$current = $result['failures'];
	clistatus($file, $current, $total, $result['failures']);

	if(substr($service, -1) != '/')
		$service .= "/";
	if(substr($path, -1) != '/')
		$path .= "/";

	$precog = new PrecogAPI($token, $service);
	// iterate on each line
	foreach ($result['records'] as $key => $value) {
		//	track single event
		if(!$precog->store($path, $value)) {
			$result['failures']++;
			echo $precog->errorMessage ."\n";
		}
		//	write status file
		clistatus($file, ++$current, $total, $result['failures']);
	}
	// delete $filename
	unlink($file);
	// write final status file
	clistatus($file, $total, $total, $result['failures']);
	die("stored $total events ({$result['failures']} failures)");
}

function execute($id, $upload, $path, $token, $service) {
	// move the file to a temp location
	$file = tmpstatusfile($id);
	move_uploaded_file($upload['tmp_name'], $file);
	chmod($file, 0666);
	// writes the initial status file
	clistatus($file, 0, -1, 0);
	changestatuspermissions($file);
	// prepare the threaded service
	$format = strtolower(array_pop(explode('.', $upload['name'])));
	if(!in_array($format, $GLOBALS['allowedformats'])) {
		$format = 'json';
	}
	$script = __FILE__;
	$run = "php -q $script";
	$cargs = array();
	foreach (array($file, $format, $path, $token, $service) as $key => $value) {
		$cargs[] = escapeshellarg($value);
	}
	$run .= ' ' . implode(' ', $cargs);
	// EXECUTE
	`$run > /dev/null &`;
}

// APP
if(ISCLI) {
	try {
		// check arguments length
		if(!isset($argv) || count($argv) != 6) {
			// no filename ... no way to send a proper message
			die("no arguments or invalid number");
		}
		array_shift($argv);
		// get arguments
		list($file, $format, $path, $token, $service) = $argv;

		if(!is_file($file))
			die("no data file");
		if(!$format)  clierror($file, "invalid format argument");
		if(!$path)    clierror($file, "invalid path argument");
		if(!$token)   clierror($file, "invalid token argument");
		if(!$service) clierror($file, "invalid service argument");
		track($file, $format, $path, $token, $service);
	} catch(Exception $e) {
		$dir = dirname(__FILE__);
		file_put_contents($dir."/clierror", $e);
	}
} elseif(isset($_GET['uuid'])) {
	status($_GET['uuid']);
} elseif (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
	if(@$_FILES["file"]["error"])
	{
		error($_FILES["file"]["error"]);
	}
	$headers = get_request_headers();

	if(!isset($headers["X-Precog-Uuid"])) error("UUID is not in the request");
	$id = $headers["X-Precog-Uuid"];

	if(!isset($headers["X-Precog-Path"])) error("Path is not in the request");
	$path = $headers["X-Precog-Path"];

	if(!isset($headers["X-Precog-Token"])) error("Token is not in the request");
	$token = $headers["X-Precog-Token"];

	if(!isset($headers["X-Precog-Service"])) error("Service is not in the request");
	$service = $headers["X-Precog-Service"];

	if(!isset($headers["X-File-Name"])) error("File Name is not in the request");
	$filename = $headers["X-File-Name"];


	$file = $_FILES["file"];

	execute($id, $file, $path, $token, $service);
	message(array("message" => "tracking service started: " . tmpstatusfile($id) . " $path $token $service"));
	exit();
} else {
	error("Invalid Call");
}


