<?php

       
                //nome do album e artista - album get info #ok
                //tempo de cada faixa - album get info #ok
                //scrobble das faixas do album #ok;

                $albumsList = array();
                $limit = 2;
                $user = "LincolnLopess";
                
                $apiUrl = "http://ws.audioscrobbler.com/2.0/";
                $apiKey = "7f802413462c06b6c2ada909f8cf02af";
                
                $album_info = array();


                        $busca = "$apiUrl?method=user.getTopAlbums&user=$user&limit=$limit&api_key=$apiKey&format=json";
                        $json_pagina = json_decode(file_get_contents($busca), true);

                                foreach ($json_pagina['topalbums']['album'] as $album_name) {
                                        $album = str_replace(' ', '%20', $album_name['name']);
                                        $artist = str_replace(' ', '%20', $album_name['artist']['name']);
                                        $albumsList[$album] = $artist;
                                }
                                
                                //var_dump($albumsList);

                                foreach ($albumsList as $album => $artist) {

                                        do {
                                                $busca = "$apiUrl?method=album.getInfo&user=$user&artist=$artist&album=$album&autocorrect=1&api_key=$apiKey&format=json";
                                                $json_pagina = json_decode(file_get_contents($busca), true);
                                        } while ($json_pagina['error']);

                                        
                                        //echo "artista: $artist album: $album \n";
                                        $tempoTotal = 0;

                                        foreach ($json_pagina['album']['tracks']['track'] as $nome) {

                                                // os atributos que vamos precisar para fazer o calculo de horas: quantidade de scrobbles da faixa e duração
                                                $nome_faixa = str_replace(' ', '%20', $nome['name']);
                                                //echo "nome: $nome_faixa \n";
                            
                                                do {
                                                    $busca_faixa = "$apiUrl?method=track.getInfo&user=$user&artist=$artist&track=$nome_faixa&autocorrect=1&api_key=$apiKey&format=json";
                                                    $json_track = json_decode(file_get_contents($busca_faixa), true);
                                                } while ($json_track['error']);
                                                    
                                                
                                                $nome_faixa = $json_track['track']['name'];
                                                $duration = $json_track['track']['duration'];
                                                $user_playcount = $json_track['track']['userplaycount'];
                                                $time_listened = (($duration * $user_playcount) / 1000) / 3600;
                                                $tempoTotal += $time_listened;
                            
                                                $total_time_listened = number_format($tempoTotal, 2, ',', "");
                                        }
                                        $album_info[$album] = $total_time_listened;
                                }
                                arsort($album_info);
                                print_r($album_info);
?>