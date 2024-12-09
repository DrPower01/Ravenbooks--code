<html>
  <head>
    <title>Recherche documentaire</title>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>
    
    <style type='text/css'>
      table {
	border:1px solid #000;
      }
      td {
	border:1px solid #000;
      }
    </style>
  </head>
  <body>
  	<form action='recherche.php'>
  		<input type='text' name='mots' value='<?php print(htmlentities($_GET["mots"],ENT_QUOTES,'utf-8')); ?>'/>
  		<input type='submit' value='OK'/>
  	</form>
	  <?php
$payload = [
    "jsonrpc" => "2.0",
    "method"  => "pmbesSearch_simpleSearch", // Replace with an actual method name
    "params"  => ["Dragon"],               // Replace with actual parameters
    "id"      => uniqid()
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://ifdjibouti.bibli.fr/ws/connector_out.php?source_id=3");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    echo $response;
}

curl_close($ch);

?>