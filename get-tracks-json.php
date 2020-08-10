<?php

        // função para obter as faixas e a quantidade de tempo que o usuario ouviu ela

        function getTopTracks(){
                $apiUrl = "http://ws.audioscrobbler.com/2.0/";
                $apiKey = "95439be5ca91fc0b25d9299abee8f65d";
                $user= "LincolnLopess";

                // primeira chamada da api para obter a quantidade total de páginas que contém no perfil do usuario
                $busca = "$apiUrl?method=user.getTopTracks&user=$user&period=overall&limit=500&api_key=$apiKey&format=json";
                $page = json_decode(file_get_contents($busca), true);

                // o valor é atribuido a variavel $total_paginas para utilizarmos na estrutura de repetição
                $total_paginas = $page['toptracks']['@attr']['totalPages'];

                $rank = 1;
                $artista_dados = array();

                // com a quantidade de páginas, iremos fazer chamadas para obter as faixas dos artistas
                        for ($i=1; $i <= $total_paginas; $i++) { 
                                //echo "$i de $total_paginas \n";

                                // o atributo page da api vai alterando de acordo com a estrutura de repetição
                                $busca_por_pagina = "$apiUrl?method=user.getTopTracks&user=$user&period=overall&limit=500&page=$i&api_key=$apiKey&format=json";
                                $json_pagina = json_decode(file_get_contents($busca_por_pagina), true);

                                        // acessar os atributos que vou precisar para manipular
                                        foreach ($json_pagina['toptracks']['track'] as $nome) {

                                                // os atributos que vamos precisar para fazer o calculo de horas: quantidade de scrobbles da faixa e duração
                                                $scrobbles = $nome['playcount'];
                                                $duracao_faixa = $nome['duration'];
                                                // tempo total é o tempo da faixa, vezes a quantidade de vezes que o usuario ouviu a faixa
                                                $tempo_total = $duracao_faixa * $scrobbles;
                                                $nome_artista = $nome['artist']['name'];
                                                //$nome_faixa = $nome['name'];

                                                // inserimos o artista, e o tempo total da faixa em um array, para manipularmos posteriormente
                                                $artista_dados[$rank] = array('artista' => $nome_artista, 'tempo' => $tempo_total);
                                                $rank++;
                                        }
                        }
                return $artista_dados;
        }

        // funcão que vai retornar os principais artistas do usuario, com base em seu perfil da Last.fm
        
        function getTopArtists(int $limite = 5){

                $apiUrl = "http://ws.audioscrobbler.com/2.0/";
                $apiKey = "95439be5ca91fc0b25d9299abee8f65d";
                $user = "LincolnLopess";
            
                //$busca = "$apiUrl?method=user.getTopArtists&user=$user&period=overall&limit=25&api_key=$apiKey&format=json";
                //$paginas = json_decode(file_get_contents($busca), true);
            
                //$total_paginas = $paginas['topartists']['@attr']['totalPages'];
                //print_r($total_paginas);
            
                $lista_artistas = array();
                $rank = 1;

                                $busca_por_pagina = "$apiUrl?method=user.getTopArtists&user=$user&period=overall&limit=$limite&api_key=$apiKey&format=json";
                                $json_pagina = json_decode(file_get_contents($busca_por_pagina), true);
                        
                                        foreach ($json_pagina['topartists']['artist'] as $artista) {
                                                $nome_artista = $artista['name'];
                                                $lista_artistas[$rank] = array('artista' => $nome_artista, 'tempoTotal' => 0);
                                                
                                                $rank++;
                                        }
                        
                return $lista_artistas;
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

                var_dump($artistas);  
?>