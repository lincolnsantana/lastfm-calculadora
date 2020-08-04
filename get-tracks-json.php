<?php

        function getTopTracks(){
                $apiUrl = "http://ws.audioscrobbler.com/2.0/";
                $apiKey = "95439be5ca91fc0b25d9299abee8f65d";
                $user= "LincolnLopess";

                $busca = "$apiUrl?method=user.getTopTracks&user=$user&period=overall&limit=500&api_key=$apiKey&format=json";
                $page = json_decode(file_get_contents($busca), true);

                $total_paginas = $page['toptracks']['@attr']['totalPages'];

               // $total_paginas = 3;

                $rank = 1;
                $artista_dados = array();

                        for ($i=1; $i <= $total_paginas; $i++) { 
                                //echo "$i de $total_paginas \n";

                                $busca_por_pagina = "$apiUrl?method=user.getTopTracks&user=$user&period=overall&limit=500&page=$i&api_key=$apiKey&format=json";
                                $json_pagina = json_decode(file_get_contents($busca_por_pagina), true);

                                        // acessar os atributos que vou precisar para manipular
                                        foreach ($json_pagina['toptracks']['track'] as $nome) {

                                                $scrobbles = $nome['playcount'];
                                                $duracao_faixa = $nome['duration'];
                                                $tempo_total = $duracao_faixa * $scrobbles;
                                                $nome_artista = $nome['artist']['name'];
                                                $nome_faixa = $nome['name'];

                                                $artista_dados[$rank] = array('artista' => $nome_artista, 'faixa' => $nome_faixa, 'tempo' => $tempo_total);
                                                                        
                                                //insiro as informaçoes que vou precisar em um array multidimensional
                                                $rank++;
                                        }
                        }
                return $artista_dados;
        }
        

        function getTopArtists(){

                $apiUrl = "http://ws.audioscrobbler.com/2.0/";
                $apiKey = "95439be5ca91fc0b25d9299abee8f65d";
                $user = "LincolnLopess";
            
                //$busca = "$apiUrl?method=user.getTopArtists&user=$user&period=overall&limit=25&api_key=$apiKey&format=json";
                //$paginas = json_decode(file_get_contents($busca), true);
            
                //$total_paginas = $paginas['topartists']['@attr']['totalPages'];
                //print_r($total_paginas);
                $total_paginas = 1;
            
                $top_artists = array();
                $rank = 1;

                        for ($i=1; $i <= $total_paginas; $i++) {

                                $busca_por_pagina = "$apiUrl?method=user.getTopArtists&user=$user&period=overall&limit=10&page=$i&api_key=$apiKey&format=json";
                                $json_pagina = json_decode(file_get_contents($busca_por_pagina), true);
                        
                                        foreach ($json_pagina['topartists']['artist'] as $artista) {
                                                $nome_artista = $artista['name'];
                                                $top_artists[$rank] = array('artista' => $nome_artista, 'tempoTotal' => 0);
                                                
                                                $rank++;
                                        }
                        }
            
                return $top_artists;
            }

            
        $musicas = getTopTracks();
        $artistas = getTopArtists();

                $i = 1;
                foreach ($artistas as $artista) {
                        foreach ($musicas as $musica) {
                                if ($musica['artista'] == $artista['artista']) {    
                                        //echo "deu serto \n";
                                        $artistas[$i]['tempoTotal'] += $musica['tempo']; 
                                } 
                        }
                $i++;     
                }

                $j = 1;
                foreach ($artistas as $artista) {
                        $nome = $artistas[$j]['artista'];
                        $time = $artistas[$j]['tempoTotal'];

                        echo "$nome - $time \n";
                        $j++;
                }

                
?>