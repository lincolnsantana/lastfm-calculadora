<?php
$apiUrl = "http://ws.audioscrobbler.com/2.0/";
$apiKey = "95439be5ca91fc0b25d9299abee8f65d";
$method = "artist.getTopAlbums";

$artist = "Queens of the Stone Age";


$consulta = "$apiUrl?method=$method&artist=$artist&api_key=$apiKey";
$resultado = file_get_contents($consulta);

$doc = new DOMDocument();
$doc->load($consulta);

$topAlbums = $doc->getElementsByTagName("album");
$total = 0;
$nomesAlbums = array();

    foreach ($topAlbums as $album) {
        $nomes = $album->getElementsByTagName("name");
        $nome = $nomes->item(0)->nodeValue;
        $nomesAlbums[] = $nome;

        //echo "$nome <br>";

        $total = $total += 1;
    }

    //echo "$total";

?>