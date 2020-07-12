<?php
$apiUrl = "http://ws.audioscrobbler.com/2.0/";
$apiKey = "95439be5ca91fc0b25d9299abee8f65d";
$method = "album.getInfo";


$artist = "Queens of the Stone Age";
$album = "Songs for the Deaf";


$consulta = "$apiUrl?method=$method&artist=$artist&album=$album&api_key=$apiKey";

$resposta = file_get_contents($consulta);

$doc = new DOMDocument();
$doc->load($consulta);

$musicas = $doc->getElementsByTagName("track");


    foreach ($musicas as $musica) {

        $names = $musica->getElementsByTagName("name");
        $name = $names->item(0)->nodeValue;

        $durations = $musica->getElementsByTagName("duration");
        $duration = $durations->item(0)->nodeValue;

        $total = $duration;
        $horas = floor($total / 3600);
        $minutos = floor(($total - ($horas * 3600)) / 60);
        $segundos = floor($total % 60);


        printf("Nome: $name Duração: %02d:%02d <br>", $minutos, $segundos);
    }



?>