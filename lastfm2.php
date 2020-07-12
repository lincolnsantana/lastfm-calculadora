<?php
$apiUrl = "http://ws.audioscrobbler.com/2.0/";
$apiKey = "95439be5ca91fc0b25d9299abee8f65d";
$method = "user.gettopalbums";


$user = "LincolnLopess";
$period = "overall";
$limit = 2;

$consulta = "$apiUrl?method=$method&user=$user&period=$period&limit=$limit&api_key=$apiKey";

$resposta = file_get_contents($consulta);

$doc = new DOMDocument();
$doc->load($consulta);

$albums = $doc->getElementsByTagName("artist");


    foreach ($albums as $album) {
        $names = $album->getElementsByTagName("name");
        $name = $names->item(0)->nodeValue;

        $plays = $album->getElementsByTagName("playcount");
        $play = $plays->item(0)->nodeValue;

        $artistas = $album->getElementsByTagName("name");
        $artista = $artistas->item(1)->nodeValue;

    }

    

?>