<?php

$discos_lista = array();
$limit = 10;
$user = "LincolnLopess";
$apiUrl = "http://ws.audioscrobbler.com/2.0/";
$apiKey = "58b3181bd5318362464fd0e8fe566a00";


$busca = "$apiUrl?method=user.getTopAlbums&user=$user&limit=$limit&api_key=$apiKey&format=json";
$json_pagina = json_decode(file_get_contents($busca), true);

foreach ($json_pagina['topalbums']['album'] as $disco_nome) {
        $album = $disco_nome['name'];
        $artista = $disco_nome['artist']['name'];
        $discos_lista[$album] = $artista;
}
