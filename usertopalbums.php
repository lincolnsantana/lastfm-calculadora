<?php

$apiUrl = "http://ws.audioscrobbler.com/2.0/";
$apiKey = "7f802413462c06b6c2ada909f8cf02af";
$user   = "LincolnLopess";
$limit = 5;
$albumslist = array();

                $busca = "$apiUrl?method=user.getTopAlbums&user=$user&limit=$limit&api_key=$apiKey&format=json";
                $json_pagina = json_decode(file_get_contents($busca), true);

                foreach ($json_pagina['topalbums']['album'] as $album_name) {
                    $album = $album_name['name'];
                    $artist = $album_name['artist']['name'];

                    $albumsList[$album] = $artist;
                    //echo "album: $album - artista: $artist \n";
                }
                var_dump($albumsList);

                

?>