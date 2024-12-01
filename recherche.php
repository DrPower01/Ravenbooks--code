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
if ($_GET["mots"]) {
	//Connexion au webservice SOAP
	$ws=new SoapClient("https://ifdjibouti.bibli.fr/ws/connector_out.php?source_id=3",array('trace'=>1));
	
	//Je recherche le mot cuisine
	$mots=$_GET["mots"];
	
	//Recherche des mots (l'expression saisie) 
	$resultat=$ws->pmbesSearch_simpleSearch(0,$mots);
	print $ws->__getLastRequest();
	print $ws->__getLastResponse();
	print "Recherche de ".$mots.", nombre de rÃ©sultats : ".$resultat->nbResults;
	print "<br/>";
	//Si il y a des rÃ©sultats
	if ($resultat->nbResults) {
	  //On va chercher les 5 premiers (si nbResults>5, on limite Ã  5 sinon on prend tout !)
	  $nb=$resultat->nbResults>5 ? 5 : $resultat->nbResults;
	  //On va chercher le contenu des notices au format header
	  $notices=$ws->pmbesSearch_fetchSearchRecords($resultat->searchId,0,$nb,"header");
	
	  //On affiche le rÃ©sultat sous forme de tableau
	  print "<table>";
	  print "<tr><td>Identifiant PMB</td><td>Titre</td></tr>";
	  foreach ($notices as $notice) {
	    print "<td>".$notice->noticeId."</td>"."<td>".$notice->noticeContent."</td></tr>";
	  }
	  print "</table>";
	} else {
	  //Aucun rÃ©sultat !
	  print "Aucun rÃ©sultat pour le mot cuisine";
	}
}
?>

</body></html>