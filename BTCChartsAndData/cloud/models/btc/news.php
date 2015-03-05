<?php

	
	require_once($_SERVER['DOCUMENT_ROOT'].'cloud/models/main/index.php');
	

	ini_set('display_errors',1);  error_reporting(E_ALL); 
	session_start();
	$_SESSION['count'] =1;

	$resp = getNews();


	echo(json_encode($resp));


	function getNews(){

		$dat = json_decode('[{"targetUrl":"http://www.example.com","requestType":"text","outputAsJson":true,"loadImages":true,"isDebug":true, "timeout":15000, "postDomLoadedTimeout":5000, "userAgent":"PhantomJs.Cloud Rocks", "requestId":"myCustomData01"}]', true);
		$postdata = http_build_query(
			$dat
    	
);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);

$context  = stream_context_create($opts);
$result = file_get_contents('http://api.phantomjscloud.com/batch/browser/v1/6feb6f3726e83a37bcd615db12ccf57eb9b3162e/dfdffdfddgfdf/', false, $context);

echo($result);

		/*

				$startDate = "2012-01-01";
 				$hmm = date('d/m/Y', strtotime($startDate));
  				echo($hmm);

		*/
		$something = file_get_contents("https://www.google.com/search?q=bitcoin&hl=en&gl=us&authuser=0&source=lnt&tbs=cdr:1,cd_min:09/2/2014,cd_max:09/2/2014&tbm=nws");
		$ch =  curl_init('https://www.google.com/search?q=bitcoin&hl=en&gl=us&authuser=0&source=lnt&tbs=cdr:1,cd_min:09/2/2014,cd_max:09/2/2014&tbm=nws');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
echo($result);
		//$splits= explode('<a href="/url?q=', $something);
		//print_r($splits);
		//echo($something);
		return true;
	}


?>