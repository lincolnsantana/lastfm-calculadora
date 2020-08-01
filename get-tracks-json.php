<?php

//include 'usuario-albums.php';
//include 'album-info.php';

$apiUrl = "http://ws.audioscrobbler.com/2.0/";
$apiKey = "95439be5ca91fc0b25d9299abee8f65d";
$user= "LincolnLopess";

        
        $busca = "$apiUrl?method=user.getTopTracks&user=$user&period=overall&limit=500&api_key=$apiKey&format=json";
        $xml = json_decode(file_get_contents($busca), true);

        $total_paginas = $xml['toptracks']['@attr']['totalPages'];
        //var_dump($teste);
       // $total_paginas = 1;

        //$artist = $xml['toptracks']['track'][0]['artist']['name'];

        $rank = 1;
        for ($i=1; $i <= $total_paginas; $i++) { 
            //echo "$i de $total_paginas \n";

            $busca_por_pagina = "$apiUrl?method=user.getTopTracks&user=$user&period=overall&limit=500&page=$i&api_key=$apiKey&format=json";
            $json_pagina = json_decode(file_get_contents($busca_por_pagina), true);

    // acessar os atributos que vou precisar para manipular
                foreach ($json_pagina['toptracks']['track'] as $nome) {

                    $scrobbles = $nome['playcount'];
                    $duracao_faixa = $nome['duration'];
                    $tempo_total = $duracao_faixa * $scrobbles;

                    //insiro as informaçoes que vou precisar em um array multidimensional
                    $musica_dados[$rank] = array(array('artista' => $nome['artist']['name'], 'faixa' =>$nome['name'], 'tempo total' => $tempo_total));
                    echo "$rank \n";
                    $rank =  $rank + 1;
                }                
        }

        //print_r($json_string);

        
        

        
?>