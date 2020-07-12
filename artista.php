<?php
$apiUrl = "http://ws.audioscrobbler.com/2.0/";
$apiKey = "95439be5ca91fc0b25d9299abee8f65d";
$method = "artist.getTopAlbums";

$artist = "Queens of the Stone Age";


$consulta = "$apiUrl?method=$method&artist=$artist&api_key=$apiKey";

?>