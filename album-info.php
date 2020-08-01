<?php

include 'usuario-albums.php';

//$apiUrl = "http://ws.audioscrobbler.com/2.0/";
//$apiKey = "95439be5ca91fc0b25d9299abee8f65d";
$method_album = "album.getInfo";
$method_track = "track.getInfo";
$autocorrect = 1;

$username = "LincolnLopess";
//$artist = "Queens of the Stone Age";
//$album = "Songs for the Deaf";

//$consulta = "$apiUrl?method=$method_album&user=$username&artist=$artist&album=$album&api_key=$apiKey";


//$resposta_album = file_get_contents($topAlbums);
//echo $resposta_album;


$artista_faixa = array();

foreach ($album_artista as $album_nome => $banda_nome) {

        $info_album = "$apiUrl?method=$method_album&artist=$banda_nome&album=$album_nome&api_key=$apiKey";
        //$album_info = file_get_contents($info_album);

        $albumInfo = new DOMDocument();
        $albumInfo->load($info_album);


        echo "$banda_nome: $album_nome \n";

        $album_faixas = $albumInfo->getElementsByTagName("track");

            foreach ($album_faixas as $faixa) {

                    $nomes_faixa = $faixa->getElementsByTagName("name");
                    $faixa_album = str_replace(" ", "+", $nomes_faixa->item(0)->nodeValue);

                    $duracao_faixas = $faixa->getElementsByTagName("duration");
                    $duracao_faixa = $duracao_faixas->item(0)->nodeValue;
                    

                    //$scrobble_faixas = $faixa->getElementsByTagName("userplaycount");
                    //$scrobble = $scrobble_faixas->item(0)->nodeValue;
                $artista_faixa[$faixa_album] = $duracao_faixa;

                $consulta_faixa = "$apiUrl?method=$method_track&user=$username&artist=$banda_nome&track=$faixa_album&autocorrect=0&api_key=$apiKey";
                $xml_faixas = file_get_contents($consulta_faixa);
                $xml_faixa = simplexml_load_string($xml_faixas);
                //print_r($lastfm);
                $scrobble = $xml_faixa->track->userplaycount;

                $total_scrobbles = 0;
                $total_scrobbles = $total_scrobbles + $scrobble;

                $total_tempo = 0;
                $total_tempo = $total_tempo + ($duracao_faixa * $scrobble);
                
                //variavel local

                //echo "$faixa_album - f:$duracao_faixa  - s:$scrobble -  t:$total_tempo <br>";

            }
                    //$total = $total_tempo;
                    //$horas = floor($total/3600);
                    //$minutos = floor(($total/60) % 60);
                    //$segundos = $total % 60;
                    //echo "horas: $horas:$minutos:$segundos total scrobbles: $total_scrobbles";
                    
    var_dump($artista_faixa);

    }


?>