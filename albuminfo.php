<?php

$apiUrl = "http://ws.audioscrobbler.com/2.0/";
$apiKey = "7f802413462c06b6c2ada909f8cf02af";
$user   = "LincolnLopess";
$artist = "Radiohead";
$album = "In%20Rainbows%20(Special%20Edition%20Disc%201)";
$album_info = array();
$tempoTotal = 0;


                do {
                    $busca = "$apiUrl?method=album.getInfo&user=$user&artist=$artist&album=$album&autocorrect=1&api_key=$apiKey&format=json";
                    $json_pagina = json_decode(file_get_contents($busca), true);
                } while ($json_pagina['error']);
                
                $nome_artista = $json_pagina['album']['artist'];
                $nome_album = $json_pagina['album']['name'];
                
                echo "artista: $nome_artista album: $nome_album";
                //echo "$busca \n";

                foreach ($json_pagina['album']['tracks']['track'] as $nome) {

                    // os atributos que vamos precisar para fazer o calculo de horas: quantidade de scrobbles da faixa e duração
                    $nome_faixa = str_replace(' ', '%20', $nome['name']);
                    echo "nome: $nome_faixa \n";

                    do {
                        $busca_faixa = "$apiUrl?method=track.getInfo&user=$user&artist=$nome_artista&track=$nome_faixa&autocorrect=0&api_key=$apiKey&format=json";
                        $json_track = json_decode(file_get_contents($busca_faixa), true);
                        echo $buscafaixa;
                    } while ($json_track['error']);
                        
                    
                    $nome_faixa = $json_track['track']['name'];
                    $duration = $json_track['track']['duration'];
                    $user_playcount = $json_track['track']['userplaycount'];
                    $time_listened = (($duration * $user_playcount) / 1000) / 3600;
                    echo "$nome_faixa - $time_listened \n";
                    echo "$busca_faixa \n";
                    $tempoTotal += $time_listened;

                    //$track_info[$nome_faixa] = $nome_artista;
                    //$total_time_listened = number_format($time_listened, 2, ',', "");
            }
            $album_info[$nome_album] = $tempoTotal;
            var_dump($album_info);
            
?>