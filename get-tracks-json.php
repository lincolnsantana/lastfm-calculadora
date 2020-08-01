<?php

//include 'usuario-albums.php';
//include 'album-info.php';

$apiUrl = "http://ws.audioscrobbler.com/2.0/";
$apiKey = "95439be5ca91fc0b25d9299abee8f65d";
$user= "LincolnLopess";

        
        $busca = "$apiUrl?method=user.getTopTracks&user=$user&period=overall&limit=500&api_key=$apiKey&format=json";
        $xml = json_decode(file_get_contents($busca), true);

        //print_r($xml);
        $total_paginas = $xml['toptracks']['@attr']['totalPages'];
        //var_dump($teste);

        //$artist = $xml['toptracks']['track'][0]['artist']['name'];

        $rank = 1;
        for ($i=1; $i <= $total_paginas; $i++) { 
            //echo "$i de $total_paginas \n";

            $busca_por_pagina = "$apiUrl?method=user.getTopTracks&user=$user&period=overall&limit=500&page=$i&api_key=$apiKey&format=json";
            $json_pagina = json_decode(file_get_contents($busca_por_pagina), true);

    
                foreach ($json_pagina['toptracks']['track'] as $nome) {
                    $nome_faixa = $nome['name'];
                    $scrobbles = $nome['playcount'];
                    $duracao_faixa = $nome['duration'];
                    $nome_artista = $nome['artist']['name'];
                    $tempo_total = $duracao_faixa * $scrobbles;

                    echo "$rank: $nome_artista - $nome_faixa - $tempo_total \n";
                    $rank =  $rank + 1;

                }


        }

               
?>