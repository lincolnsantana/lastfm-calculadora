<?php

$apiUrl = "http://ws.audioscrobbler.com/2.0/";
$apiKey = "7f802413462c06b6c2ada909f8cf02af";
$user   = "LincolnLopess";
$artist = "Radiohead";
$track = "No Surprises";

                $busca = "$apiUrl?method=track.getInfo&user=$user&artist=$artist&track=$track&autocorrect=1&api_key=$apiKey&format=json";
                $json_pagina = json_decode(file_get_contents($busca), true);

                $nome_faixa = $json_pagina['track']['name'];
                $duration = $json_pagina['track']['duration'];
                $user_playcount = $json_pagina['track']['userplaycount'];
                $time_listened = (($duration * $user_playcount) / 1000) / 3600;
                //$total_time_listened = number_format($time_listened, 2, ',', "");


                echo "nome: $nome_faixa - $duration - $user_playcount";

?>