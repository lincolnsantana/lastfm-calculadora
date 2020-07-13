<?php

$apiUrl = "http://ws.audioscrobbler.com/2.0/";
$apiKey = "95439be5ca91fc0b25d9299abee8f65d";
$method = "album.getInfo";
//$lang = "por";

$username = "LincolnLopess";
$artist = "Queens of the Stone Age";
$album = "Songs for the Deaf";

$consulta = "$apiUrl?method=$method&artist=$artist&album=$album&username=$username&api_key=$apiKey";

$resposta = file_get_contents($consulta);

echo $resposta;


/*

$doc = new DOMDocument();
$doc->load($consulta);

$musicas = $doc->getElementsByTagName("track");

echo "Nome do Album: $album <br>";
echo "Faixas: <br>";


$totalDuracao = 0;

    foreach ($musicas as $musica) {

        $names = $musica->getElementsByTagName("name");
        $name = $names->item(0)->nodeValue;

        $durations = $musica->getElementsByTagName("duration");
        $duration = $durations->item(0)->nodeValue;
              
        $total = $duration;
        $horas = floor($total/3600);
        $minutos = floor(($total - ($horas * 3600)) / 60);
        $segundos = floor($total % 60);
        
        $totalDuracao = $totalDuracao += $duration; 
        printf("Nome: $name Duração: %02d:%02d <br>", $minutos, $segundos);
    }

    //fiz dnv a mesma formula por preguica
    $conversaoDuracao = $totalDuracao;
    $horasTotal = floor($conversaoDuracao/3600);
    $minutosTotal = floor(($conversaoDuracao - ($horasTotal * 3600)) / 60);
    $segundosTotal = floor($totalDuracao % 60);

    printf("Duracao total do Album: %02d:%02d:%02d", $horasTotal, $minutosTotal, $segundosTotal);
*/


?>