<?php
// PMB SOAP Webservice URL
$wsdl = 'https://ifdjibouti.bibli.fr/ws/connector_out.php?source_id=3'; // Adjust to your endpoint

try {
    $soapClient = new SoapClient($wsdl);
} catch (Exception $e) {
    die("Erreur de connexion au service SOAP : " . $e->getMessage());
}
?>
